<template>
    <div>
        <div class="mt-2 font-bold flex justify-between border-gray-200">
            <span v-if="usersCounted > 0 || postsCounted > 0 || commentsCounted > 0" class="flex items-center">
                <span class="uppercase">By request "{{ search }}" found</span>

                <span class="font-sans text-xs uppercase text-gray-400 border-l-2 ml-2 pl-2">
                    {{ postsCounted }}
                    <span v-if="postsCounted === 1">post</span>
                    <span v-else>posts</span>
                </span>

                <span @click="scrollTo('users')" class="font-sans text-xs uppercase text-gray-400 border-l-2 ml-2 pl-2" :class="{'underline cursor-pointer' : usersCounted > 0}">
                    {{ usersCounted }}
                    <span v-if="usersCounted === 1">user</span>
                    <span v-else>users</span>
                </span>

                <span @click="scrollTo('comments')" class="font-sans text-xs uppercase text-gray-400 border-l-2 ml-2 pl-2" :class="{'underline cursor-pointer' : commentsCounted > 0}">
                    {{ commentsCounted }}
                    <span v-if="usersCounted === 1">comment</span>
                    <span v-else>comments</span>
                </span>
            </span>

            <div v-else>By Request "{{ search }}" Nothing Found in your records</div>
        </div>

        <inertia-link class="text-sm underline text-gray-400 font-normal normal-case" :href="'/admin'" >Back to previous page</inertia-link>

        <div v-if="localPosts.data.length > 0" class="mt-4 font-bold text-sm">
            <div v-if="localPosts.data.length === 1">Post:</div>
            <div v-else>Found posts:</div>
        </div>

        <!--POSTS-->
        <div class="my-4">
            <div class="flex border-gray-200 font-serif">
                <!--LEFT-->
                <div class="w-1/2 mr-4">
                    <div v-for="(post, id) in posts.data.filter((x, i) => (i % 2 === 0))"
                         class="border-gray-200 border-b-2 py-4 first-child last-child"
                    >
                        <div class="hover:text-gray-600 duration-200" >
                            <div class="flex">
                                <img class="w-1/3 h-full mr-4 mb-4" :src="'/storage/' + post.image" alt="">

                                <div class="flex w-2/3 flex-col">
                                    <div class="font-sans uppercase text-xs flex mb-2">
                                        <inertia-link class="hover:bg-gray-100 duration-200 flex items-center bg-gray-200 mr-2 px-2 uppercase text-xs rounded-full" :href="route('posts.edit', post)">
                                            Edit Post
                                        </inertia-link>

                                        <span class="border border-red-600 text-red-600 cursor-pointer hover:bg-red-600 hover:text-white duration-200 mr-2 px-2 uppercase text-xs rounded-full" v-if="id !== sureDeletePost"
                                              @click="sureDeletePost = id; sureDeletePost2 = null;">
                                        Delete Post
                                    </span>

                                        <span v-else class="border border-white">
                                        <span class="mr-2">Sure?</span>

                                        <span class="pr-2 mr-2 border-r-2 cursor-pointer duration-200 hover:text-red-400 text-red-500"
                                              @click="deletePost(post); sureDeletePost = null">Yes</span>

                                        <span class="cursor-pointer duration-200 hover:text-gray-700" @click="sureDeletePost = null">No</span>
                                    </span>
                                    </div>

                                    <span class="font-bold mb-2">{{ post.title }}</span>

                                    <div class="text-13 mb-2 text-gray-600">{{ post.brief }}</div>

                                    <!--CREATED AT-->
                                    <div class="flex h-full font-sans uppercase text-gray-400">
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
                        </div>
                    </div>
                </div>

                <!--RIGHT-->
                <div :class="{'border-none' : posts.data.length === 1}" class="w-1/2 pl-4 border-l-2 border-gray-200">
                    <div v-for="(post, id2) in posts.data.filter((x, i) => (i % 2 !== 0))"
                         class="border-gray-200 border-b-2 py-4 first-child last-child">
                        <!--                        <inertia-link class="hover:text-gray-600 duration-200" :href="`/posts/${post.slug}/edit`">-->
                        <div class="hover:text-gray-600 duration-200">
                            <div class="flex">
                                <img class="w-1/3 h-full mr-4 mb-4" :src="'/storage/' + post.image" alt="">

                                <div class="flex w-2/3 flex-col">
                                    <div class="font-sans uppercase text-xs flex mb-2">
                                        <inertia-link class="hover:bg-gray-100 duration-200 flex items-center bg-gray-200 mr-2 px-2 uppercase text-xs rounded-full" :href="route('posts.edit', post)">
                                            Edit Post
                                        </inertia-link>

                                        <span class="border border-red-600 text-red-600 cursor-pointer hover:bg-red-600 hover:text-white duration-200 mr-2 px-2 uppercase text-xs rounded-full"
                                              v-if="id2 !== sureDeletePost2"
                                              @click="sureDeletePost2 = id2; sureDeletePost = null">
                                        Delete Post
                                    </span>

                                        <span v-else class="border border-white">
                                        <span class="mr-2">Sure?</span>

                                        <span class="pr-2 mr-2 border-r-2 cursor-pointer duration-200 hover:text-red-400 text-red-500"
                                              @click="deletePost(post); sureDeletePost2 = null">Yes</span>

                                        <span class="cursor-pointer duration-200 hover:text-gray-700" @click="sureDeletePost2 = null">No</span>
                                    </span>
                                    </div>

                                    <span class="font-bold mb-2">{{ post.title }}</span>

                                    <div class="text-13 mb-2 text-gray-600">{{ post.brief }}</div>

                                    <!--CREATED AT-->
                                    <div class="flex h-full font-sans uppercase text-gray-400">
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
                        </div>
                    </div>
                </div>
            </div>

            <!--PAGINATION-->
            <div class="flex font-bold pb-4 justify-center capitalize flex-row" v-if="posts.links[2].url">
                <inertia-link
                    preserve-state
                    preserve-scroll
                    v-for="item in posts.links"
                    :key="item.id"
                    :href="item.url || '#'"
                >
                    <div class="px-2" :class="{'bg-gray-200 rounded' : item.active === true}" v-html="item.label"/>
                </inertia-link>
            </div>

            <!--            &lt;!&ndash;LOAD MORE POSTS&ndash;&gt;-->
            <!--            <div class="mt-4 flex justify-center" v-if="localPosts.next_page_url">-->
            <!--                <div class="font-sans cursor-pointer text-xs font-bold uppercase bg-gray-200 px-3 py-1 rounded">-->
            <!--                    <div @click="loadMorePosts">-->
            <!--                        Show More Posts-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>

        <!--USERS-->
        <div id="users" v-if="localUsers.data.length > 0">
            <div class="border-t-4 mb-2 border-gray-400 w-full" v-if="localUsers.data.length !== 0"></div>

            <div class="font-bold mb-4 text-sm">
                <div>Found users:</div>
            </div>
        </div>

        <!--USERS-->
        <div class="flex flex-wrap">
            <div v-for="(user, id) in users.data" class="font-serif flex mt-2 w-1/2">
                <div class="flex mb-4 items-center">
                    <img class="w-20 h-20" :src="user.profile_photo_url" alt="">

                    <div class="flex-col ml-4">
                        <div class="flex">
                            <inertia-link :href="route('user.show', user)" class="font-serif hover:text-gray-400 duration-200 font-bold font-sm mr-2">{{user.name}}</inertia-link>

                            <div class="rl-2 pl-2 border-l-2 font-sans text-xs uppercase text-gray-400 flex items-center">{{user.email}}</div>
                        </div>

                        <div class="font-sans text-xs mt-1 uppercase text-gray-400">
                            <span v-if="user.posts_count > 1">{{ user.posts_count }} posts,</span>
                            <span v-else-if="user.posts_count === 1">{{ user.posts_count }} post,</span>
                            <span v-else>No posts,</span>
                            <span v-if="user.comments_count > 1">{{ user.comments_count }} comments.</span>
                            <span v-else-if="user.comments_count === 1">{{ user.comments_count }} comment.</span>
                            <span v-else>No comments.</span>

                            <div class="font-sans text-xs mt-2 uppercase text-black">
                                <div class="flex font-sans">
                                    <inertia-link class="hover:bg-gray-100 duration-200 flex items-center bg-gray-200 mr-2 px-2 uppercase text-xs rounded-full" preserve-state preserve-scroll :href="`/admin/unset-redactor/${user.id}`" v-if="user.roles.find(a => a.role === 'redactor')">
                                        Unset as a redactor
                                    </inertia-link>

                                    <inertia-link class="hover:bg-gray-100 duration-200 flex items-center bg-gray-200 mr-2 px-2 uppercase text-xs rounded-full" preserve-state preserve-scroll :href="`/admin/set-redactor/${user.id}`" v-else-if="user.roles.find(a => a.role !== 'redactor') || user.roles.length === 0">
                                        Set as a redactor
                                    </inertia-link>

                                    <inertia-link class="hover:bg-gray-100 duration-200 flex items-center bg-gray-200 mr-2 px-2 uppercase text-xs rounded-full" preserve-state preserve-scroll :href="`/admin/unset-admin/${user.id}`" v-if="user.roles.find(a => a.role === 'admin')">
                                        Unset as an admin
                                    </inertia-link>

                                    <inertia-link class="hover:bg-gray-100 duration-200 flex items-center bg-gray-200 mr-2 px-2 uppercase text-xs rounded-full" preserve-state preserve-scroll :href="`/admin/set-admin/${user.id}`" v-else-if="user.roles.find(a => a.role !== 'admin') || user.roles.length === 0">
                                        Set as an admin
                                    </inertia-link>

                                    <span class="border border-red-600 text-red-600 cursor-pointer hover:bg-red-600 hover:text-white duration-200 mr-2 px-2 uppercase text-xs rounded-full" v-if="id !== sureDeleteUser"
                                          @click="sureDeleteUser = id">
                                        Delete User
                                    </span>

                                    <span v-else class="border border-white">
                                        <span class="mr-2">Sure?</span>

                                        <span class="pr-2 mr-2 border-r-2 cursor-pointer duration-200 hover:text-red-400 text-red-500"
                                              @click="deleteUser(user); sureDeleteUser = null">Yes</span>

                                        <span class="cursor-pointer duration-200 hover:text-gray-700" @click="sureDeleteUser = null">No</span>
                                    </span>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--PAGINATION-->
        <div class="flex font-bold my-4 justify-center capitalize flex-row" v-if="users.links[2].url">
            <inertia-link
                preserve-state
                preserve-scroll
                v-for="item in users.links"
                :key="item.id"
                :href="item.url || '#'"
            >
                <div class="px-2" :class="{'bg-gray-200 rounded' : item.active === true}" v-html="item.label"/>
            </inertia-link>
        </div>

        <!--COMMENTS-->
        <div id="comments" v-if="localComments.data.length > 0">
            <div class="border-t-4 mb-2 border-gray-400 w-full" v-if="localComments.data.length !== 0"></div>

            <div class="font-bold mb-4 text-sm">
                <div>Found comments:</div>
            </div>
        </div>

        <div>
            <div class="border-gray-200 border-b-2 last-border-none mt-4" v-for="(comment, id) in comments.data">
                <div class="my-4 flex">
                    <div class="w-1/2 mr-4">
                        <div class="font-sans text-xs uppercase text-gray-400 mb-2">
                            {{comment.id}}
                            <span class="pr-2 mr-2 border-r-2">
                                {{`
                                    ${new Date(comment.created_at).toLocaleString('default', {month: 'long'})}
                                    ${new Date(comment.created_at).getDate()}, ${new Date(comment.created_at).getFullYear()}
                                `}}
                            </span>
                            <span class="pr-2 mr-2 border-r-2">
                                <span v-if="comment.comment_replies_count === 1">{{comment.comment_replies_count}} reply</span>
                                <span v-else>{{comment.comment_replies_count}} replies</span>
                            </span>

                            <span class="pr-2 mr-2 border-r-2">
                                <span v-if="comment.likes_count === 1">{{comment.likes_count}} like</span>
                                <span v-else>{{comment.likes_count}} likes</span>
                            </span>

                            <span class="cursor-pointer duration-200 hover:text-gray-700" v-if="id !== sureActive"
                                  @click="sureActive = id">
                                Delete
                            </span>

                            <span v-else>
                                <span class="mr-2">Sure?</span>
                                <span class="pr-2 mr-2 border-r-2 cursor-pointer duration-200 hover:text-red-400 text-red-500"
                                      @click="deleteComment(comment); sureActive = null">Yes</span>
                                <span class="cursor-pointer duration-200 hover:text-gray-700" @click="sureActive = null">No</span>
                            </span>
                        </div>

                        <div class="my-2 font-serif">"{{comment.text}}"</div>
                    </div>

                    <div class="w-1/2 pl-4 border-l-2 border-gray-200">
                        <inertia-link :href="'/post/' + comment.post.slug"  class="flex hover:text-gray-600 duration-200">
                            <img class="w-1/4 mr-4" :src="'/storage/' + comment.post.image" alt="">
                            <div>
                                <div class="font-serif font-bold mb-2">{{comment.post.title}}</div>
                                <div class="font-sans text-xs uppercase text-gray-400">by {{comment.post.user.name}}</div>
                            </div>
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>

        <!--PAGINATION-->
        <div class="flex font-bold pt-4 justify-center capitalize flex-row">
            <inertia-link
                preserve-state
                preserve-scroll
                v-for="item in comments.links"
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
import ProfileLayout from "@/Layouts/ProfileLayout";
import {Inertia} from "@inertiajs/inertia";
export default {
    layout: ProfileLayout,
    props: ["posts", "comments", "postsCounted", "commentsCounted", "search", 'users', "usersCounted"],
    name: "Searching",
    data() {
        return {
            localPosts: this.posts,
            localComments: this.comments,
            localUsers: this.users,
            sureDeleteUser: {},
            sureActive: {},
            sureDeletePost: {},
            sureDeletePost2: {},
        }
    },
    methods: {
        scrollTo(id) {
            document.getElementById(id).scrollIntoView();
        },

        loadMorePosts() {
            if (this.localPosts.next_page_url) {
                axios.get(this.localPosts.next_page_url, {params: {loadMoreType: 'morePosts'}}).then(response => {
                    console.log(response)
                    this.localPosts = {
                        ...response.data,
                        data: [...this.localPosts.data, ...response.data.data]
                    }
                })
            }
        },

        loadMoreComments() {
            if (this.localComments.next_page_url) {
                axios.get(this.localComments.next_page_url, {params: {loadMoreType: 'moreComments'}}).then(response => {
                    console.log(response)
                    this.localComments = {
                        ...response.data,
                        data: [...this.localComments.data, ...response.data.data]
                    }
                })
            }
        },

        deleteUser(user) {
            Inertia.delete(route('users.destroy', user), {preserveScroll: true, preserveState: true})
        },

        deleteComment(comment) {
            Inertia.delete(route('comments.destroy', comment), {preserveScroll: true, preserveState: true})
        },

        deletePost(post) {
            Inertia.delete(route('posts.destroy', post), {preserveState: true, preserveScroll: true})
        },
    }
}
</script>

<style scoped>
.last-border-none:last-child {
    border-bottom: none;
}
</style>
