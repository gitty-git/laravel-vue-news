<template>
    <div>
        <!--POST-->
        <div class="w-full mt-8 flex justify-center">
            <div class="post-width">
                <div class="font-serif font-bold text-3xl mb-4 text-center">{{ post.title }}</div>

                <div class="font-serif text-xl leading-9 text-gray-600 mt-8 mb-2">{{ post.brief }}</div>

                <!--CREATED AT-->
                <div class="flex font-sans uppercase text-gray-400">
                    <div class="text-xs">
                        {{
                            `
                            ${new Date(post.created_at).toLocaleString('default', {month: 'long'})}
                            ${new Date(post.created_at).getDate()}, ${new Date(post.created_at).getFullYear()}
                        `
                        }}
                    </div>
                    <div>
                        <div class="text-xs">
                            &nbsp;by
                            <inertia-link class="underline font-bold hover:text-gray-600 duration-200"
                                          :href="'/user/' + post.user.id">{{ post.user.name }}
                            </inertia-link>
                        </div>
                    </div>
                </div>

                <div class="my-8">
<!--                    <img class="mb-2" :src="post.image" alt="">-->
                    <img class="w-full mb-2 h-1/3" :src="'/storage/' + post.image" alt="image"/>
                    <div class="w-full font-serif text-xs text-gray-400 text-right">{{ post.image_description }}</div>
                </div>

                <div class="font-serif text-xl leading-9 text-gray-600 my-8">{{ post.body }}</div>

                <div class="justify-center flex mb-8" >
                    <div class="flex cursor-pointer" @click.prevent="setPostLike">
                        <like-red-heart class="w-6" v-if="localPostLiked"/>
                        <like-empty-heart class="w-6" v-else/>
                        <div v-if="localPostLikes === 1" class="ml-2">{{ localPostLikes }} like</div>
                        <div v-else class="ml-2">{{ localPostLikes }} likes</div>
                    </div>
                </div>
            </div>
        </div>

        <!--COMMENTS-->
        <div class="flex justify-center font-serif text-sm text-gray-600">
            <div class="post-width">
                <div v-if="post.comments_count < 1" class="uppercase mb-4 font-sans font-bold">No comments yet</div>

                <div v-else-if="post.comments_count === 1" class="uppercase mb-4 font-sans font-bold">
                    {{ post.comments_count }} Comment
                </div>

                <div v-else class="uppercase mb-4 font-sans font-bold">{{ post.comments_count }} Comments</div>

                <div v-if="!user" class="font-sans mb-4 text-gray-400">
                    You must
                    <a class="underline" :href="'/login'">Login</a>
                    or
                    <a class="underline" :href="'/register'">Register</a>
                    before you can leave a comment.
                </div>

                <div v-if="user" class="flex flex-col font items-center justify-center w-full">
                    <div class="w-full items-end flex mb-4">
                        <div @keyup.enter="addComment"  class="w-3/4 h-auto"
                             v-click-outside="hideAddCommentField"
                             @mousedown="comment.text = cachedCommentText"
                             @keydown.enter.exact.prevent
                             @click="addCommentFieldShowed = true">
                            <textarea-autosize class="outline-none py-1 border-b-2 border-white w-full input-font-sans"
                                               :class="{'border-b-2 outline-none border-gray-400 duration-200' : addCommentFieldShowed === true}"
                                               type="text" v-model="comment.text"
                                               :placeholder="addCommentFieldShowed === true ? '' : 'Leave a comment...'"
                                               :max-height="300"
                                               rows="1"
                            />
                        </div>
                        <div class="flex justify-center w-1/4" v-if="addCommentFieldShowed === true">
                            <div class="flex w-1/2 items-center justify-center text-gray-700 duration-200 cursor-pointer hover:text-gray-400 uppercase text-xs font-sans px-3 py-2"
                                    @click="addCommentFieldShowed = false; comment.text = null">Cancel</div>

                            <div class="flex w-1/2 font-bold border items-center justify-center text-gray-700 duration-200 cursor-pointer hover:text-gray-400 rounded uppercase text-xs font-sans"
                                    @click.prevent="addComment">Add Comment</div>
                        </div>
                    </div>
                </div>

                <div class="" v-bind:key="comment.id" v-for="(comment, i) in localComments.data" >
                    <div class="py-4 border-t-2 border-gray-200" >
                        <div class="flex w-full">
                            <img class="w-12 h-12 mr-4" v-if="comment.user.profile_photo_url" :src="comment.user.profile_photo_url" alt="">

                            <div class="w-full">
                                <div class="mb-2">
                                    <inertia-link class="font-bold text-gray-900 hover:text-gray-400 duration-200"
                                                  :href="`/user/${comment.user.id}` ">{{ comment.user.name }}
                                    </inertia-link>
                                    {{ time_ago(comment.created_at) }}
                                </div>

                                <div class="mb-2 w-full">
                                    {{ comment.text }}
                                </div>

                                <div class="flex mt-2 w-full items-start justify-between">
                                    <div class="flex w-full items-start">
                                        <div class="flex items-start cursor-pointer mr-2"
                                             :class="{'border-r-2 border-gray-400' : user}"
                                             @click.prevent="setCommentLike(comment.id)">
                                            <div v-if="user">
                                                <like-red-heart v-if="comment.likes && comment.likes.find(like => like.id === user.id)" class="text-black"/>
                                                <like-empty-heart v-else class="text-black"/>
                                            </div>

                                            <div v-else>
                                                <like-empty-heart class="text-black"/>
                                            </div>

                                            <div v-if="comment.likes_count === 1" class="ml-2 flex font-normal pr-2 font-sans">
                                                <div>{{ comment.likes_count }}</div><div>&nbsp;like</div>
                                            </div>
                                            <div v-else class="ml-2 flex font-normal pr-2 font-sans">
                                                <div>{{ comment.likes_count }}</div><div>&nbsp;likes</div>
                                            </div>
                                        </div>

                                        <!--REPLY FIELD-->
                                        <div v-if="user" class="w-full -mb-4 mr-2 items-end flex duration-200">
                                            <div @keyup.enter="addReply(i, comment); activeItem = null" @click="activeItem = i; showReplyAdded = null"
                                                 class="w-full" @keydown.enter.exact.prevent>
                                                <div class="font-sans text-green-500 h-8 duration-200"
                                                     v-if="showReplyAdded === i">Reply Added.
                                                </div>

                                                <div v-else>
                                                    <textarea-autosize class="outline-none duration-200 placeholder-gray-600 cursor-pointer border-white w-full input-font-sans"
                                                                       :class="{'border-b-2 outline-none border-gray-400 duration-200' : i === activeItem}"
                                                                       type="text" v-model="reply.text[i]"
                                                                       :max-height="300"
                                                                       rows="1" ref="reply"
                                                                       :placeholder="i === activeItem ? '' :'Reply'"
                                                    />
                                                </div>
                                            </div>

                                            <div class="flex justify-center w-1/4" v-show="i === activeItem">
                                                <div class="flex w-1/2 mb-2 justify-center text-gray-700 duration-200 cursor-pointer hover:text-gray-400 uppercase text-xs font-sans px-3"
                                                     @click="activeItem = null; reply.text[i] = null">Cancel</div>

                                                <div class="flex w-1/2 mb-2 font-bold border justify-center text-gray-700 duration-200 cursor-pointer hover:text-gray-400 rounded uppercase text-xs font-sans"
                                                     @click.prevent="addReply(i, comment)">Reply</div>
                                            </div>
                                        </div>
                                    </div>

<!--                                    show replies button-->
                                    <div v-if="comment.comment_replies.length > 0"
                                         @click="showReplies(i)"
                                         class="cursor-pointer ml-2 font-sans flex justify-end"
                                    >
                                        <div class="flex " v-if="comment.comment_replies.length === 1">
                                            <div class="hover:text-gray-400 whitespace-no-wrap duration-200" v-if="comment.active">
                                                Hide reply
                                            </div>
                                            <div v-else class="hover:text-gray-400 w-full whitespace-no-wrap duration-200">Show 1 reply</div>
                                        </div>

                                        <div v-else>
                                            <div class="hover:text-gray-400 duration-200 whitespace-no-wrap" v-if="comment.active">
                                                Hide replies
                                            </div>
                                            <div class="hover:text-gray-400 duration-200 whitespace-no-wrap" v-else>Show
                                                {{ comment.comment_replies.length }} replies
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--COMMENT'S REPLIES-->
                    <div v-if="comment.active" class="ml-12" v-for="reply in comment.comment_replies">
                        <div class="py-4 border-t-2 border-gray-200"
                             :class="{'' : comment.comment_replies.length === 1}"
                        >
                            <div class="flex">
                                <img class="w-12 h-12 mr-4" :src="reply.user.profile_photo_url" alt="">
                                <div>
                                    <div class="mb-2">
                                        <inertia-link class="font-bold text-gray-900 hover:text-gray-400 duration-200"
                                                      :href="`/user/${reply.user.id}` ">{{ reply.user.name }}
                                        </inertia-link>
                                        {{ time_ago(reply.created_at) }}
                                    </div>

                                    <div class="">
                                        {{ reply.text }}
                                    </div>

                                    <!--likes-->
                                    <div class="flex items-start mt-2 cursor-pointer" @click="setCommentReplyLike(reply.id)">
                                        <div v-if="user">
                                            <like-red-heart v-if="reply.likes && reply.likes.find(like => like.id === user.id)" class="text-black"/>
                                            <like-empty-heart v-else class="text-black"/>
                                        </div>
                                        <div v-else>
                                            <like-empty-heart class="text-black"/>
                                        </div>
                                        <div v-if="reply.likes" class="font-sans ml-2 font-normal">{{ reply.likes.length }} likes</div>
                                        <div v-else class="font-sans ml-2 font-normal">0 likes</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center" v-if="this.localComments.next_page_url">
                    <div
                        class="font-sans cursor-pointer text-xs font-bold uppercase mb-4 bg-gray-200 px-3 py-1 rounded">
                        <div @click="loadMoreComments">
                            Load More Comments
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--        {{ post }}-->
    </div>
</template>

<script>
import NewsLayout from "@/Layouts/NewsLayout";
import {Inertia} from "@inertiajs/inertia";
import vClickOutside from 'v-click-outside'

export default {
    layout: NewsLayout,
    name: "Post",
    props: ["post", "categories", "comments", "user", "postLiked", "commentLiked"],
    directives: {
        clickOutside: vClickOutside.directive
    },
    data() {
        return {
            activeItem: {},
            showReplyAdded: null,
            showReply: null,
            localComment: null,
            cachedCommentText: null,
            addCommentFieldShowed: false,
            localComments: this.comments,
            localPostLikes: this.post.likes_count,
            localPostLiked: this.postLiked,
            comment: {
                text: null,
                post_id: this.post.id,
            },
            reply: {
                text: [],
            },
            showedMsg: false,
        }
    },

    methods: {
        showReplies(i) {
            let comment = this.localComments.data[i];
            comment.active = !comment.active;
            this.$set(this.localComments, i, comment);
        },

        hideAddCommentField () {
            this.addCommentFieldShowed = false
            this.cachedCommentText = this.comment.text
            this.comment.text = ''
        },

        hideAddReplyField() {
            this.activeItem = null
            console.log(this.getComment())
        },

        setPostLike() {
            axios.post(`/post-like/${this.post.id}`).then((res) => {
                this.localPostLikes = res.data.postLikesCount
                this.localPostLiked = res.data.postLiked
            })
        },

        addComment() {
            // this.comment = `${this.comment}\n`;
            axios.post(route('comments.store'), this.comment)
                .then(res => this.localComments.data.unshift(res.data))
            this.comment.text = ''
            this.cachedCommentText = ''
            this.addCommentFieldShowed = false
            this.post.comments_count += 1
            this.activeItem = null
        },

        addReply(i, comment) {
            axios.post(route('replies.store', comment), {text: this.reply.text[i], comment_id: comment.id, post_id: this.post.id})
                .then(res => {
                    this.localComments.data[i].comment_replies.unshift(res.data)
                    if (res.status === 200)
                    this.reply.text[i] = ''

                    this.showReplyAdded = i;
                    setTimeout(() => this.showReplyAdded = false,2000);
                })

        },

        setCommentLike(id) {
            axios.post(`/comment-like/${id}`).then((res) => {
                this.localComments.data.map(obj => {if (obj.id === res.data.comment.id) {
                    obj.likes_count = res.data.comment.likes_count
                    obj.likes = res.data.comment.likes
                }})
            })
        },

        setCommentReplyLike(id) {
            axios.post(`/comment-reply-like/${id}`).then((res) => {
                this.localComments.data.map(obj => obj.comment_replies.map(obj2 => {
                    if (obj2.id === res.data.commentReply.id) {
                        obj2.likes = res.data.commentReply.likes
                    }
                 })
                )
            })
        },

        loadMoreComments() {
            if (this.localComments.next_page_url) {
                axios.get(this.localComments.next_page_url).then(response => {
                    this.localComments = {
                        ...response.data,
                        data: [...this.localComments.data, ...response.data.data]
                    }
                })
            }
        },

        time_ago(time) {
            switch (typeof time) {
                case 'number':
                    break;
                case 'string':
                    time = +new Date(time);
                    break;
                case 'object':
                    if (time.constructor === Date) time = time.getTime();
                    break;
                default:
                    time = +new Date();
            }
            let time_formats = [
                [60, 'seconds', 1], // 60
                [120, '1 minute ago', '1 minute from now'], // 60*2
                [3600, 'minutes', 60], // 60*60, 60
                [7200, '1 hour ago', '1 hour from now'], // 60*60*2
                [86400, 'hours', 3600], // 60*60*24, 60*60
                [172800, 'Yesterday', 'Tomorrow'], // 60*60*24*2
                [604800, 'days', 86400], // 60*60*24*7, 60*60*24
                [1209600, 'Last week', 'Next week'], // 60*60*24*7*4*2
                [2419200, 'weeks', 604800], // 60*60*24*7*4, 60*60*24*7
                [4838400, 'Last month', 'Next month'], // 60*60*24*7*4*2
                [29030400, 'months', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
                [58060800, 'Last year', 'Next year'], // 60*60*24*7*4*12*2
                [2903040000, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
                [5806080000, 'Last century', 'Next century'], // 60*60*24*7*4*12*100*2
                [58060800000, 'centuries', 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
            ];
            let seconds = (+new Date() - time) / 1000,
                token = 'ago',
                list_choice = 1;

            if (seconds === 0) {
                return 'Just now'
            }
            if (seconds < 0) {
                seconds = Math.abs(seconds);
                token = 'from now';
                list_choice = 2;
            }
            let i = 0,
                format;
            while (format = time_formats[i++])
                if (seconds < format[0]) {
                    if (typeof format[2] == 'string')
                        return format[list_choice];
                    else
                        return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
                }
            return time;
        }
    }
}
</script>

<style scoped>
.post-width {
    width: 900px;
}

.input-font-sans::-webkit-input-placeholder {
    font-family: 'Fira Sans', Arial, Helvetica, sans-serif;
}

.input-font-sans:-ms-input-placeholder {
    font-family: 'Fira Sans', Arial, Helvetica, sans-serif;
}

.input-font-sans:-moz-placeholder {
    font-family: 'Fira Sans', Arial, Helvetica, sans-serif;
}

.input-font-sans::-moz-placeholder {
    font-family: 'Fira Sans', Arial, Helvetica, sans-serif;
}
/*.last-child-comment:last-child {*/
/*    border-bottom: none;*/
/*}*/
</style>
