<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description class="mb-4">
            Update your account's profile information and email address.
        </template>

        <template #form >
            <!-- Profile Photo -->
            <div class="my-4 flex justify-center flex-col" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                       ref="photo"
                       @change="updatePhotoPreview">

                <jet-label for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div class="mb-4 flex justify-center" v-show="! photoPreview">
                    <img :src="user.profile_photo_url" :alt="user.name" class="h-36 w-36 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mb-4 flex justify-center" v-show="photoPreview">
                    <span class="block h-36 w-36"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <jet-secondary-button class="mb-4" type="button" @click.native.prevent="selectNewPhoto">
                    Select A New Photo
                </jet-secondary-button>

                <jet-secondary-button type="button" class="mb-4" @click.native.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Remove Photo
                </jet-secondary-button>

                <jet-input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="mb-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message v-if="form.recentlySuccessful" :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
    },

    props: ['user'],

    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                name: this.user.name,
                email: this.user.email,
                photo: null,
            }),

            photoPreview: null,
        }
    },

    methods: {
        updateProfileInformation() {
            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0]
            }

            this.form.post(route('user-profile-information.update'), {
                errorBag: 'updateProfileInformation',
                preserveScroll: true
            });
        },

        selectNewPhoto() {
            this.$refs.photo.click();
        },

        updatePhotoPreview() {
            const reader = new FileReader();

            reader.onload = (e) => {
                this.photoPreview = e.target.result;
            };

            reader.readAsDataURL(this.$refs.photo.files[0]);
        },

        deletePhoto() {
            this.$inertia.delete(route('current-user-photo.destroy'), {
                preserveScroll: true,
                onSuccess: () => (this.photoPreview = null),
            });
        },
    },
}
</script>
