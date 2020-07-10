<template>
    <v-container fluid>
        <v-layout column>
            <v-card>
                <v-card-text>
                    <v-flex class="mb-4">
                        <image-input v-model="avatar">
                            <div slot="activator">
                                <v-avatar
                                    size="150px"
                                    v-ripple
                                    v-if="!avatar && !avatarUrl"
                                    class="grey lighten-3 mb-3"
                                >
                                    <span>Click to add avatar</span>
                                </v-avatar>
                                <v-avatar size="150px" v-ripple v-else class="mb-3">
                                    <img
                                        v-if="(avatar || {}).imageUrl"
                                        :src="avatar.imageUrl"
                                        alt="avatar"
                                    />
                                    <img-auth v-else :src="avatarUrl" alt="avatar" w="150" />
                                </v-avatar>
                            </div>
                        </image-input>
                    </v-flex>
                    <v-text-field
                        v-model="user.firstname"
                        label="FirstName"
                        :error-messages="firstnameErrors"
                    ></v-text-field>
                    <v-text-field
                        v-model="user.lastname"
                        label="Last Name"
                        :error-messages="lastnameErrors"
                    ></v-text-field>
                    <v-text-field
                        v-model="user.email"
                        label="Email Address"
                        :error-messages="emailErrors"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn v-if="!saving" color="primary" :loading="loading" @click="submit">
                        <v-icon left dark v-if="saved">mdi-check</v-icon>Save
                        Changes
                    </v-btn>
                    <v-btn v-else color="primary" :loading="loading" @click="submit">
                        <div class="pr-3">
                            <v-progress-circular indeterminate color="white" size="20"></v-progress-circular>
                        </div>Saving Changes
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-layout>
    </v-container>
</template>

<script>
import ImageInput from '@/components/ImageInput.vue';
import { required, minLength, email } from 'vuelidate/lib/validators';

export default {
    pageTitle: 'My Profile',
    components: { ImageInput },
    computed: {
        firstnameErrors() {
            const errors = [];
            if (!this.$v.user.firstname.$dirty) return errors;
            !this.$v.user.firstname.minLength &&
                errors.push('First name must be at least 2 characters long');
            !this.$v.user.firstname.required &&
                errors.push('First name is required.');
            return errors;
        },
        lastnameErrors() {
            const errors = [];
            if (!this.$v.user.lastname.$dirty) return errors;
            !this.$v.user.lastname.minLength &&
                errors.push('Last name must be at least 2 characters long');
            !this.$v.user.lastname.required &&
                errors.push('Last name is required.');
            return errors;
        },
        emailErrors() {
            const errors = [];
            if (!this.$v.user.email.$dirty) return errors;
            !this.$v.user.email.email &&
                errors.push('Please enter a valid e-mail address.');
            !this.$v.user.email.required &&
                errors.push('E-mail name is required.');
            return errors;
        },
        avatarUrl() {
            return this.$store.getters['account/avatar'];
        }
    },
    data() {
        return {
            test: 'http://127.0.0.1:8000/api/user/images/account/avatar.png',
            avatar: null,
            saving: false,
            saved: false,
            loading: false,
            user: {
                firstname: (this.$store.getters['account/user'] || {})
                    .firstname,
                lastname: (this.$store.getters['account/user'] || {}).lastname,
                email: (this.$store.getters['account/user'] || {}).email
            }
        };
    },
    methods: {
        // savedAvatar() {
        //     this.saving = false;
        //     this.saved = true;
        // },
        // uploadImage() {
        //     this.saving = true;
        //     setTimeout(() => this.savedAvatar(), 1000);
        // },
        submit() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                this.saving = true;
                let promiseArr = [];
                promiseArr.push(
                    this.$store
                        .dispatch('account/updateAccount', this.user)
                        .then(() => console.log('account updated'))
                        .catch(err => console.log(err))
                );
                if (this.avatar) {
                    promiseArr.push(
                        this.$store
                            .dispatch('account/uploadAvatar', this.avatar)
                            .then(() => console.log('avatar uploaded'))
                            .catch(err => console.log(err))
                    );
                }
                Promise.all(promiseArr).then(() => {
                    this.saving = false;
                    this.saved = true;
                });
            }
        }
    },
    validations: {
        user: {
            firstname: {
                required,
                minLength: minLength(2)
            },
            lastname: {
                required,
                minLength: minLength(2)
            },
            email: {
                required,
                email
            }
        }
    },
    watch: {
        avatar: {
            handler: function() {
                this.saved = false;
            },
            deep: true
        }
    }
};
</script>
