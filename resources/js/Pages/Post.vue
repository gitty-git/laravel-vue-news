<template>
    <NewsLayout>
        <top-menu v-slot:links>
            <inertia-link class="mr-3 pr-2 text-sm border-r-2 border-gray-200 last-child"
                          :key="cat.id" v-for="cat in categories"
                          :href="'/category/' + cat.slug">
                {{ cat.name }}
            </inertia-link>
        </top-menu>

        <div class="uppercase mt-2 sans-bold">{{ post.category.name }}</div>

        <div class="w-full mt-4 flex justify-center">
            <div class="w-720">
                <div class="font-serif font-bold text-3xl mb-4 text-center">{{post.title}}</div>

                <div class="font-serif text-xl leading-9 text-gray-600 mt-8 mb-2">{{post.brief}}</div>

                <!--CREATED AT-->
                <div class="flex sans uppercase text-gray-400">
                    <div class="text-xs">
                        {{
                            `${new Date(post.created_at).toLocaleString('default', {month: 'long'})} ${new Date(post.created_at).getDate()}, ${new Date(post.created_at).getFullYear()}`
                        }}
                    </div>
                    <inertia-link :href="'/user/' + post.user.id">
                        <div class="text-xs">&nbsp;by {{ post.user.name }}</div>
                    </inertia-link>

                </div>

                <div class="my-8">
                    <img class="mb-2" :src="post.image" alt="">
                    <div class="w-full font-serif text-xs text-gray-400 text-right">{{ post.image_description }}</div>
                </div>

                <div class="font-serif text-xl leading-9 text-gray-600 my-8">{{ post.body }}</div>
            </div>
        </div>

        <div class="flex justify-center font-serif text-sm text-gray-600">
            <div class="w-720">
                <div class="uppercase mb-2 sans-bold">Comments:</div>
                <div v-for="(comment, id) in comments">
                    <div class="mb-2">
                        <inertia-link class="font-bold" :href="`/user/${comment.user.id}` ">{{ comment.user.name }}</inertia-link>
                        says:
                    </div>
                    <div class="w-2/3 mb-2">
                        {{ comment.text }}
                    </div>
                    <div class="ml-8 mb-2" v-for="reply in comment.comment_replies">
                        <div>
                            <inertia-link class="font-bold" :href="`/user/${reply.user.id}` ">{{ reply.user.name }}</inertia-link>
                            says:
                        </div>
                        <div class="w-2/3">
                            {{ reply.text }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </NewsLayout>
</template>

<script>
import NewsLayout from "@/Layouts/NewsLayout";
export default {
    components: {NewsLayout},
    name: "Post",
    props: ["post", "categories", "comments"],
}
</script>

<style scoped>
    .w-720 {
        width: 720px;
    }
</style>
