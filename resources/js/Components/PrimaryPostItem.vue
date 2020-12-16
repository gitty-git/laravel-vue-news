<template>
    <div>
        <div class="font-bold">
            <slot name="title"/>
        </div>

        <div class="">
            <slot name="brief"/>
        </div>
    </div>

</template>

<script>
export default {
name: "PrimaryPostItem"
}
</script>

<style scoped>

</style>
