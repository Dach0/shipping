<template>
    <div class="container">
        <div class="row justify-content-center" v-if="$gate.isAdminOrSales()">
             <div class="col-12 mt-2 mb-3">
                    <div class="d-flex justify-content-between">
                        <h4>Spisak troškova po brodu</h4>  
                    </div>
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">Ime broda</th>
                                <th scope="col">Prosječna plata</th>
                                <th scope="col">Cijena goriva</th>
                                <th scope="col">Cijena obroka</th>
                                <th scope="col">Izmijeni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  v-for="ship in ships" :key="ship.id">
                                    <td>{{ ship.boat_name }}</td>
                                    <td>{{ ship.ship_has_expences[0].expence_amount }} €</td>
                                    <td>{{ ship.ship_has_expences[1].expence_amount }} €/litru</td>
                                    <td>{{ ship.ship_has_expences[2].expence_amount }} €/obroku</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" @click="editShipModal(ship)">Izmijeni</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
             </div>
        </div>


<div v-if="!$gate.isAdminOrSales()">
    <forbiden-notfound-component></forbiden-notfound-component>
</div>


      <!-- SHIP MODAL -->
<div class="modal hide fade" id="editShipModal" tabindex="-1" role="dialog" aria-labelledby="editShipModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Promijeni podatke o troškovima broda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form @submit.prevent="updateShipExpences()">
            <div class="modal-body">

                <div class="form-group">
                    <input v-model="shipForm.boat_name" type="text" name="boat_name" placeholder="Naziv broda"
                        class="form-control" :class="{ 'is-invalid': shipForm.errors.has('boat_name') }" disabled>
                    <has-error :form="shipForm" field="boat_name"></has-error>
                </div>
               
                <div class="form-group">
                    <label for="paycheck">Prosječna plata (€)</label>
                    <input v-model="shipForm.avg_paycheck" type="text" name="avg_paycheck" placeholder="€"
                        class="form-control" :class="{ 'is-invalid': shipForm.errors.has('avg_paycheck') }">
                    <has-error :form="shipForm" field="avg_paycheck"></has-error>
                </div>
                                   
                <div class="form-group">
                    <label for="fuelprice">Cijena goriva (€/litru)</label>
                    <input v-model="shipForm.fuel_price" type="text" name="fuel_price" placeholder="€/litru"
                        class="form-control" :class="{ 'is-invalid': shipForm.errors.has('fuel_price') }">
                    <has-error :form="shipForm" field="fuel_price"></has-error>
                </div>
                                   
                <div class="form-group">
                    <label for="foodprice">Cijena hrana (€/obroku)</label>
                    <input v-model="shipForm.food_price" type="text" name="food_price" placeholder="€/obroku"
                        class="form-control" :class="{ 'is-invalid': shipForm.errors.has('food_price') }">
                    <has-error :form="shipForm" field="food_price"></has-error>
                </div>
                                
             </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
            <button type="submit" class="btn btn-success">Ažuriraj</button>
        </div>

      </form>
    </div>
  </div>
</div>
<!-- /SHIP MODAL -->

    </div>
</template>

<script>
    export default {
        data() {
            return {
                ships: [],
                shipForm: new Form({
                    id:'',
                    boat_name:'',
                    avg_paycheck: '',
                    fuel_price: '',
                    food_price: '',
                })
            }
        },
        methods:{
            loadExpencesShips(){
                axios.get('api/ship/expences/all', {
                    headers: {
                        Authorization: 'Bearer ' + this.$gate.token()
                    }
                }).then( ({data}) => (this.ships = data) );
            },
            editShipModal(ship){
                $('#editShipModal').modal('show');
                    this.shipForm.id = ship.id;
                    this.shipForm.boat_name = ship.boat_name;
                    this.shipForm.avg_paycheck =  ship.ship_has_expences[0].expence_amount;
                    this.shipForm.fuel_price = ship.ship_has_expences[1].expence_amount;
                    this.shipForm.food_price = ship.ship_has_expences[2].expence_amount;
                // this.shipForm.fill(ship);
            },
            updateShipExpences(){
                this.shipForm.put("api/ship/expences/update/"+this.shipForm.id,  {
                    headers: {
                        Authorization: 'Bearer ' + this.$gate.token()
                    }
                })
                .then(() => {
                    Event.$emit('dbShipChanged');
                    
                    $('#editShipModal').modal('hide');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Podaci o brodu izmijenjeni',
                        showConfirmButton: false,
                        timer: 2000
                        })
                 })
                .catch(() => {
                     Swal.fire("Neuspješno!", "Nešto je pošlo do đavola", "warning");
                });
            }
        },
        mounted() {
            this.loadExpencesShips();

            Event.$on('dbShipChanged', () => {
                this.loadExpencesShips()
            });

        }
    }
</script>

