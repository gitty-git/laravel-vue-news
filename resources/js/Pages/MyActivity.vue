<template>
    <div>
        <div class="flex justify-between mt-2">
            <div class="font-bold">
                <span class="font-bold mr-2 pr-2 border-r-2 border-gray-200">
                    MY ACTIVITY
                </span>
                <span class="font-sans text-xs uppercase text-gray-400 mr-2 pr-2 border-r-2 border-gray-200">
                    <span>
                        <span v-if="commentsCounted > 1">{{ commentsCounted }} comments</span>
                        <span v-else-if="commentsCounted === 1">{{ commentsCounted }} comment</span>
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
        <div id="comments" v-if="localComments.data.length > 0" class="flex pt-2 text-sm justify-between font-sans font-bold">
            <div>
                <div v-if="localComments.data.length > 1"
                     class="font-sans">My <span v-if="commentsCounted !== localComments.data.length">last</span> {{ localComments.data.length }} comments<span class="text-gray-400" v-if="commentsCounted !== localComments.data.length"> out of {{commentsCounted}}</span>
                </div>
                <div v-else-if="localComments.data.length === 1"
                     class="mt-2 font-sans">My{{ localComments.data.length }} comment:
                </div>
                <div v-else class="mt-2 font-sans font-bold">No comments</div>
            </div>
        </div>

        <div>
            <div class="border-gray-200 border-b-2 last-border-none mt-4" v-for="comment in localComments.data">
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

                            <span>
                                <span v-if="comment.likes_count === 1">{{comment.likes_count}} like</span>
                                <span v-else>{{comment.likes_count}} likes</span>
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

        <div id="likedPosts" v-if="localComments.data.length > 0" class="flex pt-2 text-sm justify-between font-sans font-bold">
            <div>
                <div v-if="localComments.data.length > 1"
                     class="font-sans">My <span v-if="commentsCounted !== localComments.data.length">last</span> {{ localComments.data.length }} comments<span class="text-gray-400" v-if="commentsCounted !== localComments.data.length"> out of {{commentsCounted}}</span>
                </div>
                <div v-else-if="localComments.data.length === 1"
                     class="mt-2 font-sans">My{{ localComments.data.length }} comment:
                </div>
                <div v-else class="mt-2 font-sans font-bold">No comments</div>
            </div>
        </div>

    </div>
</template>

<script>
    import ProfileLayout from '@/Layouts/ProfileLayout'
    import Welcome from '@/Jetstream/Welcome'
    import Button from "@/Jetstream/Button";

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
                localComments: this.comments
            }
        },
        methods: {
            scrollTo() {
                document.getElementById('likedPosts').scrollIntoView();
            },

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
