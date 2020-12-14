<template>
    <NewsLayout>
        <div>
            <div class="flex justify-center">
                <inertia-link class="mx-6" :key="cat.id" v-for="cat in categories" :href="cat.toLowerCase()">{{ cat }}</inertia-link>
            </div>

            <div v-for="primaryPost in primaryPosts" :key="primaryPost.id">
                {{primaryPost.title}}
            </div><br>

            <div v-for="posts in categoriesPosts" :key="posts.id">
                <div v-for="post in posts" :key="post.id">
                    {{post.title}}
                </div><br>
            </div>

            <article>
                <slot/>
            </article>
        </div>
    </NewsLayout>
</template>

<script>
import NewsLayout from '@/Layouts/NewsLayout'

export default {
    name: "Home",
    props: ['categories', 'primaryPosts', 'categoriesPosts'],
    components: {
        NewsLayout,
    },
}
</script>

<style scoped>

</style>
