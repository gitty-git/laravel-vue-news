<template>
    <div class="">
        <div class="uppercase mt-2 font-sans font-bold border-gray-20">
            <span class="pr-2 mr-2 text-black border-r-2">Edit Post</span>
            <span>
                <span class="text-sm underline cursor-pointer text-gray-400 font-normal normal-case" @click="cancel">Back to previous page</span>
            </span>
        </div>

        <div class="flex justify-center mt-4">
            <form @submit.prevent="updatePost" class="flex flex-col create-width">
                <!--Category-->
                <div class="mb-4">
                    <jet-dropdown align="left">
                        <template #trigger>
                            <div class="flex cursor-pointer items-center hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div v-if="post.category_id === null">Category</div>

                                <div v-else v-for="category in categories">
                                    <div v-if="category.id === post.category_id" >{{ category.name }}</div>
                                </div>


                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </template>

                        <template #content>
                            <div v-for="category in categories">
                                <!--                            <div v-if="post.error('category_id')" v-model="post.error('category_id')"></div>-->
                                <div @click="post.category_id = category.id; categoryName = category.name" class="text-sm hover:bg-gray-100 duration-200 cursor-pointer py-2 px-4">{{ category.name }}</div>
                            </div>
                        </template>
                    </jet-dropdown>
                    <div class="text-sm text-gray-500">Select a category of the post. Required.</div>
                    <jet-input-error :message="errors.type" class="mt-1" />
                </div>

                <!--Title-->
                <div class="mb-4" id="scroll_to_title">
                    Title
                    <div class="text-sm text-gray-500">Must be unique, maximum characters: 100. Required.</div>
                    <jet-input id="title" type="text" class="mt-1 block w-full font-serif" v-model="localPost.title" autocomplete="title" />
                    <jet-input-error :message="errors.title" class="mt-1"/>
                </div>

                <!--Brief-->
                <div class="mb-4 flex-col flex">
                    Brief
                    <div class="text-sm mb-1 text-gray-500">Short description of the post. Maximum characters: 200. Required.</div>
                    <textarea class="bg-gray-100 outline-none px-2 py-2 font-serif" v-model="localPost.brief" name="brief" id="brief" rows="3"></textarea>
                    <jet-input-error :message="errors.brief" class="mt-1" />
                </div>

                <!-- Image -->
                <div class="mb-5">
                    Image
                    <div class="text-sm text-gray-500">File must be an image, maximum size: 5MB. Aspect ratio: 3:2. Required.</div>
                    <!-- Image File Input -->
                    <input type="file" class="hidden"
                           ref="image"
                           @change="updateImagePreview">

                    <!-- Current Image Preview -->
                    <div class="mt-2" v-show="!imagePreview">
                        <img :src="'/storage/' + post.image" alt="Current Post Image" class="w-full">
                    </div>

                    <!-- New Image Preview -->
                    <div class="mt-1" v-show="imagePreview">
                        <img class="w-full" :src="imagePreview" alt="">
                    </div>

                    <jet-secondary-button class="mt-2 mr-2" type="button" @click.native.prevent="selectNewImage">
                        Change Image
                    </jet-secondary-button>

                    <jet-input-error :message="errors.image" class="mt-1" />
                </div>

                <!--Image Description-->
                <div class="mb-4">
                    Image Description
                    <div class="text-sm text-gray-500">Brief description of the picture. Maximum characters: 100. Required.</div>
                    <jet-input id="image_description" type="text" class="mt-1 block w-full font-serif" v-model="localPost.image_description" autocomplete="image_description" />
                    <jet-input-error :message="errors.image_description" class="mt-1" />
                </div>

                <!--Body-->
                <div class="mb-4 flex-col flex">
                    Body
                    <div class="text-sm mb-1 text-gray-500">Optional</div>
                    <textarea class="bg-gray-100 outline-none px-2 py-2 font-serif" v-model="localPost.body" name="body" id="body" cols="10" rows="10"></textarea>
                    <jet-input-error :message="errors.body" class="mt-1" />
                </div>

                <!--Slug-->
                <div class="mb-4">
                    Slug
                    <div class="text-sm text-gray-500">Optional, kebab-case. If not inputted, it will be taken from the "Title" field. Maximum characters: 100.</div>
                    <jet-input id="slug" type="text" class="mt-1 block w-full font-serif" v-model="localPost.slug" autocomplete="slug" />
                    <jet-input-error :message="errors.slug" class="mt-1" />
                </div>

                <!--Type-->
                <div class="mb-4">
                    Type
                    <div class="text-sm text-gray-500">Select post type. Required.</div>
                    <div class="flex my-2">
                        <div @click="localPost.type = 'post'" class="mr-4 flex items-center">
                            <input class="mr-2 w-4 h-4" type="radio" name="type" id="post">
                            <label for="post">Post</label>
                        </div>

                        <div  @click="localPost.type = 'primary_post'" class="mr-4 flex items-center">
                            <input class="mr-2 w-4 h-4" type="radio" name="type" id="primary_post">
                            <label for="primary_post">Primary Post</label>
                        </div>

                        <div  @click="localPost.type = 'front_page_post'" class="mr-4 flex items-center">
                            <input class="mr-2 w-4 h-4" type="radio" name="type" id="front_page_post">
                            <label for="front_page_post">Front Page Post</label>
                        </div>
                    </div>
                    <jet-input-error :message="errors.type" class="mt-1" />
                </div>

                <jet-button class="mb-4 mr-2" type="submit">
                    <span v-if="msg">{{msg}}</span>
                    <span v-else>Update</span>
                </jet-button>
            </form>
        </div>
    </div>
</template>

<script>
import JetInputError from "@/Jetstream/InputError";
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetInput from "@/Jetstream/Input";
import ProfileLayout from "@/Layouts/ProfileLayout";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDangerButton from "@/Jetstream/DangerButton";
import {Inertia} from "@inertiajs/inertia";

export default {
    layout: ProfileLayout,
    components: {JetButton, JetSecondaryButton, JetInput, JetInputError, JetDropdown, JetDangerButton},
    props: ["errors", "categories", "post"],
    name: "Edit",
    data() {
        return {
            deleteShowed: false,
            localPost: {
                _method: 'PUT',
                id: this.post.id,
                title: this.post.title,
                brief: this.post.brief,
                image: this.post.image,
                image_description: this.post.image_description,
                body: this.post.body,
                slug: this.post.slug,
                is_published: this.post.is_published,
                type: this.post.type,
                category_id: this.post.category_id,
            },
            photoPreview: null,
            imagePreview: null,
            msg: null
        }
    },
    methods: {
        updatePost() {
            if (this.$refs.image) {
                this.localPost.image = this.$refs.image.files[0]
            }

            Inertia.post(route('posts.update', this.localPost.id), this.localPost, {
                preserveScroll: true,
                onSuccess: () => {
                    this.msg = "Updated!"
                    setTimeout(() => this.msg = null,2000);
                },
                onError: () => {
                    this.msg = "Not updated! Check for errors!"
                    setTimeout(() => this.msg = null,2000);
                }
            })

        },

        selectNewImage() {
            this.$refs.image.click()
        },

        updateImagePreview() {
            const reader = new FileReader()

            reader.onload = (e) => {
                this.imagePreview = e.target.result
            };

            reader.readAsDataURL(this.$refs.image.files[0])
        },

        cancel() {
            window.history.back();
        }
    }
}
</script>

<style scoped>
.create-width {
    width: 900px;
}

/*.last-child-comment:last-child {*/
/*    border-bottom: none;*/
/*}*/
</style>
