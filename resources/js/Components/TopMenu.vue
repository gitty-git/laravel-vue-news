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

                <a v-else class="hover:text-gray-500 rounded duration-200" :href="'/dashboard'">
                    {{ user.name }}
                </a>
            </div>
        </div>

        <div class="border-t-4 border-gray-400 w-full"></div>
    </div>
</template>

<script>
export default {
    name: "TopMenu",
    data: () => ({
        user: null,
        categories: null,
        searchInput: ''
    }),
    mounted() {
        axios.get('/user').then(res => this.user = res.data)
        axios.get('/category').then(res => this.categories = res.data)
    },
}
</script>

<style>

</style>
