<template>
    <div>
        <div class="flex justify-between items-end sans">
            <div>
                <div v-if="posts.length > 1"
                     class="uppercase mt-2 sans">last {{ posts.length }} posts by
                    <span class="sans-bold">{{ user.name }}</span>
                </div>
                <div v-else-if="posts.length === 1"
                     class="uppercase mt-2 sans">{{ posts.length }} post by
                    <span class="sans-bold">{{ user.name }}</span>
                </div>
                <div v-else class="uppercase mt-2 sans-bold">No posts by {{ user.name }}</div>
            </div>
            <div>
                Sorted by:
<!--                <inertia-link :href="'post?orderby=created_at'">dd</inertia-link>-->
            </div>
        </div>

        <!--POSTS-->
        <div class="flex pt-4 border-gray-200 font-serif">
            <!--LEFT-->
            <div class="w-1/2 mr-4">
                <div v-for="post in posts.filter((x, i) => (i % 2 === 0))"
                     class="border-gray-200 border-b-2 py-4 first-child last-child"
                >
                    <inertia-link :href="'/post/' + post.slug">
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
                <div v-for="post in posts.filter((x, i) => (i % 2 !== 0))"
                     class="border-gray-200 border-b-2 py-4 first-child last-child">
                    <inertia-link :href="'/post/' + post.slug">
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

        <div class="flex justify-center mt-3 border-t-2 border-gray-200" v-if="postsCounted > 6">
            <div class="sans mt-4 bg-gray-200 px-3 py-1 rounded">
                <inertia-link href="posts">
                    See all {{postsCounted}} posts
                </inertia-link>
            </div>
        </div>

        <!--COMMENTS-->

        <div class="border-t-4 border-gray-400 w-full mt-4"></div>

        <div class="flex justify-between sans">
            <div>
                <div v-if="comments.length > 1"
                     class="uppercase mt-2 sans">last {{ comments.length }} comments by
                    <span class="sans-bold">{{ user.name }}</span>
                </div>
                <div v-else-if="comments.length === 1"
                     class="uppercase mt-2 sans">{{ comments.length }} post by
                    <span class="sans-bold">{{ user.name }}</span>
                </div>
                <div v-else class="uppercase mt-2 sans-bold">No comments by {{ user.name }}</div>
            </div>
            <div>
                Sorted by:
                <!--                <inertia-link :href="'post?orderby=created_at'">dd</inertia-link>-->
            </div>
        </div>

        <div class="border-gray-200 border-b-2 mt-4" v-for="comment in comments">
            <div class="my-4 flex">

                <div class="w-1/2 mr-4">
                    <div class="sans text-xs uppercase text-gray-400 mb-2">
                        {{`
                        ${new Date(comment.created_at).toLocaleString('default', {month: 'long'})}
                        ${new Date(comment.created_at).getDate()}, ${new Date(comment.created_at).getFullYear()}
                    `}}
                        comment:
                    </div>

                    <div class="my-2 font-serif">"{{comment.text}}"</div>
                </div>

                <div class="w-1/2 pl-4 border-l-2 border-gray-200">
                    <div class="my-2 flex">
                        <img class="w-1/4 mr-4" :src="comment.post.image" alt="">
                        <div>
                            <div class="font-serif font-bold mb-2">{{comment.post.title}}</div>
                            <div class="sans text-xs uppercase text-gray-400">by {{comment.post.user.name}}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex justify-center border-gray-200" v-if="commentsCounted > 6">
            <div class="sans mt-4 bg-gray-200 px-3 py-1 rounded">
                <inertia-link href="posts">
                    See all {{commentsCounted}} comments
                </inertia-link>
            </div>
        </div>
    </div>
</template>

<script>
import NewsLayout from "@/Layouts/NewsLayout";
export default {
    name: "User",
    layout: NewsLayout,
    // data: () => ({
    //     orderBy: 'created_at',
    // }),
    props: ["user", "categories", "posts", "comments", "postsCounted", "commentsCounted"],
    computed: {
        showComments() {
            return this.comments
        }
    }
}
</script>

<style scoped>
.w-720 {
    width: 720px;
}
</style>
