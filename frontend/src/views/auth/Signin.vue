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
                    <v-toolbar-title>Login</v-toolbar-title>
                    <v-spacer></v-spacer>

                    <v-btn icon large @click="$router.push({ name: 'home' })">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar>
                <v-card-text style="padding-top:20px">
                    <v-form ref="form" @keyup.native.enter="submit">
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
import { required, minLength, email } from 'vuelidate/lib/validators';
export default {
    computed: {
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
        }
    },
    data: () => ({
        test: '',
        user: {
            email: '',
            password: ''
        },
        dialog: true
    }),

    methods: {
        submit() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                this.$store
                    .dispatch('account/login', this.user)
                    .then(() => this.$router.push('/'))
                    .catch(err => console.log(err));
            }
        }
    },
    validations: {
        user: {
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(6)
            }
        }
    }
};
</script>
