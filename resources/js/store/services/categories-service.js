import axios from "axios";

function getCategoriesList() {
    return axios.get('/api/getCategoriesList').then((response) => {
        return {
            categoriesList: response.data.data
        };
    });
}

function getCategoriesLots(params) {
    return axios.post('/api/getCategoriesLots', params).then((response) => {
        return {
            categoriesLots: response.data.data
        };
    });
}
export default {
    getCategoriesList,
    getCategoriesLots
}
