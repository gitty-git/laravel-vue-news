<template>
    <main>
        <header>
            <inertia-link href="/">Home</inertia-link>
            <inertia-link v-for="cat in categories" :href="cat.name.toLowerCase()">{{ cat.name }}</inertia-link>
        </header>

        <article>
            <slot/>
        </article>
    </main>
</template>

<script>

export default {
    name: "Home",
    props: ['categories']
}
</script>

<style scoped>

</style>
