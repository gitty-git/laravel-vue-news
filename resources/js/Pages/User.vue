<template>
    <NewsLayout>
        <top-menu v-slot:links>
            <inertia-link class="mr-3 pr-2 text-sm border-r-2 border-gray-200 last-child"
                          :key="cat.id" v-for="cat in categories"
                          :href="'/category/' + cat.slug">
                {{ cat.name }}
            </inertia-link>
        </top-menu>

        {{ user.name }}

        {{ posts.data }}

    </NewsLayout>
</template>

<script>
import NewsLayout from "@/Layouts/NewsLayout";
export default {
    components: {NewsLayout},
    name: "User",
    props: ["user", "categories", "posts"],
}
</script>

<style scoped>
.w-720 {
    width: 720px;
}
</style>
