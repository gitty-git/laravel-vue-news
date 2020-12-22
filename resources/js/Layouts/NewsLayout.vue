<template>
    <div class="flex flex-col items-center justify-center">
        <div class="w-1200">
            <header class="flex justify-center my-3 items-center">
                <inertia-link href="/" class="text-6xl uppercase font-logo font-light">Chelyabinsk</inertia-link>
            </header>

            <slot/>
        </div>

        <footer class="bg-gray-100 w-full flex justify-center mt-3">
            <div class="w-1200 flex my-6">
                <div class="w-2/3 -ml-3 mr-3 px-3 flex border-r-2 border-gray-200">
                    <div class="w-1/2 pr-3 border-r-2 border-gray-200 mb-3">
                        <div class="font-bold mb-3">
                            About
                        </div>

                        <div class="font-serif text-sm">
                            Sit quaerat impedit inventore minus architecto id. Sit ipsum quis blanditiis odio laudantium ea. Voluptatem atque perspiciatis velit ut quia optio repellat consequuntur.
                        </div>
                    </div>

                    <div class="w-1/2 pb-3 px-3">
                        <div class="font-bold mb-3">
                            Contact Us
                        </div>

                        <div class="mb-3 font-serif">
                            Email:
                        </div>

                        <div class="font-bold text-gray-400 font-serif text-sm">
                            example@mail.com
                        </div>
                    </div>
                </div>

                <div class="w-1/3 last-child ">
                    <div class="font-bold mb-3">
                        In Social Media
                    </div>

                    <div class="mb-3 font-serif text-sm">
                        Twitter
                    </div>

                    <div class="mb-3 font-serif text-sm">
                        Facebook
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
name: "NewsLayout"
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
