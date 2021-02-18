<template>
    <div>
        <div class="flex justify-between mt-2">
            <div class="font-bold">
                <span class="font-bold mr-2 pr-2 border-r-2 border-gray-200">
                    MY ACTIVITY
                </span>
                <span class="font-sans text-xs uppercase text-gray-400 mr-2 pr-2 border-r-2 border-gray-200">
                    <span>
                        <span v-if="localCommentsCounted > 1">{{ localCommentsCounted }} comments</span>
                        <span v-else-if="localCommentsCounted === 1">{{ localCommentsCounted }} comment</span>
                        <span v-else>No comments</span>
                    </span>
                </span>

                <span class="font-sans text-xs uppercase text-gray-400 mr-2 pr-2">
                    <span @click="scrollTo">
                        <span class="underline cursor-pointer" v-if="likedPostsCounted > 1">{{ likedPostsCounted }} liked posts</span>
                        <span class="underline cursor-pointer" v-else-if="likedPostsCounted === 1">{{ likedPostsCounted }} liked post</span>
                        <span class="underline cursor-pointer" v-else>No liked posts</span>
                    </span>
                </span>
            </div>

            <form method="get" action="/user/profile/search/">
                <input required name="search"
                       class="duration-200 px-2 py-1 bg-gray-100 text-sm hover:border-black hover:border-b-2 outline-none"
                       autocomplete="off"
                       placeholder="Search in my activity" type="text">
                <!--                    <div v-if="searchInput.length > 0">></div>-->
            </form>
        </div>

        <!--COMMENTS-->
        <div id="comments" v-if="comments.data.length > 0" class="flex pt-2 text-sm justify-between font-sans font-bold">
            <div>
                <div v-if="comments.data.length > 1"
                     class="font-sans">My <span v-if="commentsCounted !== comments.data.length">latest</span> {{ comments.data.length }} comments
                    <span class="text-gray-400" v-if="commentsCounted !== comments.data.length"> out of {{commentsCounted}}</span>
                </div>
                <div v-else-if="comments.data.length === 1"
                     class="mt-2 font-sans">My {{ comments.data.length }} comment:
                </div>
                <div v-else class="mt-2 font-sans font-bold">No comments</div>
            </div>
        </div>

        <div>
            <div class="border-gray-200 border-b-2 last-border-none mt-4" v-for="(comment, id) in comments.data" :key="id">
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
        <div class="flex font-bold pb-4 justify-center capitalize flex-row">
            <inertia-link
                preserve-state
                preserve-scroll
                v-for="item in comments.links"
                :key="item.id"
                :href="item.url || '#'"
            >
                <div class="px-2" :class="{'bg-gray-200 rounded' : item.active === true}" v-html="item.label"/>
            </inertia-link>
        </div>

<!--        <div class="mt-4 flex justify-center" v-if="localComments.next_page_url">-->
<!--            <div class="font-sans cursor-pointer text-xs font-bold uppercase mb-4 bg-gray-200 px-3 py-1 rounded">-->
<!--                <div @click="loadMoreComments">-->
<!--                    Load More Comments-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

        <div v-if="localPosts.data.length > 0" class="border-t-4 border-gray-400 w-full mb-2"></div>

        <div id="likedPosts" v-if="localPosts.data.length > 0" class="flex text-sm justify-between font-sans font-bold">
            <div>
                <div v-if="localPosts.data.length > 1"
                     class="font-sans">My <span v-if="localLikedPostsCounted !== localPosts.data.length">latest</span> {{ localPosts.data.length }} liked posts<span class="text-gray-400" v-if="localLikedPostsCounted !== localPosts.data.length"> out of {{localLikedPostsCounted}}</span>
                </div>
                <div v-else-if="localPosts.data.length === 1"
                     class="font-sans">My {{ localPosts.data.length }} liked post:
                </div>
                <div v-else class="font-sans font-bold">No posts</div>
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
                <div :class="{'border-none' : likedPosts.data.length === 1}" class="w-1/2 pl-4 border-l-2 border-gray-200">
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
                        Load More Liked Posts
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ProfileLayout from '@/Layouts/ProfileLayout'
    import Welcome from '@/Jetstream/Welcome'
    import Button from "@/Jetstream/Button";
    import {Inertia} from "@inertiajs/inertia";

    export default {
        layout: ProfileLayout,
        components: {
            Button,
            Welcome,
        },
        props: ['user', 'likedPosts', 'comments', 'commentsCounted', 'likedPostsCounted'],
        data() {
            return {
                localPosts: this.likedPosts,
                localComments: this.comments,
                localCommentsCounted: this.commentsCounted,
                localLikedPostsCounted: this.likedPostsCounted,
                itemsCount: 5
            }
        },

        methods: {
            scrollTo() {
                document.getElementById('likedPosts').scrollIntoView();
            },

            loadMorePosts() {
                if (this.localPosts.next_page_url) {
                    axios.get(this.localPosts.next_page_url, {params: {loadMoreType: 'moreLikedPosts'}}).then(response => {
                        this.localPosts = {
                            ...response.data,
                            data: [...this.localPosts.data, ...response.data.data]
                        }
                    })
                }
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
                Inertia.delete(route('comments.destroy', comment), {preserveScroll: true, preserveState: true})
                // this.localComments.data.splice(this.localComments.data.map(item => item.id).indexOf(comment.id), 1)
                // this.localCommentsCounted -= 1
                    // .then(res => { if (res)
                    //
                    //     this.localCommentsCounted -= 1
                    //     this.itemsCount = 1
                    //     this.loadMoreComments()
                    // })
            }
        }
    }
</script>

<style scoped>
.last-border-none:last-child {
    border-bottom: none;
}
</style>
