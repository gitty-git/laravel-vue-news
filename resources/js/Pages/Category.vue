<template>
    <div>
        <div class="uppercase mt-2 font-sans font-bold">{{ primaryPosts[0].category.name }}</div>

        <!--PRIMARY POSTS-->
        <div class="flex border-b-2 py-4 mb-4 border-gray-200">
            <div v-for="post in primaryPosts" class="font-serif last-only w-1/2">
                <inertia-link class="hover:text-gray-600 duration-200" :href="'/post/' + post.slug">
                    <div class="flex">
                        <img class="w-1/2 mr-4 h-full" :src="'/storage/' + post.image" alt="">

                        <div class="flex w-1/2 flex-col">
                            <div class="font-bold text-lg mb-2 w-full">{{ post.title }}</div>

                            <div class="text-13 mb-2 text-gray-600">{{ post.brief }}</div>

                            <!--CREATED AT-->
                            <div class="flex h-full font-sans uppercase text-gray-400">
                                <div class="flex flex-wrap">
                                    <div class="text-xs">
                                        {{ `
                                            ${new Date(post.created_at).toLocaleString('default', {month: 'long'})}
                                            ${new Date(post.created_at).getDate()},
                                            ${new Date(post.created_at).getFullYear()}
                                        ` }}&nbsp;
                                    </div>

                                    <div class="text-xs">by {{ post.user.name }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </inertia-link>
            </div>
        </div>

        <!--REST POSTS-->
        <div class="flex border-b-2 pb-4 border-gray-200 font-serif">
            <!--LEFT-->
            <div class="w-1/2 mr-4">
                <div v-for="post in posts.data.filter((x, i) => (i % 2 === 0))"
                     class="border-gray-200 border-b-2 py-4 first-child last-child"
                >
                    <inertia-link class="hover:text-gray-600 duration-200" :href="'/post/' + post.slug">
                        <div class="flex">
                            <img class="w-1/3 h-full mr-4 mb-4" :src="'/storage/' + post.image" alt="">

                            <div class="flex w-2/3 flex-col">
                                <div class="font-bold mb-2">{{ post.title }}</div>

                                <div class="text-13 mb-2 text-gray-600">{{ post.brief }}</div>

                                <!--CREATED AT-->
                                <div class="flex h-full font-sans uppercase text-gray-400">
                                    <div class="flex flex-wrap">
                                        <div class="text-xs">
                                            {{
                                                `${new Date(post.created_at).toLocaleString('default', {month: 'long'})} ${new Date(post.created_at).getDate()}, ${new Date(post.created_at).getFullYear()}`
                                            }}&nbsp;
                                        </div>

                                        <div class="text-xs">by {{ post.user.name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </inertia-link>
                </div>
            </div>

            <!--RIGHT-->
            <div class="w-1/2 pl-4 border-l-2 border-gray-200">
                <div v-for="post in posts.data.filter((x, i) => (i % 2 !== 0))"
                     class="border-gray-200 border-b-2 py-4 first-child last-child">
                    <inertia-link class="hover:text-gray-600 duration-200" :href="'/post/' + post.slug">
                        <div class="flex">
                            <img class="w-1/3 h-full mr-4 mb-4" :src="'/storage/' + post.image" alt="">
                            <div class="flex w-2/3 flex-col">
                                <div class="font-bold mb-2">{{ post.title }}</div>

                                <div class="text-13 mb-2 text-gray-600">{{ post.brief }}</div>

                                <!--CREATED AT-->
                                <div class="flex h-full font-sans uppercase text-gray-400">
                                    <div class="flex flex-wrap">
                                        <div class="text-xs">
                                            {{
                                                `${new Date(post.created_at).toLocaleString('default', {month: 'long'})} ${new Date(post.created_at).getDate()}, ${new Date(post.created_at).getFullYear()}`
                                            }}&nbsp;
                                        </div>
                                        <div class="text-xs">by {{ post.user.name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </inertia-link>
                </div>
            </div>
        </div>

        <!--PAGINATION-->
        <div class="flex font-bold pt-4 justify-center capitalize flex-row">
            <inertia-link
                v-for="item in posts.links"
                :key="item.id"
                :href="item.url || '#'"
            >
                <div class="px-2" :class="{'bg-gray-200 rounded' : item.active === true}" v-html="item.label"/>
            </inertia-link>
        </div>
    </div>
</template>

<script>
import NewsLayout from "@/Layouts/NewsLayout";
export default {
    layout: NewsLayout,
    props: ["posts", "primaryPosts", "category"],
}
</script>

<style scoped>
.last-only:last-child {
    padding-right: 0;
    padding-left: 1rem;
    margin-left: 1rem;
    border-left: #E5E5E5 2px solid;
}
</style>
