import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../views/Home.vue';
import Vuelidate from 'vuelidate';
import store from '@/store/index.js';
import ImgAuth from '@/components/ImgAuth.vue';

Vue.use(Vuelidate);
Vue.use(VueRouter);

Vue.component('img-auth', ImgAuth);
const routes = [
    //
    // secured routes
    {
        path: '/secure',
        name: 'secure',
        component: () => import('@/views/Secure.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/account',
        name: 'account',
        component: () => import('@/views/Account.vue'),
        meta: {
            requiresAuth: true
        }
    },
    //
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/about',
        name: 'about',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import(/* webpackChunkName: "about" */ '@/views/About.vue')
    },
    {
        path: '/signup',
        name: '',
        component: () => import('@/components/EmptyRouterView.vue'),
        children: [
            {
                path: '',
                name: 'signup',
                components: {
                    default: () => import('@/views/Empty.vue'),
                    dialog: () => import('@/views/auth/Signup.vue')
                }
            }
        ]
    },
    {
        path: '/signin',
        name: '',
        component: () => import('@/components/EmptyRouterView.vue'),
        children: [
            {
                path: '',
                name: 'signin',
                components: {
                    default: () => import('@/views/Empty.vue'),
                    dialog: () => import('@/views/auth/Signin.vue')
                }
            }
        ]
    },
    {
        path: '/users',
        name: '',
        component: () => import('@/components/EmptyRouterView.vue'),
        children: [
            //
            // example route with dialog component
            {
                name: 'users.create',
                path: 'create',
                components: {
                    default: () => import('@/views/users/UsersIndex.vue'),
                    dialog: () =>
                        import('@/views/users/dialogs/UsersCreateDialog.vue')
                }
            }
            //
        ]
    },

    {
        path: '/customers',
        name: '',
        component: () => import('@/components/EmptyRouterView.vue'),
        children: [
            {
                name: 'customers.index',
                path: '',
                component: () => import('@/views/customers/CustomersIndex.vue')
            },
            {
                name: 'customers.create',
                path: 'create',
                component: () => import('@/views/customers/CustomersCreate.vue')
            },
            //
            // example for deep nested route (addresses of a customer)
            {
                name: '',
                path: ':customer_id(\\d+)',
                component: () => import('@/components/EmptyRouterView.vue'),
                children: [
                    //
                    // base route for customers show
                    {
                        name: 'customers.show',
                        path: '',
                        component: () =>
                            import('@/views/customers/CustomersShow.vue')
                    },
                    //
                    // deep route
                    {
                        name: 'customers.addresses.index',
                        path: 'addresses',
                        component: () =>
                            import(
                                '@/views/customers/addresses/AddressesIndex.vue'
                            )
                    }
                    //
                ]
            }
            //
        ]
    }
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
});

router.beforeEach((to, from, next) => {
    console.log(from);
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters['account/isLoggedIn']) {
            next();
            return;
        }
        next('/signin');
    } else {
        next();
    }
});

export default router;
