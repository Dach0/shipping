<template>
    <div class="container">
        <div class="row justify-content-center">

             <div class="col-12 mt-2 mb-3">
                    <div class="d-flex justify-content-between">
                        <h4>Spisak troškova</h4>  
                        <button class="btn btn-sm btn-primary mb-2"  @click="addExpencesModal">Dodaj troškove</button>
                    </div>
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">Ime broda</th>
                                <th scope="col">Troškovi plata</th>
                                <th scope="col">Cijena goriva</th>
                                <th scope="col">Cijena obroka</th>
                                <th scope="col">Izmijeni</th>
                                <th scope="col">Uništi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  v-for="ship in ships" :key="ship.id">
                                    <td>{{ ship.boat_name }}</td>
                                    <td>{{ ship.properties[1].expence_amount }} l/km</td>
                                    <td>{{ ship.properties[2].expence_amount }}</td>
                                    <td>{{ ship.properties[0].expence_amount }} čvorova</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" @click="editShipModal(ship.id)">Izmijeni</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" @click="deleteShip(ship.id)">Obriši</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
             </div>

        
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                ships: [],
            }
        },
        methods:{
            loadShips(){
                axios.get('api/ship').then( ({data}) => (this.ships = data) );
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
