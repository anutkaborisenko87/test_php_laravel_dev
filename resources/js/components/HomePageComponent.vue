<template>
    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-4 card">
                <div class="card-header">
                    <h1>Categories</h1>
                </div>
                <div class="card-body">
                    <div class="form-check" v-if="categories.length > 0" v-for="category of categories" :key="category.id">
                        <input v-model="filterCategories" class="form-check-input" type="checkbox" :id="category.title" :value="category.id" @change="getCategoriesLots">
                        <label class="form-check-label" :for="category.title">
                            {{ category.title }}
                            <span class="badge rounded-pill text-bg-light">
                                {{ category.lots.length > 0 ?  category.lots.length : 0 }}
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
              categories: [],
              filterCategories: [],
              filteredLots: []
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
                    console.log(this.filteredLots);
                }
            }
        },
        async mounted() {
            await this.getCategoriesList();
        },
        computed: {

        }
    }
</script>
