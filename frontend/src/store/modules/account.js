import axios from 'axios';
//
// enable the localstorage to store objects
Storage.prototype.setObj = function(key, obj) {
    return this.setItem(key, JSON.stringify(obj));
};
Storage.prototype.getObj = function(key) {
    return JSON.parse(this.getItem(key));
};
//
export default {
    namespaced: true,
    state: {
        status: '',
        token: localStorage.getObj('token') || {}
    },
    mutations: {
        auth_request(state) {
            state.status = 'loading';
        },
        auth_success(state, { token }) {
            state.status = 'success';
            state.token = token;
        },
        update_account_request(state) {
            state.status = 'loading';
        },
        update_account_success(state, { token }) {
            state.status = 'success';
            state.token = token;
        },
        update_account_error(state) {
            state.status = 'error';
        },
        upload_avatar_request(state) {
            state.status = 'loading';
        },
        upload_avatar_success(state, { avatarUrl }) {
            state.status = 'success';
            state.token.user.avatar = avatarUrl;
            localStorage.setObj('token', state.token);
        },
        upload_avatar_error(state) {
            state.status = 'error';
        },
        auth_error(state) {
            state.status = 'error';
        },
        logout(state) {
            state.status = '';
            state.token = '';
        }
    },

    actions: {
        updateAccount({ commit }, user) {
            return new Promise((resolve, reject) => {
                commit('update_account_request');
                let data = {
                    firstname: user.firstname,
                    lastname: user.lastname,
                    email: user.email,
                    _method: 'PUT'
                };
                axios({
                    url: '/api/account',
                    data: data,
                    method: 'POST'
                })
                    .then(resp => {
                        console.log(this.state.account.token);
                        let token = this.state.account.token;
                        token.user = resp.data.user;
                        localStorage.setObj('token', token);
                        commit('update_account_success', {
                            token
                        });
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('update_account_error');
                        localStorage.removeItem('token');
                        reject(err);
                    });
            });
        },
        uploadAvatar({ commit }, avatar) {
            return new Promise((resolve, reject) => {
                commit('upload_avatar_request');

                let formData = new FormData();
                formData.append('file', avatar.imageFile);

                axios({
                    url: '/api/account/avatar',
                    data: formData,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    method: 'POST'
                })
                    .then(resp => {
                        let avatarUrl = resp.data.url;
                        commit('upload_avatar_success', {
                            avatarUrl
                        });
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('update_account_error');
                        localStorage.removeItem('token');
                        reject(err);
                    });
            });
        },
        login({ commit }, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request');
                let pr = process.env;
                console.log(pr);
                let data = {
                    grant_type: 'password',
                    client_id: process.env.VUE_APP_API_CLIENT_ID,
                    client_secret: process.env.VUE_APP_API_CLIENT_SECRET,
                    username: user.email,
                    password: user.password,
                    scope: process.env.VUE_APP_API_CLIENT_SCOPE
                };
                axios({
                    url: '/api/auth/token',
                    data: data,
                    method: 'POST'
                })
                    .then(resp => {
                        const token = resp.data;
                        debugger;
                        localStorage.setObj('token', token);
                        axios.defaults.headers.common['Authorization'] =
                            'Bearer ' + token.access_token;
                        commit('auth_success', {
                            token
                        });
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('auth_error');
                        localStorage.removeItem('token');
                        reject(err);
                    });
            });
        },
        logout({ commit }) {
            return new Promise((resolve, reject) => {
                console.log(reject);
                commit('logout');
                localStorage.removeItem('token');
                delete axios.defaults.headers.common['Authorization'];
                resolve();
            });
        },
        register({ commit }, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request');
                let data = {
                    grant_type: 'password',
                    client_id: process.env.VUE_APP_API_CLIENT_ID,
                    client_secret: process.env.VUE_APP_API_CLIENT_SECRET,
                    email: user.email,
                    firstname: user.firstname,
                    lastname: user.lastname,
                    password: user.password,
                    scope: process.env.VUE_APP_API_CLIENT_SCOPE
                };
                axios({
                    url: '/api/auth/register',
                    data: data,
                    method: 'POST'
                })
                    .then(resp => {
                        const token = resp.data;
                        localStorage.setObj('token', token);
                        axios.defaults.headers.common['Authorization'] =
                            'Bearer ' + token.access_token;
                        commit('auth_success', {
                            token
                        });
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('auth_error', err);
                        localStorage.removeItem('token');
                        reject(err);
                    });
            });
        }
    },

    getters: {
        //
        // return true, if the access_token is set
        isLoggedIn: state => {
            console.log('######## AUTH TOKEN ########');
            console.log((state.token || {}).access_token);
            console.log('######## ########## ########');
            return !!(state.token || {}).access_token;
        },
        avatar: state => {
            return ((state.token || {}).user || {}).avatar;
        },
        //
        // can be success, error or empty
        authStatus: state => state.status,
        //
        // get the user with salutation from the enriched token response
        user: state => (state.token || {}).user
        //
    }
};
