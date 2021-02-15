<template>
    <div>
        <!--POSTS-->
        <div class="my-4">
            <div class="flex border-gray-200 font-serif">
                <!--LEFT-->
                <div class="w-1/2 mr-4">
                    <div v-for="post in localPosts.data.filter((x, i) => (i % 2 === 0))"
                         class="border-gray-200 border-b-2 py-4 first-child last-child"
                    >
                        <inertia-link class="hover:text-gray-600 duration-200" :href="route('posts.edit', post.id)">
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
                <div :class="{'border-none' : localPosts.data.length === 1}" class="w-1/2 pl-4 border-l-2 border-gray-200">
                    <div v-for="post in localPosts.data.filter((x, i) => (i % 2 !== 0))"
                         class="border-gray-200 border-b-2 py-4 first-child last-child">
                        <inertia-link class="hover:text-gray-600 duration-200" :href="route('posts.edit', post.id)">
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

        <!--USERS-->
        <div class="flex flex-wrap">
            <div v-for="user in users.data" class="font-serif flex mt-4 w-1/2">
                <div class="flex pt-4 items-center">
                    <img class="w-20 h-20" :src="user.profile_photo_url" alt="">

                    <div class="flex-col ml-4">
                        <div class="flex items-center">
                            <inertia-link :href="route('users.show', user)" class="font-sans font-bold uppercase mr-2">{{user.name}}</inertia-link>

                            <div class="flex font-sans">
                                <div v-for="role in user.roles">
                                    <div class="bg-gray-200 mr-2 px-2 uppercase text-xs rounded-full"
                                         v-if="role.role === 'admin' || role.role === 'redactor'">
                                        {{role.role}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="font-sans text-xs uppercase text-gray-400">
                            <span v-if="user.posts_count > 1">{{ user.posts_count }} posts,</span>
                            <span v-else-if="user.posts_count === 1">{{ user.posts_count }} post,</span>
                            <span v-else>No posts,</span>
                            <span v-if="user.comments_count > 1">{{ user.comments_count }} comments.</span>
                            <span v-else-if="user.comments_count === 1">{{ user.comments_count }} comment.</span>
                            <span v-else>No comments.</span>
                            <div class="flex font-bold items-center text-black">
                                <div v-if="showSure === false" class="cursor-pointer border-red-600 text-red-600 text-white hover:text-white hover:bg-red-600 mt-2 hover:bg-white rounded border px-3 py-1" @click="showSure = true" >Delete User</div>
                                <div v-if="showSure !== false" class="cursor-pointer mt-2 mr-2 py-1" @click="showSure = true" >Sure?</div>

                                <div class="flex" v-if="showSure === true">
                                    <div class="cursor-pointer border-red-600 mr-2 text-red-600 text-white hover:text-white hover:bg-red-600 mt-2 hover:bg-white rounded border px-3 py-1"
                                         @click="deleteUser(user)">Yes</div>
                                    <div class="cursor-pointer mr-2 cursor-pointer mt-2 hover:border-red-200 rounded border px-3 py-1"
                                         @click="showSure = false">No</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!--        <div v-for="post in posts">-->

<!--        </div>-->
        <!--COMMENTS-->
        <div>
            <div class="border-gray-200 border-b-2 last-border-none mt-4" v-for="(comment, id) in localComments.data" :key="id">
                <div class="my-4 flex">
                    <div class="w-1/2 mr-4">
                        <div class="font-sans text-xs uppercase text-gray-400 mb-2">
                            <span class="pr-2 mr-2 border-r-2">
                                {{`
                                    ${new Date(comment.created_at).toLocaleString('default', {month: 'long'})}
                                    ${new Date(comment.created_at).getDate()}, ${new Date(comment.created_at).getFullYear()}
                                `}}
                            </span>
                            <span class="pr-2 mr-2 border-r-2">
                                <span v-if="comment.comment_replies_count === 1">{{comment.comment_replies_count}} reply</span>
                                <span v-else>{{comment.comment_replies_count}} replies</span>
                            </span>

                            <span class="pr-2 mr-2 border-r-2">
                                <span v-if="comment.likes_count === 1">{{comment.likes_count}} like</span>
                                <span v-else>{{comment.likes_count}} likes</span>
                            </span>

                            <span class="cursor-pointer duration-200 hover:text-gray-700" v-if="comment.active === 0"
                                  @click="comment.active = 1">
                                Delete
                            </span>

                            <span v-else>
                                <span class="mr-2">Sure?</span>
                                <span class="pr-2 mr-2 border-r-2 cursor-pointer duration-200 hover:text-red-400 text-red-500"
                                      @click="deleteComment(comment)">Yes</span>
                                <span class="cursor-pointer duration-200 hover:text-gray-700" @click="comment.active = 0">No</span>
                            </span>
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

<!--        <div v-for="comment in comments.data">-->
<!--            <div @click="deleteComment(comment)">{{comment.text}}</div>-->
<!--        </div>-->

        <div v-if="localComments.data.length > 0" class="border-t-4 border-gray-400 w-full"></div>
    </div>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import ProfileLayout from "@/Layouts/ProfileLayout";

export default {
    name: "Admin",

    layout: ProfileLayout,
    props: ['posts', 'users', 'comments'],
    data() {
        return {
            localComments: this.comments,
            localPosts: this.posts,
            itemsCount: 6,
            showSure: false,
        }
    },

    mounted() {
    },

    methods: {
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

        deleteUser(user) {
            Inertia.delete(route('users.destroy', user), {preserveScroll: true})
        },

        loadMoreComments() {
            if (this.localComments.next_page_url) {
                axios.get(this.localComments.next_page_url, {params: {loadMoreType: 'moreComments', itemsCount: this.itemsCount}}).then(response => {
                    this.localComments = {
                        ...response.data,
                        data: [...this.localComments.data, ...response.data.data]
                    }
                })
            }
        },

        deleteComment(comment) {
            Inertia.delete(route('comments.destroy', comment), { preserveScroll: true })
            // return this.posts
                // .then(res => { if (res)
                //     this.localComments.data.splice(this.localComments.data.map(item => item.id).indexOf(comment.id), 1)
                //     // this.localCommentsCounted -= 1
                //     // this.itemsCount = 1
                //     // this.loadMoreComments()
                // })
        }
    }
}
</script>

<style scoped>

</style>
