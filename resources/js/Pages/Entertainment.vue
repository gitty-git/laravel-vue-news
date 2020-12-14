<template>
    <div>
        <header>
            <inertia-link href="/">Home</inertia-link>
            <inertia-link class="mx-6" v-for="cat in categories" :href="cat.toLowerCase()">{{ cat }}</inertia-link>
        </header>

        <div v-for="post in posts.data">
            {{ post.title }}
        </div>

        <div class="flex flex-row">
            <inertia-link :class="{'text-red-500' : item.active === true}"
                          v-for="item in posts.links"
                          :href="item.url || '#'"
                          class="p-2"
            >
                <div v-html="item.label"/>
            </inertia-link>
        </div>

    </div>
</template>

<script>

export default {
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
