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

            <div>
                <select name="" id=""></select>
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
                <div @click="form.type = 'post'" class="mr-4 flex items-center">
                    <input class="mr-2 w-5 h-5" type="radio" name="type" id="post">
                    <label for="post">Post</label>
                </div>

                <div  @click="form.type = 'primary_post'" class="mr-4 flex items-center">
                    <input class="mr-2 w-5 h-5" type="radio" name="type" id="primary_post">
                    <label for="primary_post">Primary Post</label>
                </div>

                <div  @click="form.type = 'front_page_post'" class="mr-4 flex items-center">
                    <input class="mr-2 w-5 h-5" type="radio" name="type" id="front_page_post">
                    <label for="front_page_post">Front Page Post</label>
                </div>
            </div>

            <jet-dropdown align="left" width="48">
                <template #trigger>
                    <div class="flex cursor-pointer items-center hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        <div v-if="form.category_id === null">Category</div>
                        <div v-else>{{ categoryName }}</div>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </template>

                <template #content>
                    <div v-for="category in categories">
                        <div @click="form.category_id = category.id; categoryName = category.name" class="hover:bg-gray-100 duration-200 cursor-pointer py-2 px-4">{{ category.name }}</div>
                    </div>
                </template>
            </jet-dropdown>


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
import JetDropdown from "@/Jetstream/Dropdown";

export default {
    layout: ProfileLayout,
    components: {JetButton, JetSecondaryButton, JetInput, JetInputError, JetDropdown},
    props: ["errors", "categories"],
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
                type: 'post',
                category_id: null,
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
