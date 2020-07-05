<template>
    <v-app id="laratime">
        <v-navigation-drawer v-model="drawer" :clipped="$vuetify.breakpoint.lgAndUp" app>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="title">Administration</v-list-item-title>
                    <!-- <v-list-item-subtitle>subtext</v-list-item-subtitle> -->
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list v-if="isLoggedIn">
                <router-link
                    :to="{ name: 'account' }"
                    v-slot="{
                        href,
                        route,
                        navigate,
                        isActive,
                        isExactActive
                    }"
                >
                    <v-list-item link>
                        <v-list-item-avatar @click="navigate">
                            <img-auth :src="avatarUrl" w="100" />
                        </v-list-item-avatar>

                        <v-list-item-content>
                            <v-list-item-title @click="navigate">
                                {{
                                ($store.getters['account/user'] || {}).fullname
                                }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </router-link>
            </v-list>
            <v-divider></v-divider>
            <v-list dense>
                <v-list-item v-for="item in items" :key="item.title" link :to="{name: item.route}">
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app>
            <v-app-bar-nav-icon @click="toggleDrawer"></v-app-bar-nav-icon>
            <v-toolbar-title class="headline text-uppercase">
                <span>Vue</span>
                <span class="font-weight-light">Scaffolding</span>
            </v-toolbar-title>

            <v-spacer></v-spacer>
            <router-link to="/signup" v-slot="{ href, route, navigate, isActive, isExactActive }">
                <v-btn
                    @click="navigate"
                    text
                    :class="[
                        isActive && 'router-link-active',
                        isExactActive && 'router-link-exact-active'
                    ]"
                >
                    <span class="mr-2" v-if="!isLoggedIn">Create Account</span>
                </v-btn>
            </router-link>
            <v-btn v-if="isLoggedIn" text @click="logout">
                <span class="mr-2">Logout</span>
            </v-btn>
            <router-link
                v-else
                to="/signin"
                v-slot="{ href, route, navigate, isActive, isExactActive }"
            >
                <v-btn text @click="navigate">
                    <span class="mr-2">Login</span>
                </v-btn>
            </router-link>
        </v-app-bar>

        <v-content transition="slide-x-transition">
            <!-- <keep-alive> -->
                <router-view :key="$route.fullPath"></router-view>
            <!-- </keep-alive> -->
        </v-content>
    </v-app>
</template>

<script>
export default {
    name: 'App',
    computed: {
        avatarUrl() {
            return this.$store.getters['account/avatar'];
        },
        isLoggedIn() {
            return this.$store.getters['account/isLoggedIn'];
        }
    },
    created() {
        this.$http.interceptors.response.use(undefined, function(err) {
            return new Promise(function(resolve, reject) {
                console.log(resolve, reject);
                if (
                    err.status === 401 &&
                    err.config &&
                    !err.config.__isRetryRequest
                ) {
                    debugger;
                    this.$store.dispatch('account/logout');
                }
                throw err;
            });
        });
    },
    data: () => ({
        drawer: true,
        items: [
            {
                title: 'Beispielseite',
                icon: 'mdi-account',
                route: 'customers.index'
            },
        ]
    }),
    methods: {
        logout() {
            this.$store.dispatch('account/logout').then(() => {
                this.$router.push('/signin');
            });
        },
        toggleDrawer() {
            this.drawer = !this.drawer;
        }
    }
};
</script>
<style scoped>
.router-link-active {
    background-color: #efefef;
}
</style>
