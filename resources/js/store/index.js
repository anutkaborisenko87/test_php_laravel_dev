import Vue from 'vue';
import Vuex from 'vuex';
import categories from './modules/categories-module';
import lots from "./modules/lots-module";
Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        errors: [],
    },
    modules: {
        categories,
        lots
    },
});
