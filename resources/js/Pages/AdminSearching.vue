<template>
    <div>
        <div class="uppercase mt-2 font-bold flex justify-between">
            <span v-if="usersCounted > 0 || postsCounted > 0">
                By request "{{ search }}" found {{ postsCounted }}
                <span v-if="postsCounted === 1">post</span>
                <span v-else>posts</span>
                and {{ commentsCounted }}
                <span v-if="usersCounted === 1">comment</span>
                <span v-else>comments</span> in your records
            </span>
            <div v-else>By Request "{{ search }}" Nothing Found in your records</div>
            <inertia-link class="ml-1 text-sm underline text-gray-400 font-normal normal-case" :href="'/dashboard'" >Back to previous page</inertia-link>
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

        <div v-if="localComments.data.length > 0">
            <div class="border-t-4 mb-2 border-gray-400 w-full" v-if="localPosts.data.length !== 0"></div>

            <div class="font-bold mb-4 text-sm">
                <div v-if="localComments.data.length === 1">User:</div>
                <div v-else>Comments:</div>
            </div>
        </div>

        <!--USERS-->
        <div>
            <div class="border-gray-200 border-b-2 last-border-none mt-4" v-for="comment in localComments.data">
                <div class="my-4 flex">
                    <div class="w-1/2 mr-4">
                        <div class="font-sans text-xs uppercase text-gray-400 mb-2">
                            {{`
                        ${new Date(comment.created_at).toLocaleString('default', {month: 'long'})}
                        ${new Date(comment.created_at).getDate()}, ${new Date(comment.created_at).getFullYear()}
                        `}}
                            comment:
                        </div>

                        <div class="my-2 font-serif">"{{comment.text}}"</div>
                    </div>

                    <div class="w-1/2 pl-4 border-l-2 border-gray-200">
                        <inertia-link :href="'/post/' + comment.post.slug"  class="flex hover:text-gray-600 duration-200">
                            <img class="w-1/4 mr-4" :src="comment.post.image" alt="">
                            <div>
                                <div class="font-serif font-bold mb-2">{{comment.post.title}}</div>
                                <div class="font-sans text-xs uppercase text-gray-400">by {{comment.post.user.name}}</div>
                            </div>
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>

        <!--LOAD MORE USERS-->
        <div class="mt-4 flex justify-center" v-if="this.localComments.next_page_url">
            <div class="font-sans cursor-pointer text-xs font-bold uppercase mb-4 bg-gray-200 px-3 py-1 rounded">
                <div @click="loadMoreComments">
                    Show More Comments
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import NewsLayout from "@/Layouts/NewsLayout";
import ProfileLayout from "@/Layouts/ProfileLayout";
export default {
    layout: AdminSearching,
    props: ["posts", "comments", "postsCounted", "commentsCounted", "search"],
    name: "SearchPosts",
    data() {
        return {
            localPosts: this.posts,
            localComments: this.comments
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

        loadMoreComments() {
            if (this.localComments.next_page_url) {
                axios.get(this.localComments.next_page_url, {params: {loadMoreType: 'moreComments'}}).then(response => {
                    console.log(response)
                    this.localComments = {
                        ...response.data,
                        data: [...this.localComments.data, ...response.data.data]
                    }
                })
            }
        },
    }
}
</script>

<style scoped>
.last-border-none:last-child {
    border-bottom: none;
}
</style>
