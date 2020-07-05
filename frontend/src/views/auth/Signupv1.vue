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
                    <v-toolbar-title>Create an Account</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn
                                :href="source"
                                icon
                                large
                                target="_blank"
                                v-on="on"
                            >
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </template>
                        <span>Source</span>
                    </v-tooltip>
                </v-toolbar>
                <v-card-text>
                    <v-form ref="form" v-model="valid" lazy-validation>
                        <!--  -->
                        <!--  -->
                        <!-- <ValidationProvider
                                name="email"
                                rules="required|email"
                                v-slot="{ errors }"
                            >
                                <div class="field">
                                    <input v-model="email" type="email" />
                                    <span>{{ errors[0] }}</span>
                                </div>
                        </ValidationProvider>-->
                        <!--  -->
                        <!--  -->
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="firstname"
                                    :rules="nameRules"
                                    label="First Name"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="lastname"
                                    :rules="nameRules"
                                    label="Last Name"
                                    required
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-text-field
                            v-model="email"
                            :rules="emailRules"
                            label="E-Mail"
                            required
                        ></v-text-field>

                        <!-- <v-text-field
                            ref="password"
                            type="password"
                            v-model="password"
                            v-validate="'required'"
                            :error-messages="errors.collect('password')"
                            label="Pass"
                            data-vv-name="pass"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="passwordConfirmation"
                            type="password"
                            v-validate="'required|confirmed:password'"
                            :error-messages="errors.collect('passwordConfirmation')"
                            label="Pass 2"
                            data-vv-name="pass"
                            required
                        ></v-text-field>-->

                        <v-checkbox
                            v-model="checkbox"
                            :rules="[v => !!v || 'You must agree to continue!']"
                            label="Do you agree?"
                            required
                        ></v-checkbox>

                        <v-btn
                            :disabled="!valid"
                            color="success"
                            class="mr-4"
                            @click="validate"
                            >Validate</v-btn
                        >

                        <v-btn color="error" class="mr-4" @click="reset"
                            >Reset Form</v-btn
                        >

                        <v-btn color="warning" @click="resetValidation"
                            >Reset Validation</v-btn
                        >
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary">Login</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
export default {
    data: () => ({
        user: {
            firstname: '',
            lastname: '',
            email: '',
            password: '',
            passwordConfirmation: ''
        },
        dialog: true,
        dictionary: {
            attributes: {
                email: 'E-mail Address'
                // custom attributes
            },
            custom: {
                name: {
                    required: () => 'Name can not be empty',
                    max: 'The name field may not be greater than 10 characters'
                    // custom messages
                },
                select: {
                    required: 'Select field is required'
                }
            }
        },
        mounted() {
            this.$validator.localize('en', this.dictionary);
        },
        methods: {
            submit() {
                this.$validator.validateAll();
            },
            clear() {
                this.name = '';
                this.email = '';
                this.select = null;
                this.checkbox = null;
                this.$validator.reset();
            }
        }
    })
};
</script>
