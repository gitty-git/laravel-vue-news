<template>
    <NewsLayout>
        <div class="flex justify-center">
            <inertia-link class="mx-6" v-for="cat in categories" :key="cat.id" :href="cat.toLowerCase()">{{ cat }}</inertia-link>
        </div>

        <div v-for="post in posts.data">
            {{ post.title }}
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
    props: ["posts", "categories"],
    computed: {
        logg() {
            return console.log(this.posts)
        }
    }
}
</script>

<style scoped>

</style>
