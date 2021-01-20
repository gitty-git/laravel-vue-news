<template>
    <div>
        <div v-if="usersCounted > 0 || postsCounted > 0">
            By request "{{ search }}" found {{ postsCounted }}
            <span v-if="postsCounted > 0">posts</span>
            <span v-else-if="postsCounted === 0">posts</span>
            <span v-else>post</span>
            and {{ usersCounted }}
            <span v-if="usersCounted > 0">users</span>
            <span v-else-if="usersCounted === 0">users</span>
            <span v-else>user</span>
        </div>
        <div v-else>Nothing Found</div>


        <!--POSTS-->
        <div class="flex pt-4 border-gray-200 font-serif">
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
                                <div class="flex h-full sans uppercase text-gray-400">
                                    <div class="flex flex-wrap">
                                        <div class="text-xs">
                                            {{
                                                `
                                            ${new Date(post.created_at).toLocaleString('default', {month: 'long'})}
                                            ${new Date(post.created_at).getDate()},
                                            ${new Date(post.created_at).getFullYear()}
                                            `
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </inertia-link>
                </div>
            </div>

            <!--RIGHT-->
            <div class="w-1/2 pl-4 border-l-2 border-gray-200">
                <div v-for="post in localPosts.data.filter((x, i) => (i % 2 !== 0))"
                     class="border-gray-200 border-b-2 py-4 first-child last-child">
                    <inertia-link class="hover:text-gray-600 duration-200" :href="'/post/' + post.slug">
                        <div class="flex">
                            <img class="w-1/3 h-full mr-4 mb-4" :src="post.image" alt="">
                            <div class="flex w-2/3 flex-col">
                                <div class="font-bold mb-2">{{ post.title }}</div>

                                <div class="text-13 mb-2 text-gray-600">{{ post.brief }}</div>

                                <!--CREATED AT-->
                                <div class="flex h-full sans uppercase text-gray-400">
                                    <div class="flex flex-wrap">
                                        <div class="text-xs">
                                            {{
                                                `
                                            ${new Date(post.created_at).toLocaleString('default', {month: 'long'})}
                                            ${new Date(post.created_at).getDate()},
                                            ${new Date(post.created_at).getFullYear()}
                                            `
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </inertia-link>
                </div>
            </div>
        </div>

        <div class="mt-4 flex justify-center" v-if="this.localPosts.next_page_url">
            <div class="sans cursor-pointer text-xs font-bold uppercase mb-4 bg-gray-200 px-3 py-1 rounded">
                <div @click="loadMorePosts">
                    Load More Posts
                </div>
            </div>
        </div>

        <div v-for="user in localUsers.data">
            <div class="flex flex-row font-serif w-full">
                <div class="flex w-1/3">
                    <img class="w-12 h-12 mr-4" :src="user.profile_photo_url" alt="">

                    <div>
                        <div class="mb-2">
                            <inertia-link class="font-bold hover:text-gray-400 duration-200"
                                          :href="`/user/${user.id}` ">{{ user.name }}
                            </inertia-link>
                        </div>

                        <div class="mb-2 flex sans text-xs uppercase text-gray-400">
                            <div v-if="user.posts_count > 1">{{ user.posts_count }} posts,</div>
                            <div v-else-if="user.posts_count === 1">{{ user.posts_count }} post,</div>
                            <div v-else>No posts,</div>

                            <div v-if="user.posts_count > 1">{{ user.posts_count }} comments.</div>
                            <div v-else-if="user.posts_count === 1">{{ user.posts_count }} comment.</div>
                            <div v-else>No comments.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 flex justify-center" v-if="this.localUsers.next_page_url">
            <div class="sans cursor-pointer text-xs font-bold uppercase mb-4 bg-gray-200 px-3 py-1 rounded">
                <div @click="loadMoreUsers">
                    Load More Users
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
                axios.get(this.localPosts.next_page_url, {params: {type: 'morePosts'}}).then(response => {
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
                axios.get(this.localUsers.next_page_url, {params: {type: 'moreUsers'}}).then(response => {
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
