<template>
    <div>
        <inertia-link class="uppercase block my-2 font-sans font-bold" v-if="user" :href="'/admin'">{{ user.name }}</inertia-link>
        <div v-for="user in users">
            <a :href="`/admin/edit-user/${user.id}`">{{ user.name }}</a>
            <a :href="`/admin/edit-user/${user.id}`" v-for="role in user.roles">{{ role.role }}</a>
        </div>
        <!--        {{users}}-->
        <!--        {{user.name}}-->
        <!--        {{user.email}}-->
        <!--        {{posts}}-->
        <form @submit.prevent="logout">
            <button as="button">
                Logout
            </button>
        </form>

        <div v-if="$page.jetstream.canUpdateProfileInformation">
            Edit Profile
            <update-profile-information-form :user="$page.user" />
            Change Password
            <update-password-form :user="$page.user"/>
            Delete Account
            <delete-user-form/>

<!--            <jet-section-border />-->
        </div>
    </div>
</template>

<script>
import Button from "@/Jetstream/Button";
import ProfileLayout from "@/Layouts/ProfileLayout";
import UpdateProfileInformationForm from "@/Pages/Profile/UpdateProfileInformationForm";
import UpdatePasswordForm from "@/Pages/Profile/UpdatePasswordForm";
import DeleteUserForm from "@/Pages/Profile/DeleteUserForm";

export default {
    layout: ProfileLayout,
    name: "Admin",
    components: {Button, UpdateProfileInformationForm, DeleteUserForm, UpdatePasswordForm},
    props: ['user', 'posts', 'users'],
    methods: {
        logout() {
            axios.post(route('logout').url()).then(response => {
                window.location = '/';
            })
        },
    }
}
</script>

<style scoped>

</style>
