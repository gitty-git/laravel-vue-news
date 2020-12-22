<template>
    <NewsLayout>
        <top-menu v-slot:links>
            <inertia-link class="mr-3 pr-3 border-r-2 border-gray-200 last-child"
                          :key="cat.id" v-for="cat in categories"
                          :href="cat.slug">
                {{ cat.name }}
            </inertia-link>
        </top-menu>

        <div class="flex border-b-2 pb-3 mb-3 border-gray-200">
            <div v-for="post in primaryPosts" class="font-serif last-only text-gray-700 w-1/2">
                <div class="flex">
                    <img class="w-1/2 mr-3 h-full" :src="post.image" alt="">
                    <div class="flex w-1/2 flex-col">
                        <div class="font-bold text-lg mb-3 w-full">{{ post.title }}</div>

                        <div class="text-xs mb-3">{{ post.brief }}</div>

                        <!--CREATED AT-->
                        <div class="flex h-full justify-end items-end font-sans uppercase text-gray-400">
                            <div class="text-xs">
                                {{ `${new Date(post.created_at).toLocaleString('default', { month: 'long' })} ${new Date(post.created_at).getDate()}, ${new Date(post.created_at).getFullYear()}`}}
                            </div>
                            <div class="text-xs">&nbsp;by {{ post.user.name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="flex border-b-2 pb-3 mb-3 border-gray-200 font-serif text-gray-700">
            <div class="w-1/2 mr-3">
                <div v-for="post in posts.data.filter((x, i) => (i % 2 === 0))"
                     class="border-gray-200 border-b-2 py-3 first-child last-child">
                    <div class="flex">
                        <img class="w-1/3 h-full mr-4 mb-3" :src="post.image" alt="">
                        <div class="flex w-2/3 flex-col">
                            <div class="font-bold mb-3">{{ post.title }}</div>

                            <div class="text-xs mb-3">{{ post.brief }}</div>

                            <!--CREATED AT-->
                            <div class="flex h-full justify-end items-end font-sans uppercase text-gray-400">
                                <div class="text-xs">
                                    {{ `${new Date(post.created_at).toLocaleString('default', { month: 'long' })} ${new Date(post.created_at).getDate()}, ${new Date(post.created_at).getFullYear()}`}}
                                </div>
                                <div class="text-xs">&nbsp;by {{ post.user.name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-1/2 pl-3 border-l-2 border-gray-200">
                <div v-for="post in posts.data.filter((x, i) => (i % 2 !== 0))"
                     class="border-gray-200 border-b-2 py-3 first-child last-child">
                    <div class="flex">
                        <img class="w-1/3 h-full mr-4 mb-3" :src="post.image" alt="">
                        <div class="flex w-2/3 flex-col">
                            <div class="font-bold mb-3">{{ post.title }}</div>

                            <div class="text-xs mb-3">{{ post.brief }}</div>

                            <!--CREATED AT-->
                            <div class="flex h-full justify-end items-end font-sans uppercase text-gray-400">
                                <div class="text-xs">
                                    {{ `${new Date(post.created_at).toLocaleString('default', { month: 'long' })} ${new Date(post.created_at).getDate()}, ${new Date(post.created_at).getFullYear()}`}}
                                </div>
                                <div class="text-xs">&nbsp;by {{ post.user.name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--PAGINATION-->
        <div class="flex justify-center capitalize font-bold flex-row">
            <inertia-link
                          v-for="item in posts.links"
                          :key="item.id"
                          :href="item.url || '#'"
            >
                <div class="px-2" :class="{'bg-gray-200 rounded' : item.active === true}" v-html="item.label"/>
            </inertia-link>
        </div>

        {{ firstRow }}

    </NewsLayout>
</template>

<script>

import NewsLayout from "@/Layouts/NewsLayout";
export default {
    components: {NewsLayout},
    props: ["posts", "primaryPosts", "categories", "category"],
    computed: {
        firstRow() {
            let m = this.posts.data.filter((x, i) => (i % 2 === 0))
            console.log(m);
        }
    }
}
</script>

<style scoped>
    .last-only:last-child {
        padding-right: 0;
        padding-left: 0.75rem;
        margin-left: 0.75rem;
        border-left: #E5E5E5 2px solid;
    }
</style>
