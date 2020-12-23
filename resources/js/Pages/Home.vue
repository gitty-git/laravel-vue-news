<template>
    <NewsLayout>
        <div>
            <top-menu v-slot:links>
                <inertia-link class="mr-3 pr-2 text-sm border-r-2 border-gray-200 last-child"
                              :key="cat.id" v-for="cat in categories"
                              :href="'category/' + cat.slug">
                    {{ cat.name }}
                </inertia-link>
            </top-menu>

            <!--PRIMARY POSTS-->
            <div class="flex font-serif">
                <div class="w-2/3 my-4 -ml-4 mr-4 px-4 border-r-2 border-gray-200">
                    <inertia-link :href="'/post/' + firstPrimaryPost.slug">
                        <div class="text-3xl font-bold mb-2 text-center leading-10">{{ firstPrimaryPost.title }}</div>

                        <div class="text-13 text-gray-700">{{ firstPrimaryPost.brief }}</div>

                        <div class="mt-4">
                            <img :src="firstPrimaryPost.image" alt="">
                            <div class="mt-2 w-full text-xs text-gray-400 text-right">{{ firstPrimaryPost.image_description }}</div>
                        </div>
                    </inertia-link>
                </div>

                <div class="w-1/3">
                    <inertia-link :href="'/post/' + secondPrimaryPost.slug">
                        <div class="my-4 pb-4 border-b-2 border-gray-200">
                            <div class="text-2xl mb-2 font-bold leading-8">{{ secondPrimaryPost.title }}</div>

                            <div class="text-13 text-gray-700">{{ secondPrimaryPost.brief }}</div>

                            <div class="mt-4">
                                <img :src="secondPrimaryPost.image" alt="">
                                <div class="mt-2 w-full text-xs text-gray-400 text-right">{{ secondPrimaryPost.image_description }}</div>
                            </div>
                        </div>
                    </inertia-link>

                    <div>
                        <div class="mt-4 border-b-2 mb-4 border-gray-200 last-child" v-for="primaryPost in restPrimaryPosts" :key="primaryPost.id">
                            <inertia-link :href="'/post/' + primaryPost.slug">
                                <div class="text-xl mb-2 font-bold">{{primaryPost.title}}</div>
                                <div class="text-13 mb-4 text-gray-700">{{primaryPost.brief}}</div>
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </div>

            <!--CATEGORIES POSTS-->
            <div class="items-start">
                <div v-for="(cat, id) in categories">
                    <div class="border-t-4 border-gray-400 w-full mb-4"></div>
                    <div class="sans-bold mb-4 text-sm">{{cat.name}}</div>

                    <div class="flex pb-4 font-serif">
                        <div class="flex w-2/3">
                            <div class="w-1/2" v-for="post in Object.values(primaryPosts)[id]">
                                <inertia-link :href="'/post/' + post.slug">
                                    <div class="border-r-2 -ml-4 mr-4 px-4 border-gray-200">
                                        <div class="mb-4">
                                            <img :src="post.image" alt="" class="w-full">
<!--                                            <div class="mt-2 w-full text-xs text-gray-400 text-right">{{ post.image_description }}</div>-->
                                        </div>

                                        <div class="font-bold text-lg mb-2">{{ post.title }}</div>

                                        <div class="text-13 text-gray-700">{{ post.brief }}</div>
                                    </div>
                                </inertia-link>
                            </div>
                        </div>

                        <div class="w-1/3 font-serif">
                            <div v-for="post in Object.values(posts)[id]" class="border-b-2 border-gray-200 last-child pb-4 mb-4">
                                <inertia-link :href="'/post/' + post.slug">
                                    <div class="text-sm mb-2 font-bold ">{{ post.title }}</div>
                                    <div class="text-13 text-gray-700">{{ post.brief }}</div>
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <slot/>
            </div>
        </div>
    </NewsLayout>
</template>

<script>
import NewsLayout from '@/Layouts/NewsLayout'

export default {
    name: "Home",
    props: ['categories', 'frontPagePosts', 'primaryPosts', 'posts',],
    components: {
        NewsLayout,
    },
    computed: {
        firstPrimaryPost() {
            return this.frontPagePosts[0];
        },

        secondPrimaryPost() {
            return this.frontPagePosts[1];
        },

        restPrimaryPosts() {
            return this.frontPagePosts.splice(2)
        },
    }
}
</script>

<style scoped>
    .nth-odd:nth-child(odd) {
        color: red;
    }
</style>
