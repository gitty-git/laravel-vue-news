<template>
    <NewsLayout>

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
