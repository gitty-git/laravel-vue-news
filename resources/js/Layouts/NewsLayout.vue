<template>
    <div class="flex flex-col items-center justify-center">
        <div class="w-1200">
            <header class="flex justify-center my-6 items-center">
                <inertia-link href="/" class="text-5xl uppercase">Chelyabinsk</inertia-link>
            </header>

            <slot/>
        </div>
        <footer class="bg-blue-200 w-full">
            <div class="w-1200">
                <div class="w-1/3">
                    About
                </div>

                <div class="w-1/3">
                    Contact Us
                </div>

                <div class="w-1/3">
                    In Social Media
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
name: "NewsLayout"
}
</script>

<style>
    .w-1200 {
        width: 1200px;
    }
    .last-child:last-child {
        border: none;
        padding-right: 0;
        margin-right: 0;
    }
</style>
