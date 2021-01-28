<template>
    <button :type="type" class="inline-flex hover:text-black items-center w-full justify-center font-bold px-4 py-2 bg-gray-800 border border-transparent rounded text-xs text-white uppercase tracking-widest hover:border-black hover:bg-white active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    }
</script>
