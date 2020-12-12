<template>
    <main>
        <header>
            <inertia-link href="politics">Politics</inertia-link>
        </header>

        <article>
            <slot/>
        </article>
    </main>
</template>

<script>
export default {
    name: "NewsLayout"
}
</script>

<style scoped>

</style>
