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
            <div class="ml-1 text-gray-400 font-normal">- Select a post to edit / delete</div>
        </div>

        <!--POSTS-->
        <div class="my-4">
            <div class="flex border-gray-200 font-serif">
                <!--LEFT-->
                <div class="w-1/2 mr-4">
                    <div v-for="post in localPosts.data.filter((x, i) => (i % 2 === 0))"
                         class="border-gray-200 border-b-2 py-4 first-child last-child"
                    >
                        <inertia-link class="hover:text-gray-600 duration-200" :href="route('posts.edit', post)">
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
<!--                        <inertia-link class="hover:text-gray-600 duration-200" :href="`/posts/${post.slug}/edit`">-->
                        <inertia-link class="hover:text-gray-600 duration-200" :href="route('posts.edit', post)">
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
                        Show More Posts
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ProfileLayout from '@/Layouts/ProfileLayout'

export default {
    name: "Index",
    layout: ProfileLayout,
    props: ['posts', 'postsCounted'],
    data() {
        return {
            localPosts: this.posts,
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
    }
}
</script>

<style scoped>

</style>
