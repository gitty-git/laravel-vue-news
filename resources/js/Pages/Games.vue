<template>
    <Home>
        <div v-for="post in posts">
            {{ post.title }}
        </div>
    </Home>
</template>

<script>
import Home from '@/Pages/Home'

export default {
    components: {
        Home,
    },
    props: ["posts"],
}
</script>

<style scoped>

</style>
