<template>
<div>
    <div class="flex justify-between w-full text-sm">
        <div class="w-1/4">
            Search
        </div>

        <div class="font-bold">
            <slot name="links"/>
        </div>

        <div class="w-1/4 text-right">
            Login / Register
        </div>
    </div>

    <div class="border-t-4 border-gray-400 w-full my-3"></div>
</div>
</template>

<script>
export default {
name: "TopMenu"
}
</script>

<style scoped>

</style>
