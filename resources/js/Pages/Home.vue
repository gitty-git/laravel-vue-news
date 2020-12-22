<template>
    <NewsLayout>
        <div>
            <top-menu v-slot:links>
                <inertia-link class="mr-3 text-sm pr-3 border-r-2 border-gray-200 last-child"
                              :key="cat.id" v-for="cat in categories"
                              :href="'category/' + cat.slug">
                    {{ cat.name }}
                </inertia-link>
            </top-menu>

            <!--PRIMARY POSTS-->
            <div class="flex font-serif text-gray-700">
                <div class="w-2/3 my-3 -ml-3 mr-3 px-3 border-r-2 border-gray-200">
                    <div class="text-2xl font-bold mb-3 text-center">{{firstPrimaryPost.title}}</div>
                    <div class="mb-3 text-sm">{{firstPrimaryPost.brief}}</div>
                    <img :src="firstPrimaryPost.image" alt="">
                </div>

                <div class="w-1/3">
                    <div class="my-3 pb-3 border-b-2 border-gray-200">
                        <div class="text-lg mb-3 font-bold">{{secondPrimaryPost.title}}</div>
                        <div class="mb-3 text-sm">{{secondPrimaryPost.brief}}</div>
                        <img :src="secondPrimaryPost.image" alt="">
                    </div>

                    <div>
                        <div class="mt-3 border-b-2 border-gray-200 last-child" v-for="primaryPost in restPrimaryPosts" :key="primaryPost.id">
                            <div class="text-lg font-bold mb-3">{{primaryPost.title}}</div>
                            <div class="mb-3 text-sm">{{primaryPost.brief}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!--CATEGORIES POSTS-->
            <div class="items-start">
                <div v-for="(cat, id) in categories">
                    <div class="border-t-4 border-gray-400 w-full my-3"></div>
                    <div class="font-bold mb-3">{{cat.name}}</div>

                    <div class="flex pb-3 font-serif text-gray-700">
                        <div class="flex w-2/3">
                            <div class="w-1/2" v-for="post in Object.values(primaryPosts)[id]">
                                <div class="border-r-2 -ml-3 mr-3 px-3 border-gray-200">
                                    <img :src="post.image" alt="" class="mb-3 w-full">
                                    <div class="font-bold text-lg mb-3">{{ post.title }}</div>
                                    <div class="text-sm">{{ post.brief }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-1/3 font-serif text-gray-700">
                            <div v-for="post in Object.values(posts)[id]" class="border-b-2 border-gray-200 last-child pb-3 mb-3">
                                <div class="font-bold text-lg mb-3">{{ post.title }}</div>
                                <div class="text-sm">{{ post.brief }}</div>
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
