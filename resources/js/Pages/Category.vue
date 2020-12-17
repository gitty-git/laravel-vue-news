<template>
    <NewsLayout>
        <top-menu v-slot:links>
            <inertia-link class="mr-3 pr-3 border-r-2 border-gray-200 last-child"
                          :key="cat.id" v-for="cat in categories"
                          :href="cat.slug">
                {{ cat.name }}
            </inertia-link>
        </top-menu>

        <div v-for="post in primaryPosts">
            <div class="font-bold">
                {{ post.title }}
            </div>
        </div>

        <div v-for="post in posts.data">
            <div>
                {{ post.title }}
            </div>
        </div>

        <div class="flex flex-row">
            <inertia-link :class="{'text-red-500' : item.active === true}"
                          v-for="item in posts.links"
                          :key="item.id"
                          :href="item.url || '#'"
                          class="p-2"
            >
                <div v-html="item.label"/>
            </inertia-link>
        </div>

    </NewsLayout>
</template>

<script>

import NewsLayout from "@/Layouts/NewsLayout";
export default {
    components: {NewsLayout},
    props: ["posts", "primaryPosts", "categories", "category"],
    computed: {
        logg() {
            return console.log(this.posts)
        }
    }
}
</script>

<style scoped>

</style>
