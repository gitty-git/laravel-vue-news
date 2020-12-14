<template>
    <div class="flex justify-center">
        <div class="w-2/3">
            <header class="flex justify-center my-6 items-center">
                <inertia-link href="/">Chelyabinsk</inertia-link>
            </header>

            <slot/>

            <footer>
                footer
            </footer>
        </div>
    </div>
</template>

<script>
export default {
name: "NewsLayout"
}
</script>

<style scoped>

</style>
