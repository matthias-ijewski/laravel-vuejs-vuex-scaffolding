<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialog"
            overlay-opacity="1"
            overlay-color="white"
            persistent
            max-width="600px"
        >
            <v-card class="elevation-12">
                <v-toolbar color="primary" dark flat>
                    <v-toolbar-title>Create Account</v-toolbar-title>
                    <v-spacer></v-spacer>

                    <v-btn icon large @click="$router.push({ name: 'home' })">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar>
                <v-card-text>
                    <v-form ref="form" @keyup.native.enter="submit">
                        <v-row>
                            <v-col cols="12" md="3">
                                <v-select
                                    :items="salutations"
                                    v-model="user.salutation"
                                    item-text="text"
                                    item-value="id"
                                    label="Salutation"
                                ></v-select>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field
                                    v-model="user.firstname"
                                    label="First Name"
                                    @blur="$v.user.firstname.$touch()"
                                    :error-messages="firstnameErrors"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="5">
                                <v-text-field
                                    v-model="user.lastname"
                                    label="Last Name"
                                    @blur="$v.user.lastname.$touch()"
                                    :error-messages="lastnameErrors"
                                    required
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-text-field
                            v-model="user.email"
                            label="E-Mail"
                            @blur="$v.user.email.$touch()"
                            :error-messages="emailErrors"
                            required
                        ></v-text-field>

                        <v-text-field
                            type="password"
                            v-model="user.password"
                            label="Password"
                            @blur="$v.user.password.$touch()"
                            :error-messages="passwordErrors"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="user.passwordConfirmation"
                            type="password"
                            @blur="$v.user.passwordConfirmation.$touch()"
                            :error-messages="passwordConfirmationErrors"
                            label="Password Confirmation"
                            required
                        ></v-text-field>

                        <v-checkbox
                            v-model="user.tos"
                            label="Do you agree?"
                            @change="$v.user.tos.$touch()"
                            @blur="$v.user.tos.$touch()"
                            :error-messages="tosErrors"
                            required
                        ></v-checkbox>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="submit">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
import { required, minLength, sameAs, email } from 'vuelidate/lib/validators';
export default {
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
        passwordErrors() {
            const errors = [];
            if (!this.$v.user.password.$dirty) return errors;
            (!this.$v.user.password.minLength ||
                !this.$v.user.password.required) &&
                errors.push('Password must be at least 6 characters long.');
            return errors;
        },
        passwordConfirmationErrors() {
            const errors = [];
            if (
                !this.$v.user.password.$dirty ||
                !this.$v.user.passwordConfirmation.$dirty
            )
                return errors;
            !this.$v.user.passwordConfirmation.sameAsPassword &&
                errors.push('Passwords do not match.');
            return errors;
        },
        tosErrors() {
            const errors = [];
            if (!this.$v.user.tos.$dirty) return errors;
            !this.$v.user.tos.checked &&
                errors.push('You must agree to continue.');
            return errors;
        }
    },
    data: () => ({
        test: '',
        user: {
            firstname: '',
            lastname: '',
            email: '',
            password: '',
            passwordConfirmation: '',
            tos: false,
            salutation: 2
        },
        salutations: [{ id: 0, text: 'Mr' }, { id: 1, text: 'Mrs' }],
        dialog: true
    }),

    methods: {
        submit() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                this.$store
                    .dispatch('account/account.update', this.user)
                    .then(() => {
                        console.log('###');
                    })
                    .catch(err => console.log(err));
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
            },
            tos: {
                checked(val) {
                    return val;
                }
            },
            password: {
                required,
                minLength: minLength(6)
            },
            passwordConfirmation: {
                sameAsPassword: sameAs('password')
            }
        }
    }
};
</script>
