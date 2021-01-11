<template>
    <div>
        <div class="flex mb-2 justify-between text-red-500 w-full text-sm">
            <div class="w-1/4 flex items-center">
                <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 14 14">
                    <g id="Ellipse_1" data-name="Ellipse 1" fill="#fff" stroke="#a9a9a9" stroke-width="2">
                        <circle cx="4.5" cy="4.5" r="4.5" stroke="none"/>
                        <circle cx="4.5" cy="4.5" r="3.5" fill="none"/>
                    </g>
                    <line id="Line_34" data-name="Line 34" x2="4" y2="4" transform="translate(7.5 7.5)" fill="none"
                          stroke="#a9a9a9" stroke-width="2"/>
                </svg>

                <div class="sans">Search</div>
            </div>

            <div class="sans">
                <inertia-link class="mr-3 pr-2 text-sm border-r-2 border-gray-200 last-child"
                              :key="cat.id" v-for="cat in categories"
                              :href="'/category/' + cat.slug"
                >
                    {{ cat.name }}
                </inertia-link>
            </div>

            <div class="w-1/4 sans flex justify-end">
                <div v-if="!user" class="flex">
                    <a :href="'/login'">Log In</a>
                    <div class="font-bold mx-1 text-gray-400">/</div>
                    <a :href="'/register'">Sign In</a>
                </div >

                <a v-else :href="'/user/profile'">
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
    }),
    mounted() {
        axios.get('/user').then(res => this.user = res.data)
        axios.get('/category').then(res => this.categories = res.data)
    }
}
</script>

<style>
.sans-bold {
    font-family: 'Fira Sans', sans-serif;
    font-weight: bold;
}

.sans {
    font-family: 'Fira Sans', sans-serif;
}
</style>
