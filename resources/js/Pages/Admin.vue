<template>
    <div>
        Hello!
        <div v-for="user in users.data">
            {{user.name}}
        </div>
        <div></div>
    </div>
</template>

<script>
import ProfileLayout from "@/Layouts/ProfileLayout";

export default {
    name: "Admin",

    layout: ProfileLayout,
    props: ['posts', 'users', 'comments']
}
</script>

<style scoped>

</style>
