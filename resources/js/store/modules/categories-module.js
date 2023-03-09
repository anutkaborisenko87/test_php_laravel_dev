import service from '../services/categories-service';

const state = {
    categoriesList: {},
    categoriesLots: {}
};

const mutations = {
    SET_CATEGORIES_LIST: (state, categoriesList) => {
        state.categoriesList = categoriesList;
    },
    SET_CATEGORIES_LOTS: (state, categoriesLots) => {
        state.categoriesLots = categoriesLots;
    }
};

const actions = {
    categoriesList({commit, dispatch}, params) {
        return service.getCategoriesList(params).then(({categoriesList}) => {
           commit('SET_CATEGORIES_LIST', categoriesList);
        });
    },
    categoriesLots({commit, dispatch}, params) {
        return service.getCategoriesLots(params).then(({categoriesLots}) => {
            commit('SET_CATEGORIES_LOTS', categoriesLots);
        });
    }
};

const getters = {
    categoriesList: state => state.categoriesList,
    categoriesLots: state => state.categoriesLots
};

const categories = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};

export default categories;
