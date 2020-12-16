<template>
    <NewsLayout>
        <div>
            <top-menu v-slot:links>
                <inertia-link class="mr-3 pr-3 border-r-2 border-gray-200 last-child"
                              :key="cat.id" v-for="cat in categories"
                              :href="'category/' + cat.slug">
                    {{ cat.name }}
                </inertia-link>
            </top-menu>

            <!--PRIMARY NEWS-->
            <div class="flex items-start">
                <div class="w-2/3 my-3 pr-3 border-r-2 border-gray-200">
                    <div class="text-2xl font-bold mb-3 text-center">{{firstPrimaryPost.title}}</div>
                    <div class="mb-3">{{firstPrimaryPost.brief}}</div>
                    <img :src="firstPrimaryPost.image" alt="">
                </div>

                <div class="w-1/3">
                    <div class="ml-3 my-3 pb-3 border-b-2 border-gray-200">
                        <div class="text-lg mb-3 font-bold">{{secondPrimaryPost.title}}</div>
                        <div class="mb-3">{{secondPrimaryPost.brief}}</div>
                        <img :src="secondPrimaryPost.image" alt="">
                    </div>

                    <div>
                        <div class="ml-3 mt-3 border-b-2 border-gray-200 last-child" v-for="primaryPost in restPrimaryPosts" :key="primaryPost.id">
                            <div class="text-lg font-bold mb-3">{{primaryPost.title}}</div>
                            <div class="mb-3">{{primaryPost.brief}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END PRIMARY NEWS-->

<!--            {{ Object.getOwnPropertyNames(primaryCategoriesPosts) }}-->



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
    props: ['categories', 'primaryPosts', 'primaryCategoryPosts', 'primaryCategoriesPosts'],
    data: () => ({
        cats: this.categories
    }),
    components: {
        NewsLayout,
    },
    computed: {
        firstPrimaryPost() {
            return this.primaryPosts[0];
        },

        secondPrimaryPost() {
            return this.primaryPosts[1];
        },

        restPrimaryPosts() {
            return this.primaryPosts.splice(2)
        },

        firstTwoPosts() {
            console.log(this.categoriesPosts)
        }
    }
}
</script>

<style scoped>
    .nth-odd:nth-child(odd) {
        color: red;
    }
</style>
