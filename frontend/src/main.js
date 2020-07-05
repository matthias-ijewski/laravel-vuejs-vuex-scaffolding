import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store/index';
import vuetify from './plugins/vuetify';
import Axios from 'axios';
import VuetifyConfirm from 'vuetify-confirm';
import VueMoment from 'vue-moment';
const moment = require('moment');
require('moment/locale/de');

Vue.use(VueMoment, {
    moment
});

Vue.config.productionTip = false;

Vue.prototype.$http = Axios;

const token = localStorage.getObj('token');

if (token) {
    Vue.prototype.$http.defaults.headers.common['Authorization'] =
        'Bearer ' + token.access_token;
}

Vue.use(VuetifyConfirm, {
    vuetify,
    buttonTrueText: 'Ja',
    buttonFalseText: 'Nein'
});
export const bus = new Vue();
new Vue({
    router,
    store,
    vuetify,
    el: '#app',
    created() {
        //
        // check if user object exists
        if (this.$store.getters['account/user'] === null) {
            console.log('user is null');
        }
        //
        // else refresh token
        else {
            console.log('user is NOT null');
        }
        //
    },
    render: h => h(App)
});
