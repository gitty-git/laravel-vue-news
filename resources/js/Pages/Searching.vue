<template>
    <div>
        <div class="uppercase mt-2 font-bold">
            <div v-if="usersCounted > 0 || postsCounted > 0">
                By request "{{ search }}" found {{ postsCounted }}
                <span v-if="postsCounted === 1">post</span>
                <span v-else>posts</span>
                and {{ usersCounted }}
                <span v-if="usersCounted === 1">user</span>
                <span v-else>users</span>
            </div>
            <div v-else>By Request "{{ search }}" Nothing Found</div>
        </div>

        <div v-if="localPosts.data.length > 0" class="mt-4 font-bold text-sm">
            <div v-if="localPosts.data.length === 1">Post:</div>
            <div v-else>Posts:</div>
        </div>

        <!--POSTS-->
        <div class="my-4">
            <div class="flex border-gray-200 font-serif">
                <!--LEFT-->
                <div class="w-1/2 mr-4">
                    <div v-for="post in localPosts.data.filter((x, i) => (i % 2 === 0))"
                         class="border-gray-200 border-b-2 py-4 first-child last-child"
                    >
                        <inertia-link class="hover:text-gray-600 duration-200" :href="'/post/' + post.slug">
                            <div class="flex">
                                <img class="w-1/3 h-full mr-4 mb-4" :src="post.image" alt="">

                                <div class="flex w-2/3 flex-col">
                                    <div class="font-bold mb-2">{{ post.title }}</div>

                                    <div class="text-13 mb-2 text-gray-600">{{ post.brief }}</div>

                                    <!--CREATED AT-->
                                    <div class="flex h-full font-sans uppercase text-gray-400">
                                        <div class="flex flex-wrap">
                                            <div class="text-xs">
                                                {{`
                                            ${new Date(post.created_at).toLocaleString('default', {month: 'long'})}
                                            ${new Date(post.created_at).getDate()},
                                            ${new Date(post.created_at).getFullYear()}
                                            ` }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </inertia-link>
                    </div>
                </div>

                <!--RIGHT-->
                <div :class="{'border-none' : posts.data.length === 1}" class="w-1/2 pl-4 border-l-2 border-gray-200">
                    <div v-for="post in localPosts.data.filter((x, i) => (i % 2 !== 0))"
                         class="border-gray-200 border-b-2 py-4 first-child last-child">
                        <inertia-link class="hover:text-gray-600 duration-200" :href="'/post/' + post.slug">
                            <div class="flex">
                                <img class="w-1/3 h-full mr-4 mb-4" :src="post.image" alt="">
                                <div class="flex w-2/3 flex-col">
                                    <div class="font-bold mb-2">{{ post.title }}</div>

                                    <div class="text-13 mb-2 text-gray-600">{{ post.brief }}</div>

                                    <!--CREATED AT-->
                                    <div class="flex h-full font-sans uppercase text-gray-400">
                                        <div class="flex flex-wrap">
                                            <div class="text-xs">
                                                {{`
                                            ${new Date(post.created_at).toLocaleString('default', {month: 'long'})}
                                            ${new Date(post.created_at).getDate()},
                                            ${new Date(post.created_at).getFullYear()}
                                            ` }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </inertia-link>
                    </div>
                </div>
            </div>

            <!--LOAD MORE POSTS-->
            <div class="mt-4 flex justify-center" v-if="localPosts.next_page_url">
                <div class="font-sans cursor-pointer text-xs font-bold uppercase bg-gray-200 px-3 py-1 rounded">
                    <div @click="loadMorePosts">
                        Show More Posts
                    </div>
                </div>
            </div>
        </div>

        <div v-if="localUsers.data.length > 0">
            <div class="border-t-4 mb-2 border-gray-400 w-full" v-if="localPosts.data.length !== 0"></div>

            <div class="font-bold mb-4 text-sm">
                <div v-if="localUsers.data.length === 1">User:</div>
                <div v-else>Users:</div>
            </div>
        </div>

        <!--USERS-->
        <div class="flex flex-wrap">
            <div class="w-1/3 flex font-serif mb-4" v-for="user in localUsers.data">
                <img class="w-12 h-12 mr-4" :src="user.profile_photo_url" alt="">

                <div class="mr-2">
                    <inertia-link class="font-bold text-sm hover:text-gray-400 duration-200"
                                  :href="`/user/${user.id}` ">{{ user.name }}
                    </inertia-link>

                    <span v-for="role in user.roles"
                          class="bg-gray-200 font-sans text-xs mr-1 px-2 uppercase text-xs rounded-full"
                          v-if="role.role === 'admin' || role.role === 'redactor'">
                            {{role.role}}
                    </span>

                    <div class="mb-2 font-sans text-xs uppercase text-gray-400">
                        <span v-if="user.posts_count > 1">{{ user.posts_count }} posts,</span>
                        <span v-else-if="user.posts_count === 1">{{ user.posts_count }} post,</span>
                        <span v-else>No posts,</span>

                        <span v-if="user.comments_count > 1">{{ user.comments_count }} comments.</span>
                        <span v-else-if="user.comments_count === 1">{{ user.comments_count }} comment.</span>
                        <span v-else>No comments.</span>
                    </div>
                </div>
            </div>
        </div>

        <!--LOAD MORE USERS-->
        <div class="mt-4 flex justify-center" v-if="this.localUsers.next_page_url">
            <div class="font-sans cursor-pointer text-xs font-bold uppercase mb-4 bg-gray-200 px-3 py-1 rounded">
                <div @click="loadMoreUsers">
                    Show More Users
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import NewsLayout from "@/Layouts/NewsLayout";
export default {
    layout: NewsLayout,
    props: ["posts", "users", "postsCounted", "usersCounted", "search"],
    name: "SearchPosts",
    data() {
        return {
            localPosts: this.posts,
            localUsers: this.users
        }
    },
    methods: {
        loadMorePosts() {
            if (this.localPosts.next_page_url) {
                axios.get(this.localPosts.next_page_url, {params: {loadMoreType: 'morePosts'}}).then(response => {
                    console.log(response)
                    this.localPosts = {
                        ...response.data,
                        data: [...this.localPosts.data, ...response.data.data]
                    }
                })
            }
        },

        loadMoreUsers() {
            if (this.localUsers.next_page_url) {
                axios.get(this.localUsers.next_page_url, {params: {loadMoreType: 'moreUsers'}}).then(response => {
                    console.log(response)
                    this.localUsers = {
                        ...response.data,
                        data: [...this.localUsers.data, ...response.data.data]
                    }
                })
            }
        },
    }
}
</script>

<style scoped>

</style>
