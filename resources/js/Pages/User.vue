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

.last-border-none:last-child {
    border-bottom: none;
}
</style>

<template>
    <div>
        <div class="flex pt-4 items-center">
            <img :src="user.profile_photo_url" alt="">

            <div class="flex-col ml-4">
                <div class="flex items-center">
                    <div class="sans font-bold uppercase mr-2">{{user.name}}</div>

                    <div class="flex">
                        <div v-for="role in user.roles">
                            <div class="bg-gray-200 mr-2 px-2 uppercase text-xs rounded-full" v-if="role.role === 'admin' || role.role === 'redactor'">{{role.role}}</div>
                        </div>
                    </div>
                </div>

                <div class="sans text-xs uppercase text-gray-400">
                    <span v-if="postsCounted > 1">{{ postsCounted }} posts,</span>
                    <span v-else-if="postsCounted === 1">{{ postsCounted }} post,</span>
                    <span v-else>No posts,</span>

                    <span v-if="commentsCounted > 1">{{ commentsCounted }} comments.</span>
                    <span v-else-if="commentsCounted === 1">{{ commentsCounted }} comment.</span>
                    <span v-else>No comments.</span>
                </div>
            </div>
        </div>

<!--        <div class="border-t-4 border-gray-400 w-full mt-4"></div>-->

        <div class="sans-bold mt-4 flex justify-between items-end">
            <div>
                <div v-if="posts.length > 1"
                     class="mt-2">Last {{ posts.length }} posts:
                </div>
                <div v-else-if="posts.length === 1"
                     class="mt-2">{{ posts.length }} post:
                </div>
                <div v-else class="mt-2 ">No posts by {{ user.name }}</div>
            </div>
<!--            <div>-->
<!--                Sorted by:-->
<!--                &lt;!&ndash;                <inertia-link :href="'post?orderby=created_at'">dd</inertia-link>&ndash;&gt;-->
<!--            </div>-->
        </div>

        <!--POSTS-->
        <div class="flex pt-4 border-gray-200 font-serif">
            <!--LEFT-->
            <div class="w-1/2 mr-4">
                <div v-for="post in posts.filter((x, i) => (i % 2 === 0))"
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
                <div v-for="post in posts.filter((x, i) => (i % 2 !== 0))"
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

        <div class="flex justify-center" v-if="postsCounted > 6">
            <div class="sans hover:bg-gray-100 duration-200 text-xs font-bold uppercase my-4 bg-gray-200 px-3 py-1 rounded">
                <inertia-link href="posts">
                    See all {{postsCounted}} posts
                </inertia-link>
            </div>
        </div>

        <div class="border-t-4 border-gray-400 w-full mt-4"></div>

        <!--COMMENTS-->
        <div class="flex justify-between sans-bold">
            <div>
                <div v-if="comments.length > 1"
                     class="mt-2 sans">Last {{ comments.length }} comments:
                </div>
                <div v-else-if="comments.length === 1"
                     class="mt-2 sans">{{ comments.length }} comment:
                </div>
                <div v-else class="mt-2 sans-bold">No comments by {{ user.name }}</div>
            </div>
        </div>

        <div>
            <div class="border-gray-200 border-b-2 last-border-none mt-4" v-for="comment in comments">
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
                        <inertia-link :href="'/post/' + comment.post.slug"  class="flex hover:text-gray-600 duration-200">
                            <img class="w-1/4 mr-4" :src="comment.post.image" alt="">
                            <div>
                                <div class="font-serif font-bold mb-2">{{comment.post.title}}</div>
                                <div class="sans text-xs uppercase text-gray-400">by {{comment.post.user.name}}</div>
                            </div>
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center" v-if="commentsCounted > 6">
            <div class="sans hover:bg-gray-100 duration-200 text-xs font-bold uppercase mb-4 bg-gray-200 px-3 py-1 rounded">
                <inertia-link href="comments">
                    See all {{commentsCounted}} comments
                </inertia-link>
            </div>
        </div>
    </div>
</template>
