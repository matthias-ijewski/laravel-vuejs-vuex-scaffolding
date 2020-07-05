import Vue from 'vue';
import Vuex from 'vuex';
import account from './modules/account';

Vue.use(Vuex);
//
// enable the localstorage to store objects
Storage.prototype.setObj = function(key, obj) {
    return this.setItem(key, JSON.stringify(obj));
};
Storage.prototype.getObj = function(key) {
    return JSON.parse(this.getItem(key));
};
//
export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        account
    }
});
