<template>
    <div class="container">
            <div class="row">
                <p>
                    <a class="btn" data-toggle="collapse" href="#collapseTableOne" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Crea Tavolo
                    </a>
                    <a class="btn" data-toggle="collapse" href="#collapseTableTwo" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Gestisci Tavoli
                    </a>
                </p>
            </div>
            <div class="row">
                <div class="collapse" id="collapseTableOne">
                    <div class="card card-body">
                        <form @submit="tableSubmit">
                            <strong>Numero del tavolo:</strong>
                            <input type="text" class="form-control" v-model="numero">
                            <strong>Posti a sedere:</strong>
                            <input type="number" class="form-control" v-model="numero_posti"></input>
                            <strong>Note:</strong>
                            <textarea placeholder="Lato mare, adatto ai disabili, ecc." class="form-control" v-model="note"></textarea>
                            <button class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="collapse" id="collapseTableTwo">
                    <div v-bind:item="tables" v-for="(table, index) in tables" v-bind:index="index" v-bind:key="table.id">
                        <div class="d-block">Tavolo numero <span contenteditable="true"  v-on:keydown.enter="updateTableNumber($event, table.id)" v-on:blur="updateTableNumber($event, table.id)"> {{table.number}}</span></div>
                        <div>Posti a sedere <span contenteditable="true"  v-on:keydown.enter="updateTableSeats($event, table.id)" v-on:blur="updateTableSeats($event, table.id)">{{table.seats}}</span></div>
                        <div>Note sul tavolo <span contenteditable="true"  v-on:keydown.enter="updateTableNotes($event, table.id)" v-on:blur="updateTableNotes($event, table.id)">{{table.notes}}</span></div>
                        <div class="d-inline-block">
                            <button type="button" class="btn btn-primary" v-on:click="deleteTable(table.id)">
                                x
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <products-component></products-component>
        </div>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import VueAxios from 'vue-axios'
    import ProductsComponent from "./ProductsComponent";

    export default {
        created() {
            this.getTables();
        },
        data: function() {
            return{
            tables: [],
            numero: '',
            numero_posti: '',
            note: ''
            }
        },
        methods: {
            tableSubmit(e) {
                e.preventDefault();
                var vm = this;
                axios.post('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/createTable', {
                    number: vm.numero,
                    seats: vm.numero_posti,
                    notes: vm.note
                })
                    .then(function (response) {
                        this.getTables();
                    })
                    .catch(function (error) {
                        vm.output = error;
                    });
            },
            getTables(){
                    axios.get('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/getTables').then(response => {
                        this.tables = response.data
                        console.log(this.tables);
                    })
            },
            updateTableNumber(e, id){
                e.preventDefault();
                e.target.blur();
                axios.put('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/updateTable/'+ id, {
                    number:   e.target.innerText

            })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            updateTableSeats(e, id){
                e.preventDefault();
                e.target.blur();
                axios.put('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/updateTable/'+ id, {
                    seats: e.target.innerText
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            updateTableNotes(e, id){
                e.preventDefault();
                e.target.blur();
                axios.put('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/updateTable/'+ id, {
                    notes: e.target.innerText
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            deleteTable(id){
                let vm = this;
                axios.post('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/deleteTable/'+ id)
                    .then(function (response) {
                        console.log(response);
                        axios.get('http://localhost/phpStormProjects/restaurantAppBackEnd/public/index.php/getTables').then(response => {
                            console.log(response.data);
                            vm.tables = response.data;
                        });
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

        }
    }
</script>
