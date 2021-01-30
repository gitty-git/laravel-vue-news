<template>
<!--    <button :type="type" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-full font-bold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">-->
<!--        <slot></slot>-->
<!--    </button>-->

    <button :type="type" class="px-4 py-2 w-full bg-white border border-gray-300 rounded-full font-bold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
            },
        }
    }
</script>
