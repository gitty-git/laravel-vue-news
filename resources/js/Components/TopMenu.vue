<template>
    <div>
        <div class="flex mb-2 justify-between w-full text-sm">
            <div class="w-1/4 flex items-center">
                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 14 14">
                    <g id="Ellipse_1" data-name="Ellipse 1" fill="#fff" stroke="#a9a9a9" stroke-width="2">
                        <circle cx="4.5" cy="4.5" r="4.5" stroke="none"/>
                        <circle cx="4.5" cy="4.5" r="3.5" fill="none"/>
                    </g>
                    <line id="Line_34" data-name="Line 34" x2="4" y2="4" transform="translate(7.5 7.5)" fill="none"
                          stroke="#a9a9a9" stroke-width="2"/>
                </svg>

                <form method="get" action="/search/" class="flex">
                    <input required name="search" v-model="searchInput"
                           class="duration-200 hover:border-black hover:border-b-2 outline-none"
                           autocomplete="off"
                           placeholder="Search" type="text">
<!--                    <div v-if="searchInput.length > 0">></div>-->
                </form>
            </div>

            <div class="flex">
                <inertia-link class="text-sm border-r-2 border-gray-200 last-child"
                              :key="cat.id" v-for="cat in categories"
                              :href="'/category/' + cat.slug"
                >
                    <div class="hover:text-gray-500 px-2 mx-1 rounded duration-200">{{ cat.name }}</div>
                </inertia-link>
            </div>

            <div class="w-1/4 font-sans flex justify-end">
                <div v-if="!user" class="flex">
                    <a class="hover:text-gray-500 mx-2 rounded duration-200" :href="'/login'">Login</a>
                    <div class="font-bold text-gray-400">/</div>
                    <a class="hover:text-gray-500 mx-2 rounded duration-200" :href="'/register'">Register</a>
                </div >

                <div v-else class="hover:text-gray-500 rounded duration-200">
<!--                    {{ user.name }}-->
                    <jet-dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center text-sm font-medium hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ user.name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </template>

                        <template #content v-if="roles">
                            <jet-dropdown-link v-if="roles.filter(o => o.role === 'admin').length > 0" :href="route('admin.index')">
                                Administration
                            </jet-dropdown-link>

                            <jet-dropdown-link :href="route('posts.create')"
                                               v-if="roles.filter(o => o.role === 'redactor').length > 0 || roles.filter(o => o.role === 'admin').length > 0">
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

        <div class="border-t-4 border-gray-400 w-full"></div>
    </div>
</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
export default {
    name: "TopMenu",
    components: {JetDropdownLink, JetDropdown},

    props: ['name'],

    data: () => ({
        user: null,
        categories: null,
        searchInput: null,
        roles: null,
    }),

    mounted() {
        axios.get(route('users.index')).then(res => this.user = res.data)
        axios.get(route('roles.index')).then(res => this.roles = res.data)
        axios.get(route('categories.index')).then(res => this.categories = res.data)
    },

    methods: {
        logout() {
            axios.post(route('logout')).then(response => {
                window.location = '/';
            })
        },
    }
}
</script>

<style>

</style>
