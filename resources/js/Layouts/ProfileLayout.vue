<template>
    <div class="flex flex-col items-center h-screen justify-between">
        <div class="w-1200">
            <div class="flex mt-4 justify-between items-end">
                <div class="flex text-sm items-end">
                    <inertia-link href="/" class="text-4xl uppercase font-logo font-light">News Demo</inertia-link>
                </div>

                <!-- Settings Dropdown -->
                <div class="w-1/3">
                    <div class="mb-2 hidden justify-end sm:flex sm:items-center sm:ml-6">
                        <div class="ml-3 relative">
                            <jet-dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        class="flex items-center text-sm font-medium hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div v-if="user">{{ user.name }}</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </button>
                                </template>

                                <template #content v-if="roles">
                                    <jet-dropdown-link v-if="roles.filter(o => o.role === 'admin').length > 0"
                                                       :href="route('profile.show')">
                                        Administration
                                    </jet-dropdown-link>

                                    <jet-dropdown-link :href="route('posts.create')"
                                                       v-if="roles.filter(o => o.role === 'redactor').length > 0 || roles.filter(o => o.role === 'admin').length">
                                        Redaction
                                    </jet-dropdown-link>

                                    <jet-dropdown-link :href="route('my-activity.index')">
                                        My Activity
                                    </jet-dropdown-link>

                                    <jet-dropdown-link :href="route('profile.show')">
                                        Edit Profile
                                    </jet-dropdown-link>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <jet-dropdown-link as="button">
                                            Logout
                                        </jet-dropdown-link>
                                    </form>
                                </template>
                            </jet-dropdown>
                        </div>
                    </div>
                </div>

            </div>

            <!--            <top-menu class="bg-white"/>-->
            <div class="border-t-4 border-gray-400 w-full"></div>

            <slot/>
        </div>

        <footer class="bg-gray-100 w-full flex justify-center mt-4">
            <div class="w-1200 flex my-6">
                <div class="w-2/3 -ml-4 mr-4 px-4 flex border-r-2 h-full border-gray-300">
                    <div class="w-1/2 pr-3 border-r-2 border-gray-300 h-full mb-3">
                        <div class="font-bold text-sm mb-3">
                            About
                        </div>

                        <div class="font-serif text-sm text-gray-700">
                            Sit quaerat impedit inventore minus architecto id. Sit ipsum quis blanditiis odio laudantium
                            ea.
                        </div>
                    </div>

                    <div class="w-1/2 pb-2 px-4">
                        <div class="font-bold text-sm mb-3">
                            Contact Us
                        </div>

                        <div class="mb-2 font-serif text-sm text-gray-700">
                            Email:
                        </div>

                        <div class="font-bold text-sm text-gray-400">
                            example@mail.com
                        </div>
                    </div>
                </div>

                <div class="w-1/3 last-child ">
                    <div class="font-bold text-sm mb-2">
                        In Social Media
                    </div>

                    <div class="mb-2 font-serif text-sm text-gray-700">
                        Twitter
                    </div>

                    <div class="mb-2 font-serif text-sm text-gray-700">
                        Facebook
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import JetApplicationMark from "@/Jetstream/ApplicationMark";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetNavLink from "@/Jetstream/NavLink";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";

export default {
    name: "ProfileLayout",
    components: {
        JetApplicationMark,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
    },
    data() {
        return {
            user: null,
            roles: null,
        }
    },
    mounted() {
        axios.get('/user').then(res => this.user = res.data)
        axios.get('/roles').then(res => this.roles = res.data)
    },
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
    margin-bottom: 0;
    padding-bottom: 0;
}

.first-child:first-child {
    padding-left: 0;
    margin-left: 0;
    margin-top: 0;
    padding-top: 0;
}
</style>
