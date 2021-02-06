<template>
    <div class="flex flex-col items-center h-screen justify-between">
        <div class="w-1200">
            <header class="flex justify-center my-3 items-center">
                <inertia-link href="/" class="text-6xl uppercase font-logo font-light">News Demo</inertia-link>
            </header>

            <top-menu class="bg-white"/>

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
                            Molestias illum impedit ea voluptatem sunt earum sint.
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
export default {
    name: "NewsLayout",
    // methods: {
    //     logout() {
    //         axios.post(route('logout').url()).then(response => {
    //             window.location = '/';
    //         })
    //     },
    // }
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
