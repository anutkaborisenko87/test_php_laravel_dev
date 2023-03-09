import service from '../services/lots-service';

const state = {
    newAuctionPrice: {}
};

const mutations = {
    SET_NEW_PRICE: (state, newAuctionPrice) => {
        state.newAuctionPrice = newAuctionPrice;
    }
};

const actions = {
    newAuctionPrice({commit, dispatch}, params) {
        return service.setNewAuctionPrice(params).then(({newAuctionPrice}) => {
            commit('SET_NEW_PRICE', newAuctionPrice);
        });
    }
}

const getters = {
    newAuctionPrice: state => state.newAuctionPrice
};

const lots = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}

export default lots;
