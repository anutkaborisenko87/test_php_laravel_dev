import axios from "axios";

function setNewAuctionPrice(params) {
    return axios.post('/api/newLotPrice/' + params.lot_id, params).then((response) => {
        return {
            newAuctionPrice: response.data
        };
    });
}
export default {
    setNewAuctionPrice
}
