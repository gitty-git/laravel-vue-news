<template>
    <div>
        <header>
            <inertia-link href="/">Home</inertia-link>
            <inertia-link v-for="cat in categories" :href="cat.toLowerCase()">{{ cat }}</inertia-link>
        </header>
        <div v-for="post in posts">
            {{ post.title }}
        </div>
    </div>
</template>

<script>

export default {
    props: ["posts", "categories"],
}
</script>

<style scoped>

</style>
