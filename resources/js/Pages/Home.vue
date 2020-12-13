<template>
    <NewsLayout>
        <div>{{ msg }}</div>
    </NewsLayout>
</template>

<script>
import NewsLayout from '@/Layouts/NewsLayout'

export default {
    components: {
        NewsLayout,
    },
    name: "Home",
    props: ['msg']
}
</script>

<style scoped>

</style>
