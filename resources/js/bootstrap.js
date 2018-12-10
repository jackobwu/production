import Vue from 'vue';
import store2 from 'store2';
import Vuetify from 'vuetify';
import { auth, config } from './util/mixins';
import axios from 'axios';
import interceptors from './util/interceptors';
import Route from 'vue-routisan';
import ErrorPage from 'vue-error-page';

Vue.config.productionTip = false;

window.storage = store2;
window.storage._.fn('pull', function (key) {
    return this.remove(key);
});

window.eventBus = new Vue();

Vue.use(ErrorPage, {
    resolver: (component) => require(`./views/Errors/${component}`)
});

Vue.use(Vuetify);

Vue.mixin(auth);
Vue.mixin(config);

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.interceptors.request.use(...interceptors.request);
axios.interceptors.response.use(...interceptors.response);
Vue.prototype.$http = axios;

Route.setViewResolver((component) => require(`./views/${component}`));
