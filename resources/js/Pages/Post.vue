<template>
    <div>
        <div class="uppercase mt-2 sans-bold">{{ post.category.name }}</div>

        <!--POST-->
        <div class="w-full mt-4 flex justify-center">
            <div class="post-width">
                <div class="font-serif font-bold text-3xl mb-4 text-center">{{post.title}}</div>

                <div class="font-serif text-xl leading-9 text-gray-600 mt-8 mb-2">{{post.brief}}</div>

                <!--CREATED AT-->
                <div class="flex sans uppercase text-gray-400">
                    <div class="text-xs">
                        {{`
                            ${new Date(post.created_at).toLocaleString('default', {month: 'long'})}
                            ${new Date(post.created_at).getDate()}, ${new Date(post.created_at).getFullYear()}
                        `}}
                    </div>
                    <div>
                        <div class="text-xs">
                            &nbsp;by
                            <inertia-link class="font-bold" :href="'/user/' + post.user.id">{{ post.user.name }}</inertia-link>
                        </div>
                    </div>

                </div>

                <div class="my-8">
                    <img class="mb-2" :src="post.image" alt="">
                    <div class="w-full font-serif text-xs text-gray-400 text-right">{{ post.image_description }}</div>
                </div>

                <div class="font-serif text-xl leading-9 text-gray-600 my-8">{{ post.body }}</div>
            </div>
        </div>

        <!--COMMENTS-->
        <div class="flex justify-center font-serif text-sm text-gray-600">
            <div class="post-width">
                <div v-if="post.comments_count < 1" class="uppercase mb-4 sans-bold">No comments yet</div>

                <div v-else-if="post.comments_count === 1" class="uppercase mb-4 sans-bold">{{ post.comments_count }} Comment:</div>

                <div v-else class="uppercase mb-4 sans-bold">{{ post.comments_count }} Comments:</div>

                <div class="" v-for="comment in comments.data" :key="comment.id">
                    <div class="py-4 border-t-2 border-gray-200 ">
                        <div class="flex">
                            <img class="w-12 h-12 mr-4" :src="comment.user.profile_photo_url" alt="">

                            <div>
                                <div class="mb-2">
                                    <inertia-link class="font-bold" :href="`/user/${comment.user.id}` ">{{ comment.user.name }}</inertia-link>
                                    {{ time_ago(comment.created_at) }}
                                </div>

                                <div class="mb-2">
                                    {{ comment.text }}
                                </div>
                            </div>
                        </div>

                        <!--show replies button-->
                        <div v-if="comment.comment_replies.length > 0" class="cursor-pointer sans flex justify-end"
                             @click="comment.active === 1 ? comment.active = 0 : comment.active = 1"
                        >
                            <div v-if="comment.comment_replies.length === 1">
                                <div v-if="comment.active === 1">Hide reply</div>
                                <div v-else>Show 1 reply</div>
                            </div>

                            <div v-else>
                                <div v-if="comment.active === 1">Hide replies</div>
                                <div v-else>Show {{ comment.comment_replies.length }} replies</div>
                            </div>
                        </div>
                    </div>

                    <!--COMMENT'S REPLIES-->
                    <div v-if="comment.active === 1" class="ml-12" v-for="reply in comment.comment_replies">
                        <div class="py-4 border-t-2 border-gray-200 "
                             :class="{'' : comment.comment_replies.length === 1}"
                        >
                            <div class="flex">
                                <img class="w-12 h-12 mr-4" :src="reply.user.profile_photo_url" alt="">
                                <div>
                                    <div class="mb-2">
                                        <inertia-link class="font-bold" :href="`/user/${reply.user.id}` ">{{ reply.user.name }}</inertia-link>
                                        {{ time_ago(reply.created_at) }}
                                    </div>

                                    <div class="">
                                        {{ reply.text }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!--                <div class="flex sans-bold pt-4 justify-center capitalize flex-row">-->
<!--                    <inertia-link-->
<!--                        v-for="item in showComments.links"-->
<!--                        :key="item.id"-->
<!--                        :href="item.url || '#'"-->
<!--                    >-->
<!--                        <div class="px-2" :class="{'bg-gray-200 rounded' : item.active === true}" v-html="item.label"/>-->
<!--                    </inertia-link>-->
<!--                </div>-->

<!--                <div v-for="item in showComments.links">-->
<!--                    <div v-if="item.label === 'Next &raquo;'">adsf</div>-->
<!--                </div>-->

<!--                <div @click="showMoreComments()">asdf</div>-->

<!--                <inertia-link v-for="item in comments.links"-->
<!--                              :href="item.url"-->
<!--                >-->
<!--                    more-->
<!--                </inertia-link>-->


<!--                {{showComments.links}}-->
            </div>
        </div>
    </div>
</template>

<script>
import NewsLayout from "@/Layouts/NewsLayout";
export default {
    layout: NewsLayout,
    name: "Post",
    props: ["post", "categories", "comments", "user"],
    data: () => ({
        renderedComments: ''
    }),
    // mounted() {
    //     this.renderedCommentsthis = this.comments
    // },
    computed: {
        showComments() {

        },

        showMoreComments() {

            return this.comments + this.comments
        }
    },
    methods: {
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

    /*.last-child-comment:last-child {*/
    /*    border-bottom: none;*/
    /*}*/
</style>
