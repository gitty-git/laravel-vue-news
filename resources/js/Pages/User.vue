<template>
    <div>
        {{user.email}}
        <div class="flex mb-2 mt-2 justify-between">
            <div class="flex items-center">
                <img class="w-24 h-24 mt-2" :src="user.profile_photo_url" alt="">

                <div class="flex-col ml-4">
                    <div class="flex items-center">
                        <div class="font-serif font-bold mr-2">{{user.name}}</div>

                        <div class="flex">
                            <div v-for="role in user.roles">
                                <div class="bg-gray-200 mr-2 px-2 uppercase text-xs rounded-full"
                                     v-if="role.role === 'admin' || role.role === 'redactor'">
                                    {{role.role}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="font-sans text-xs uppercase text-gray-400">
                        <span v-if="postsCounted > 1">{{ postsCounted }} posts,</span>
                        <span v-else-if="postsCounted === 1">{{ postsCounted }} post,</span>
                        <span v-else>No posts,</span>

                        <span @click="scrollTo">
                        <span class="underline cursor-pointer" v-if="commentsCounted > 1">{{ commentsCounted }} comments.</span>
                        <span class="underline cursor-pointer" v-else-if="commentsCounted === 1">{{ commentsCounted }} comment.</span>
                        <span class="underline cursor-pointer" v-else>No comments.</span>
                    </span>
                    </div>
                </div>
            </div>

            <div>
                <div class="text-sm underline cursor-pointer text-gray-400 font-normal normal-case" @click="cancel">Back to previous page</div>
            </div>
        </div>



<!--        <div v-if="localComments.data.length > 0 &&  localPosts.data.length > 0" class="border-t-4 mt-4 border-gray-400 w-full"></div>-->
<!--        <div v-if="localComments.data.length > 0 &&  localPosts.data.length > 0" class="border-t mt-0.5 border-gray-200 w-full"></div>-->

        <div v-if="localPosts.data.length > 0" class="font-sans font-bold text-sm flex justify-between items-end">
            <div>
                <div v-if="localPosts.data.length > 1"
                     class="mt-2"><span v-if="postsCounted !== localPosts.data.length">Last</span> {{ localPosts.data.length }} posts:
                </div>
                <div v-else-if="localPosts.data.length === 1"
                     class="mt-2">{{ localPosts.data.length }} post:
                </div>
                <div v-else class="mt-2 ">No posts by {{ user.name }}</div>
            </div>
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
                                <img class="w-1/3 h-full mr-4 mb-4" :src="'/storage/' + post.image" alt="">

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
                                <img class="w-1/3 h-full mr-4 mb-4" :src="'/storage/' + post.image" alt="">
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
                        Load More Posts
                    </div>
                </div>
            </div>
        </div>

        <div v-if="localComments.data.length > 0" class="border-t-4 border-gray-400 w-full"></div>

        <!--COMMENTS-->
        <div id="comments" v-if="localComments.data.length > 0" class="flex pt-2 text-sm justify-between font-sans font-bold">
            <div>
                <div v-if="localComments.data.length > 1"
                     class="font-sans"><span v-if="commentsCounted !== localComments.data.length">Last</span> {{ localComments.data.length }} comments:
                </div>
                <div v-else-if="localComments.data.length === 1"
                     class="mt-2 font-sans">{{ localComments.data.length }} comment:
                </div>
                <div v-else class="mt-2 font-sans font-bold">No comments by {{ user.name }}</div>
            </div>
        </div>

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
                            <img class="w-1/4 mr-4" :src="'/storage/' + comment.post.image" alt="">
                            <div>
                                <div class="font-serif font-bold mb-2">{{comment.post.title}}</div>
                                <div class="font-sans text-xs uppercase text-gray-400">by {{comment.post.user.name}}</div>
                            </div>
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>

        <!--LOAD MORE COMMENTS-->
        <div class="mt-4 flex justify-center" v-if="localComments.next_page_url">
            <div class="font-sans cursor-pointer text-xs font-bold uppercase mb-4 bg-gray-200 px-3 py-1 rounded">
                <div @click="loadMoreComments">
                    Load More Comments
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NewsLayout from "@/Layouts/NewsLayout";
export default {
    name: "User",
    layout: NewsLayout,
    props: ["user", "categories", "posts", "comments", "postsCounted", "commentsCounted"],
    data() {
        return {
            localPosts: this.posts,
            localComments: this.comments
        }
    },
    methods: {
        scrollTo() {
            document.getElementById('comments').scrollIntoView();
        },
        loadMorePosts() {
            if (this.localPosts.next_page_url) {
                axios.get(this.localPosts.next_page_url, {params: {loadMoreType: 'morePosts'}}).then(response => {
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
                    this.localComments = {
                        ...response.data,
                        data: [...this.localComments.data, ...response.data.data]
                    }
                })
            }
        },

        cancel() {
            window.history.back();
        }
    },
    computed: {
        showComments() {
            return this.comments
        }
    }
}
</script>

<style scoped>
.w-720 {
    width: 720px;
}

.last-border-none:last-child {
    border-bottom: none;
}
</style>
