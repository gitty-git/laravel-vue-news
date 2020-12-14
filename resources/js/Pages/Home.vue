<template>
    <main>
        <header>
            <inertia-link href="/">Home</inertia-link>
            <inertia-link class="mx-6" v-for="cat in categories" :href="cat.toLowerCase()">{{ cat }}</inertia-link>
        </header>

        <div v-for="primaryPost in primaryPosts">
            {{primaryPost.title}}
        </div><br>

        <div v-for="posts in categoriesPosts">
            <div v-for="post in posts">
                {{post.title}}
            </div><br>
        </div>

        <article>
            <slot/>
        </article>
    </main>
</template>

<script>

export default {
    name: "Home",
    props: ['categories', 'primaryPosts', 'categoriesPosts'],
}
</script>

<style scoped>

</style>
