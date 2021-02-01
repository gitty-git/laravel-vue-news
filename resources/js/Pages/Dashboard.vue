<template>
    <div>
        <inertia-link href="/add-post">add</inertia-link>
        <div class="flex justify-between mt-2">
            <div>
                <span class="font-bold">
                    MY ACTIVITY
                </span>
                <span class="font-sans text-xs uppercase text-gray-400">
                    -
                    <span v-if="postsCounted > 1">{{ postsCounted }} posts,</span>
                    <span v-else-if="postsCounted === 1">{{ postsCounted }} post,</span>
                    <span v-else>No posts,</span>
                    <span @click="scrollTo">
                        <span class="underline cursor-pointer" v-if="commentsCounted > 1">{{ commentsCounted }} comments.</span>
                        <span class="underline cursor-pointer" v-else-if="commentsCounted === 1">{{ commentsCounted }} comment.</span>
                        <span class="underline cursor-pointer" v-else>No comments.</span>
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

        <!--My POSTS-->
        <div v-if="localPosts.data.length > 0" class="font-sans mt-2 font-bold text-sm flex justify-between items-end">
            <div>
                <div v-if="localPosts.data.length > 1">
                    My <span v-if="postsCounted !== localPosts.data.length">last</span> {{ localPosts.data.length }} posts<span class="text-gray-400" v-if="postsCounted !== localPosts.data.length"> out of {{postsCounted}}</span>
                </div>
                <div v-else-if="localPosts.data.length === 1">
                    My {{ localPosts.data.length }} post:
                </div>
                <div v-else>No posts</div>
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
            <div class="border-t-4 border-gray-400 w-full" v-if="localPosts.data.length !== 0"></div>
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
    import ProfileLayout from '@/Layouts/ProfileLayout'
    import Welcome from '@/Jetstream/Welcome'
    import Button from "@/Jetstream/Button";

    export default {
        layout: ProfileLayout,
        components: {
            Button,
            Welcome,
        },
        props: ['user', 'roles', 'posts', 'comments', 'commentsCounted', 'postsCounted'],
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
