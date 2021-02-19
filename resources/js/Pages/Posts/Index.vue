<template>
    <div>
        <div class="uppercase mt-2 font-sans border-gray-200 font-bold">
            <inertia-link class="border-r-2 pr-2 mr-2 text-gray-400" :href="route('posts.create')">Create Post</inertia-link>

            <span class="pr-2 mr-2">My Posts</span></div>
        <!--My POSTS-->
        <div v-if="localPosts.data.length > 0" class="font-sans mt-2 font-bold text-sm flex items-end">
            <div v-if="localPosts.data.length > 1">
                My <span v-if="postsCounted !== localPosts.data.length">last</span> {{ localPosts.data.length }} posts<span class="text-gray-400" v-if="postsCounted !== localPosts.data.length"> out of {{postsCounted}}</span>
            </div>
            <div v-else-if="localPosts.data.length === 1">
                My {{ localPosts.data.length }} post:
            </div>
            <div v-else>No posts</div>
        </div>

        <!--POSTS-->
        <div class="my-4">
            <div class="flex border-gray-200 font-serif">
                <!--LEFT-->
                <div class="w-1/2 mr-4">
                    <div v-for="(post, id) in posts.data.filter((x, i) => (i % 2 === 0))"
                         class="border-gray-200 border-b-2 py-4 first-child last-child"
                    >
                        <div class="hover:text-gray-600 duration-200" >
                            <div class="flex">
                                <img class="w-1/3 h-full mr-4 mb-4" :src="'/storage/' + post.image" alt="">

                                <div class="flex w-2/3 flex-col">
                                    <div class="font-sans uppercase text-xs flex mb-2">
                                        <inertia-link class="hover:bg-gray-100 duration-200 flex items-center bg-gray-200 mr-2 px-2 uppercase text-xs rounded-full" :href="route('posts.edit', post)">
                                            Edit Post
                                        </inertia-link>

                                        <span class="border border-red-600 text-red-600 cursor-pointer hover:bg-red-600 hover:text-white duration-200 mr-2 px-2 uppercase text-xs rounded-full" v-if="id !== sureDeletePost"
                                              @click="sureDeletePost = id; sureDeletePost2 = null;">
                                        Delete Post
                                    </span>

                                        <span v-else class="border border-white">
                                        <span class="mr-2">Sure?</span>

                                        <span class="pr-2 mr-2 border-r-2 cursor-pointer duration-200 hover:text-red-400 text-red-500"
                                              @click="deletePost(post); sureDeletePost = null">Yes</span>

                                        <span class="cursor-pointer duration-200 hover:text-gray-700" @click="sureDeletePost = null">No</span>
                                    </span>
                                    </div>

                                    <span class="font-bold mb-2">{{ post.title }}</span>

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
                        </div>
                    </div>
                </div>

                <!--RIGHT-->
                <div :class="{'border-none' : posts.data.length === 1}" class="w-1/2 pl-4 border-l-2 border-gray-200">
                    <div v-for="(post, id2) in posts.data.filter((x, i) => (i % 2 !== 0))"
                         class="border-gray-200 border-b-2 py-4 first-child last-child">
<!--                        <inertia-link class="hover:text-gray-600 duration-200" :href="`/posts/${post.slug}/edit`">-->
                        <div class="hover:text-gray-600 duration-200">
                            <div class="flex">
                                <img class="w-1/3 h-full mr-4 mb-4" :src="'/storage/' + post.image" alt="">

                                <div class="flex w-2/3 flex-col">
                                    <div class="font-sans uppercase text-xs flex mb-2">
                                        <inertia-link class="hover:bg-gray-100 duration-200 flex items-center bg-gray-200 mr-2 px-2 uppercase text-xs rounded-full" :href="route('posts.edit', post)">
                                            Edit Post
                                        </inertia-link>

                                        <span class="border border-red-600 text-red-600 cursor-pointer hover:bg-red-600 hover:text-white duration-200 mr-2 px-2 uppercase text-xs rounded-full"
                                              v-if="id2 !== sureDeletePost2"
                                              @click="sureDeletePost2 = id2; sureDeletePost = null">
                                        Delete Post
                                    </span>

                                        <span v-else class="border border-white">
                                        <span class="mr-2">Sure?</span>

                                        <span class="pr-2 mr-2 border-r-2 cursor-pointer duration-200 hover:text-red-400 text-red-500"
                                              @click="deletePost(post); sureDeletePost2 = null">Yes</span>

                                        <span class="cursor-pointer duration-200 hover:text-gray-700" @click="sureDeletePost2 = null">No</span>
                                    </span>
                                    </div>

                                    <span class="font-bold mb-2">{{ post.title }}</span>

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
                        </div>
                    </div>
                </div>
            </div>

            <!--PAGINATION-->
            <div class="flex font-bold pb-4 justify-center capitalize flex-row" v-if="posts.links[2].url">
                <inertia-link
                    preserve-state
                    preserve-scroll
                    v-for="item in posts.links"
                    :key="item.id"
                    :href="item.url || '#'"
                >
                    <div class="px-2" :class="{'bg-gray-200 rounded' : item.active === true}" v-html="item.label"/>
                </inertia-link>
            </div>

<!--            &lt;!&ndash;LOAD MORE POSTS&ndash;&gt;-->
<!--            <div class="mt-4 flex justify-center" v-if="localPosts.next_page_url">-->
<!--                <div class="font-sans cursor-pointer text-xs font-bold uppercase bg-gray-200 px-3 py-1 rounded">-->
<!--                    <div @click="loadMorePosts">-->
<!--                        Show More Posts-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</template>

<script>
import ProfileLayout from '@/Layouts/ProfileLayout'
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "Index",
    layout: ProfileLayout,
    props: ['posts', 'postsCounted'],
    data() {
        return {
            localPosts: this.posts,
            sureDeletePost: {},
            sureDeletePost2: {},
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

        deletePost(post) {
            Inertia.delete(route('posts.destroy', post), {preserveState: true, preserveScroll: true})
        },
    }
}
</script>

<style scoped>

</style>
