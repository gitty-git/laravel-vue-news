<template>
    <NewsLayout>
        <top-menu v-slot:links>
            <inertia-link class="mr-3 pr-2 text-sm border-r-2 border-gray-200 last-child"
                          :key="cat.id" v-for="cat in categories"
                          :href="'/category/' + cat.slug">
                {{ cat.name }}
            </inertia-link>
        </top-menu>

        <div class="uppercase sans-bold">{{ post.category.name }}</div>

        <div class="w-full mt-4 flex justify-center">
            <div class="w-720">
                <div class="font-serif font-bold text-4xl mb-4">{{post.title}}</div>

                <div class="font-serif text-xl leading-9 text-gray-700 my-8">{{post.brief}}</div>

                <!--CREATED AT-->
                <div class="flex justify-end items-end sans uppercase text-gray-400">
                    <div class="text-xs">
                        {{
                            `${new Date(post.created_at).toLocaleString('default', {month: 'long'})} ${new Date(post.created_at).getDate()}, ${new Date(post.created_at).getFullYear()}`
                        }}
                    </div>
                    <div class="text-xs">&nbsp;by {{ post.user.name }}</div>
                </div>

                <img class="my-8" :src="post.image" alt="">

                <div class="font-serif text-xl leading-9 text-gray-700 my-8">{{ post.body }}</div>
            </div>
        </div>
    </NewsLayout>
</template>

<script>
import NewsLayout from "@/Layouts/NewsLayout";
export default {
    components: {NewsLayout},
    name: "Post",
    props: ["post", "categories"],
}
</script>

<style scoped>
    .w-720 {
        width: 720px;
    }
</style>
