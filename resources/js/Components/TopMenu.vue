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
                <slot name="links"/>
            </div>

            <!--        <div class="w-1/4 sans flex justify-end">-->
            <!--            <inertia-link :href="'/login'">Login</inertia-link>-->
            <!--            <div class="font-bold mx-1 text-gray-400">/</div>-->
            <!--            <inertia-link :href="'/register'">Register</inertia-link>-->
            <!--        </div>-->

            <div class="w-1/4 sans flex justify-end">
                <a href="/login">Log In</a>
                <div class="font-bold mx-1 text-gray-400">/</div>
                <a :href="'/register'">Sign In</a>
                <slot name="user"></slot>
            </div>
        </div>

        {{user}}

        <div class="border-t-4 border-gray-400 w-full"></div>
    </div>
</template>

<script>
export default {
    props: ["user"],
    name: "TopMenu",
    data: () => ({
        user: ''
    }),
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
