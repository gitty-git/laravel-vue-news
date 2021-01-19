<template>
<div>
    <div v-if="usersCounted > 0 || postsCounted > 0">
        Found {{postsCounted}} <span v-if="postsCounted > 0">posts</span><span v-else>post</span> and {{ usersCounted }} <span v-if="usersCounted > 0">users</span><span v-else>user</span>
    </div>
    <div v-else>Nothing Found</div>


    <!--POSTS-->
    <div class="flex pt-4 border-gray-200 font-serif">
        <!--LEFT-->
        <div class="w-1/2 mr-4">
            <div v-for="post in posts.data.filter((x, i) => (i % 2 === 0))"
                 class="border-gray-200 border-b-2 py-4 first-child last-child"
            >
                <inertia-link class="hover:text-gray-600 duration-200" :href="'/post/' + post.slug">
                    <div class="flex">
                        <img class="w-1/3 h-full mr-4 mb-4" :src="post.image" alt="">

                        <div class="flex w-2/3 flex-col">
                            <div class="font-bold mb-2">{{ post.title }}</div>

                            <div class="text-13 mb-2 text-gray-600">{{ post.brief }}</div>

                            <!--CREATED AT-->
                            <div class="flex h-full sans uppercase text-gray-400">
                                <div class="flex flex-wrap">
                                    <div class="text-xs">
                                        {{`
                                            ${new Date(post.created_at).toLocaleString('default', {month: 'long'})}
                                            ${new Date(post.created_at).getDate()},
                                            ${new Date(post.created_at).getFullYear()}
                                            ` }}
                                    </div>
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
                        <img class="w-1/3 h-full mr-4 mb-4" :src="post.image" alt="">
                        <div class="flex w-2/3 flex-col">
                            <div class="font-bold mb-2">{{ post.title }}</div>

                            <div class="text-13 mb-2 text-gray-600">{{ post.brief }}</div>

                            <!--CREATED AT-->
                            <div class="flex h-full sans uppercase text-gray-400">
                                <div class="flex flex-wrap">
                                    <div class="text-xs">
                                        {{`
                                            ${new Date(post.created_at).toLocaleString('default', {month: 'long'})}
                                            ${new Date(post.created_at).getDate()},
                                            ${new Date(post.created_at).getFullYear()}
                                            ` }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </inertia-link>
            </div>
        </div>
    </div>



    <!--POSTS PAGINATION-->
    <div v-if="postsCounted > 12" class="flex sans-bold pt-4 justify-center capitalize flex-row">
        <inertia-link
            preserve-scroll
            preserve-state
            v-for="item in posts.links"
            :key="item.id"
            :href="item.url || '#'"
        >
<!--            {{item.url}}-->
            <div class="px-2" :class="{'bg-gray-200 rounded' : item.active === true}" v-html="item.label"/>
        </inertia-link>
    </div>

<!--    <div v-for="user in users.data">{{ user.name }}</div>-->

<!--    &lt;!&ndash;USERS PAGINATION&ndash;&gt;-->
<!--    <div v-if="usersCounted > 2" class="flex sans-bold pt-4 justify-center capitalize flex-row">-->
<!--        <inertia-link-->
<!--            preserve-scroll-->
<!--            v-for="item in users.links"-->
<!--            :key="item.id"-->
<!--            :href="item.url || '#'"-->
<!--        >-->
<!--            <div class="px-2" :class="{'bg-gray-200 rounded' : item.active === true}" v-html="item.label"/>-->
<!--        </inertia-link>-->
<!--    </div>-->

</div>

</template>

<script>
import NewsLayout from "@/Layouts/NewsLayout";

export default {
    layout: NewsLayout,
    name: "SearchPosts",
    props: ["posts", "users", "postsCounted", "usersCounted"]
}
</script>

<style scoped>

</style>
