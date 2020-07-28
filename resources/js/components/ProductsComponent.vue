<template>
    <div>
        <div class="row">
            <p>
                <a class="btn" data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Crea Categoria
                </a>
                <a class="btn" data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Gestisci Categorie
                </a>
                <a class="btn" data-toggle="collapse" href="#collapseThree" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Crea Prodotto
                </a>
                <a class="btn" data-toggle="collapse" href="#collapseFour" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Gestisci Prodotti
                </a>
            </p>
        </div>
        <div class="row">
            <div class="collapse" id="collapseOne">
                <div class="card card-body">
                    <form @submit="categorySubmit">
                        <strong>Nome:</strong>
                        <input type="text" class="form-control" v-model="category_name">
                        <button class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseTwo">
                <div class="col" v-bind:item="categories" v-for="(category, index) in categories" v-bind:index="index" v-bind:key="category.id">
                    <div class="d-block"><span contenteditable="true"  v-on:keydown.enter="categoryUpdate($event, category.id)" v-on:blur="categoryUpdate($event, category.id)"> {{category.name}}</span></div>
                    <div class="d-inline-block">
                        <button type="button" class="btn btn-primary" v-on:click="deleteCategory(category.id)">
                            x
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseThree">
                <div class="card card-body">
                    <form @submit="productSubmit">
                        <strong>Nome prodotto:</strong>
                        <input type="text" class="form-control" v-model="product_name">
                        <strong>Prezzo:</strong>
                        <input type="text" placeholder="€" class="form-control" v-model="product_price">
                        <strong>Categoria prodotto:</strong>
                        <select  v-model="product_category_id" >
                            <option v-bind:item="categories"  v-for="(category, index) in categories" v-bind:index="index" v-bind:key="category.id" :value="category.id">{{category.name}}</option>
                        </select>
                        <strong>Note:</strong>
                        <textarea placeholder="Per celiaci, vegan, surgelato, ecc." class="form-control" v-model="product_notes"></textarea>
                        <button class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse" id="collapseFour">
                <div v-bind:item="categories"  v-for="(category, index) in categories" v-bind:index="index" v-bind:key="category.id">
                    <h2>{{category.name}}</h2>
                <div v-bind:item="products" v-for="(product, index) in products" v-bind:index="index" v-bind:key="product.id">
                    <template v-if="category.id === product.categoryID">
                    <div class="d-block" contenteditable="true"  v-on:keydown.enter="productUpdateName($event, product.id)" v-on:blur="productUpdateName($event, product.id)"> {{product.name}}</div>
                        <div class="d-inline-block" contenteditable="true"  v-on:keydown.enter="productUpdatePrice($event, product.id)" v-on:blur="productUpdatePrice($event, product.id)"> {{product.price}}</div><span>€</span>
                    <div class="d-block" contenteditable="true"  v-on:keydown.enter="productUpdateNotes($event, product.id)" v-on:blur="productUpdateNotes($event, product.id)"> {{product.notes}}</div>
                    <select  v-model="temp_category_id"  v-on:change="productUpdateCategory(product.id)" >
                        <option v-bind:item="categories" v-for="(category, index) in categories" v-bind:index="index" v-bind:key="category.id" :value="category.id">{{category.name}}</option>
                    </select>
                    <div class="d-inline-block">
                    <button type="button" class="btn btn-primary" v-on:click="deleteProduct(product.id)">
                        x
                    </button>
                    </div>
                    </template>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "ProductsComponent",
        data: function () {
           return{
               categories: [],
               products: [],
               category_name: '',
               product_name: '',
               product_price: '',
               product_category_id: '',
               product_notes: '',
               temp_category_id: ''
           }
        },
        created(){
            this.getCategories();
            this.getProducts();
        },
        methods: {
            categorySubmit(e){
                e.preventDefault();
                var vm = this;
                axios.post('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/createCategory', {
                    name: vm.category_name
                })
                    .then(function (response) {
                        console.log(response);
                        this.getCategories();
                    })
                    .catch(function (error) {
                        vm.output = error;
                    });
            },
            getCategories(){
                var vm = this;
                axios.get('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/getCategories').then(response => {
                    vm.categories = response.data;
                    console.log(this.categories);
                })
            },
            categoryUpdate(e, id){
                e.preventDefault();
                e.target.blur();
                axios.put('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/updateCategory/'+ id, {
                    name:   e.target.innerText
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            deleteCategory(e, id){
                let vm = this;
                axios.post('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/deleteCategory/'+ id)
                    .then(function (response) {
                        console.log(response);
                        vm.getCategories();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            productSubmit(e){
                e.preventDefault();
                var vm = this;
                axios.post('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/createProduct', {
                    name: vm.product_name,
                    price: vm.product_price,
                    categoryID: vm.product_category_id,
                    notes: vm.product_notes
                })
                    .then(function (response) {
                        this.getProducts();
                    })
                    .catch(function (error) {
                        vm.output = error;
                    });
            },
            getProducts(){
                axios.get('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/getProducts').then(response => {
                    this.products = response.data
                    console.log(this.products);
                })
            },
            productUpdateName(e,id){
                e.preventDefault();
                e.target.blur();
                axios.put('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/updateProduct/'+ id, {
                    name:   e.target.innerText
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            productUpdateCategory(id){
                var vm = this;
                axios.put('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/updateProduct/'+ id, {
                    categoryID:   vm.temp_category_id
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            productUpdatePrice(e,id){
                e.preventDefault();
                e.target.blur();
                axios.put('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/updateProduct/'+ id, {
                    price:   e.target.innerText
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            productUpdateNotes(e,id){
                e.preventDefault();
                e.target.blur();
                axios.put('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/updateProduct/'+ id, {
                    notes:   e.target.innerText
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            deleteProduct(id){
                axios.post('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/deleteProduct/'+ id)
                    .then(function () {
                        console.log(response);
                        this.getProducts();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
