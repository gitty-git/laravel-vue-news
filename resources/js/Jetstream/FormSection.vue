<template>
    <div class="w-full justify-center">
        <jet-section-title>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </jet-section-title>

        <div class="w-full">
            <form @submit.prevent="$emit('submitted')">
                <div class="">
                    <div class="">
                        <div class="">
                            <slot name="form"></slot>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-4 bg-gray-50 text-right" v-if="hasActions">
                        <slot name="actions"></slot>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import JetSectionTitle from './SectionTitle'

    export default {
        components: {
            JetSectionTitle,
        },

        computed: {
            hasActions() {
                return !! this.$slots.actions
            }
        }
    }
</script>
