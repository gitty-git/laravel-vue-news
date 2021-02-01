<template>
    <div>
        <form @submit.prevent="storePost" class="flex flex-col">
            <div class="">
                Title
                <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" autocomplete="title" />
                <jet-input-error :message="form.error('title')" class="mt-2" />
            </div>


            <div class="mt-2 flex-col flex">
                Brief
                <textarea class="bg-gray-100" v-model="form.brief" name="brief" id="brief" cols="10" rows="10"></textarea>
                <jet-input-error :message="form.error('brief')" class="mt-2" />
            </div>

            <!-- Image -->
            <div class="col-span-6 sm:col-span-4">
                <!-- Image File Input -->
                <input type="file" class="hidden"
                       ref="image"
                       @change="updateImagePreview">

                <!-- New Image Preview -->
                <div class="mt-2" v-show="imagePreview">
                    <img class="w-full" :src="imagePreview" alt="">
<!--                    <div class="w-full h-full"-->
<!--                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + imagePreview + '\');'">-->
<!--                    </div>-->
                </div>

                <jet-secondary-button class="mt-2 mr-2" type="button" @click.native.prevent="selectNewImage">
                    Select An Image
                </jet-secondary-button>

                <jet-input-error :message="form.error('image')" class="mt-2" />
            </div>

            <div class="mt-2 flex-col flex">
                Body
                <textarea class="bg-gray-100" v-model="form.body" name="body" id="body" cols="10" rows="10"></textarea>
                <jet-input-error :message="form.error('body')" class="mt-2" />
            </div>

            <div class="">
                Slug
                <jet-input id="slug" type="text" class="mt-1 block w-full" v-model="form.slug" autocomplete="slug" />
                <jet-input-error :message="form.error('slug')" class="mt-2" />
            </div>

<!--            <jet-input class="mb-2" v-model="form.image_description" type="text" name="image_description"></jet-input>-->
            <div class="flex my-2">
                <div class="mr-4 flex items-center">
                    <input class="mr-2 w-5 h-5" v-model="form.type = 'post'" type="radio" name="type" id="post">
                    <label for="post">Post</label>
                </div>

                <div class="mr-4 flex items-center">
                    <input class="mr-2 w-5 h-5" v-model="form.type = 'primary_post'" type="radio" name="type" id="primary_post">
                    <label for="primary_post">Primary Post</label>
                </div>

                <div class="mr-4 flex items-center">
                    <input class="mr-2 w-5 h-5" v-model="form.type = 'front_page_post'" type="radio" name="type" id="front_page_post">
                    <label for="front_page_post">Front Page Post</label>
                </div>
            </div>


<!--            <div class="mt-2 flex">-->
<!--                <div class="w-5 h-5 bg-gray-100 rounded-full">-->
<!--                    <div v-if=""></div>-->
<!--                </div>-->
<!--                <div class="w-5 h-5 bg-gray-100 rounded-full">-->
<!--                    <div v-if=""></div>-->
<!--                </div>-->
<!--                <div class="w-5 h-5 bg-gray-100 rounded-full">-->
<!--                    <div v-if=""></div>-->
<!--                </div>-->
<!--            </div>-->


            <div v-for="error in errors">
                {{error}}
            </div>

            <jet-button class="mt-2" type="submit">Post post</jet-button>
        </form>
    </div>
</template>

<script>
import JetInputError from "@/Jetstream/InputError";
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetInput from "@/Jetstream/Input";
import ProfileLayout from "@/Layouts/ProfileLayout";

export default {
    layout: ProfileLayout,
    components: {JetButton, JetSecondaryButton, JetInput, JetInputError},
    props: ["errors"],
    name: "Create",
    data() {
        return {
            form: this.$inertia.form({
                '_method': 'POST',
                title: null,
                brief: null,
                image: null,
                body: null,
                slug: null,
                is_published: true,
                type: null,
                category_id: 1,
                // user_id: 1,
                // primary_post: null,
                // front_page_post: null,
            }, {
                bag: 'createPost',
                resetOnSuccess: false,
            }),
            imagePreview: null,
        }
    },
    methods: {
        storePost() {
            if (this.$refs.image) {
                this.form.image = this.$refs.image.files[0]
            }

            this.form.post('/post/store', {
                preserveScroll: true
            });
        },

        selectNewImage() {
            this.$refs.image.click();
        },

        updateImagePreview() {
            const reader = new FileReader();

            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };

            reader.readAsDataURL(this.$refs.image.files[0]);
        },
    }
}
</script>

<style scoped>

</style>
