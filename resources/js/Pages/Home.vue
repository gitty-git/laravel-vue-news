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
                    <div class="text-2xl font-bold mb-1 text-center">{{firstPrimaryPost.title}}</div>
                    <div class="text-sm text-gray-600">{{firstPrimaryPost.brief}}</div>
                    <img class="mt-4" :src="firstPrimaryPost.image" alt="">
                </div>

                <div class="w-1/3">
                    <div class="my-4 pb-4 border-b-2 border-gray-200">
                        <div class="text-lg mb-1 font-bold">{{secondPrimaryPost.title}}</div>
                        <div class="text-sm text-gray-600">{{secondPrimaryPost.brief}}</div>
                        <img class="mt-4" :src="secondPrimaryPost.image" alt="">
                    </div>

                    <div>
                        <div class="mt-4 border-b-2 border-gray-200 last-child" v-for="primaryPost in restPrimaryPosts" :key="primaryPost.id">
                            <div class="text-lg font-bold mb-2">{{primaryPost.title}}</div>
                            <div class="mb-2 text-sm text-gray-600">{{primaryPost.brief}}</div>
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
                                <div class="border-r-2 -ml-4 mr-4 px-4 border-gray-200">
                                    <img :src="post.image" alt="" class="mb-4 w-full">
                                    <div class="font-bold text-lg mb-2">{{ post.title }}</div>
                                    <div class="text-sm text-gray-600">{{ post.brief }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-1/3 font-serif">
                            <div v-for="post in Object.values(posts)[id]" class="border-b-2 border-gray-200 last-child pb-4 mb-4">
                                <div class="font-bold text-lg mb-2">{{ post.title }}</div>
                                <div class="text-sm text-gray-600">{{ post.brief }}</div>
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
