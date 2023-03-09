<template>
    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-4 card">
                <div class="card-header">
                    <h3>Categories</h3>
                </div>
                <div class="card-body">
                    <div class="form-check" v-if="categories.length > 0" v-for="category of categories"
                         :key="category.id">
                        <input v-model="filterCategories" class="form-check-input" type="checkbox" :id="category.title"
                               :value="category.id" @change="getCategoriesLots">
                        <label class="form-check-label" :for="category.title">
                            {{ category.title }}
                            <span class="badge rounded-pill text-bg-light">
                                {{ category.lots.length > 0 ? category.lots.length : 0 }}
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header"><h3>Auction lots</h3></div>
                    <div class="card-body">
                        <p  v-if="filteredLots.length > 0">
                            <span v-for="category of categoriesFiltered" :key="category.id" class="badge rounded-pill text-bg-secondary mx-2">
                                {{ category.title }}
                                <button type="button" class="btn-close" aria-label="Close" @click="deleteCatFromFilter(category)"></button>
                            </span>
                        </p>

                        <div class="row my-2" v-if="categoriesFiltered.length > 0" v-for="category of categoriesFiltered" :key="category.id">
                            <button type="button" class="btn btn-secondary my-1" data-bs-toggle="tooltip" data-bs-placement="right" :title="category.description">
                                {{ category.title }}
                            </button>
                            <b-carousel
                                id="carousel-1"
                                v-model="slide"
                                indicators
                                controls
                                :no-hover-pause="true"
                                :label-next="''"
                                :label-prev="''"
                                background="#ababab"
                                img-width="1024"
                                img-height="480"
                                style="text-shadow: 1px 1px 2px #333;"
                                @sliding-start="onSlideStart"
                                @sliding-end="onSlideEnd"
                            >
                                <b-carousel-slide v-for="lot of category.lots"
                                                  :key="lot.id" :caption="lot.title" img-blank :img-alt="lot.title">
                                    <div class="card bg-info">
                                        <div class="card-body">
                                            <p>{{ lot.description }}</p>
                                            <p v-if="lot.auction_price!== null">Price: <span class="fs-1">{{ lot.auction_price }} $</span>
                                                <span class="fs-6 text-decoration-line-through">{{ lot.start_price }}</span></p>
                                            <p v-else>Price: <span class="fs-1">{{ lot.start_price }} $</span></p>
                                            <p class="my-4">Sailor: <span class="fs-6">{{ lot.user.name }}</span></p>
                                        </div>
                                        <div class="card-footer">
                                            <div v-if="user !== null">
                                                <b-button id="show-btn" @click="showModal(lot)">Propose new price</b-button>
                                            </div>
                                            <div v-else>
                                                <a class="bth btn-outline-primary" href="/login">Login</a>
                                                or
                                                <a class="bth btn-outline-primary" href="/register">Register</a>
                                            </div>
                                        </div>
                                    </div>
                                </b-carousel-slide>
                            </b-carousel>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <b-modal ref="my-modal" hide-footer title="Using Component Methods">
            <div class="d-block text-center">
                <h3>{{ dataModal.title }}</h3>
                <p>{{ dataModal.description }}</p>
                <p v-if="dataModal.auction_price!== null">Price: <span class="fs-1">{{ dataModal.auction_price }}</span>
                    <span class="fs-6 text-decoration-line-through">{{ dataModal.start_price }}</span></p>
                <p v-else>Price: <span class="fs-1">{{ dataModal.start_price }}</span></p>
                <b-input-group prepend="Price:">
                    <b-input-group-prepend is-text><b>$</b></b-input-group-prepend>
                    <b-form-input type="number"
                                  :min="minModalPrice"
                                  v-model="newAuctionPrice"
                    ></b-form-input>
                </b-input-group>

                <p class="my-4">Sailor: <span class="fs-6">{{ dataModal.sailor }}</span></p>
            </div>
            <b-button class="mt-3" variant="outline-danger" block @click="hideModal">Close</b-button>
            <b-button v-if="validNewPrice" class="mt-2" variant="outline-warning" block @click="sendNewPrice">Propose</b-button>
        </b-modal>
    </div>
</template>

<script>
export default {
    props: {
      user: {
          default: null
      }
    },
    data() {
        return {
            categories: [],
            filterCategories: [],
            filteredLots: [],
            slide: null,
            sliding: true,
            dataModal: {
                lot_id: '',
                title: '',
                description: '',
                auction_price: null,
                start_price: 0,
                sailor: ''
            },
            newAuctionPrice: 0
        };
    },
    methods: {
        async getCategoriesList() {
            await this.$store.dispatch('categories/categoriesList');
            this.categories = await this.$store.getters['categories/categoriesList'];
        },
        async getCategoriesLots() {
            if (this.filterCategories.length > 0) {
                await this.$store.dispatch('categories/categoriesLots', {categories: this.filterCategories});
                this.filteredLots = await this.$store.getters['categories/categoriesLots'];
            } else {
                this.filteredLots = [];
                await this.getCategoriesList();
            }
        },
        onSlideStart(slide) {
            this.sliding = true
        },
        onSlideEnd(slide) {
            this.sliding = false
        },
        async deleteCatFromFilter(category) {
            this.filterCategories.splice(this.filterCategories.indexOf(category.id), 1);
            await this.getCategoriesLots();

        },
        showModal(lot) {
            this.dataModal.lot_id = lot.id;
            this.dataModal.title = lot.title;
            this.dataModal.description = lot.description;
            this.dataModal.auction_price = lot.auction_price;
            this.dataModal.start_price = lot.start_price;
            this.dataModal.sailor = lot.user.name;
            this.newAuctionPrice = this.modalInputValue;
            this.$refs['my-modal'].show()
        },
        hideModal() {
            this.dataModal.lot_id = '';
            this.dataModal.title = '';
            this.dataModal.description = '';
            this.dataModal.auction_price = null;
            this.dataModal.start_price = 0;
            this.dataModal.sailor = '';
            this.newAuctionPrice = 0;
            this.$refs['my-modal'].hide()
        },
        async sendNewPrice() {
            await this.$store.dispatch('lots/newAuctionPrice', {lot_id: this.dataModal.lot_id, new_auction_price: Number (this.newAuctionPrice).toFixed(2), user_id: this.user.id});
            let data = await this.$store.getters['lots/newAuctionPrice'];
            this.dataModal.lot_id = '';
            this.dataModal.title = '';
            this.dataModal.description = '';
            this.dataModal.auction_price = null;
            this.dataModal.start_price = 0;
            this.dataModal.sailor = '';
            this.newAuctionPrice = 0;
            this.$refs['my-modal'].hide();
            if (Object.keys(data).includes('data')) {
                await this.getCategoriesLots();
                alert(data.data);
            } else {
                alert('Something went wrong');
            }
        }
    },
    async mounted() {
        await this.getCategoriesList();
    },
    computed: {
        categoriesFiltered() {
            return this.filteredLots.length > 0 ? this.filteredLots : this.categories;
        },
        minModalPrice() {
            return this.dataModal.auction_price !== null ? Number (this.dataModal.auction_price).toFixed(2) : Number (this.dataModal.start_price).toFixed(2);
        },
        modalInputValue() {
            return this.dataModal.auction_price !== null ? Number (this.dataModal.auction_price).toFixed(2) : Number (this.dataModal.start_price).toFixed(2);
        },
        validNewPrice() {
            return Number (this.newAuctionPrice) > Number (this.modalInputValue);
        }
    }
}
</script>
