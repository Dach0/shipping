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
                                    <td>{{ ship.expences[0].expence_amount }} €</td>
                                    <td>{{ ship.expences[1].expence_amount }} €/litru</td>
                                    <td>{{ ship.expences[2].expence_amount }} €/obroku</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" @click="editShipModal(ship)">Izmijeni</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
             </div>
            
             <div class="col-12 mt-3">
                 <div class="d-flex">
                    <h4 class=" mr-auto">Spisak troškova</h4>  
                    <button class="btn btn-sm btn-primary mb-2 mr-1"  @click="addExpenceModal">Dodaj trošak</button>
                 </div>
                   <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Opis troška</th>
                            <th scope="col">Vrijednost</th>
                            <th scope="col">Izmijeni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="expence in expences" :key="expence.id">
                                <td>{{ expence.expence_name }}</td>
                                <td>{{ expence.expence_amount }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" @click="editExpenceModal(expence)">Izmijeni</button>
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
                        class="form-control" :class="{ 'is-invalid': shipForm.errors.has('boat_name') }">
                    <has-error :form="shipForm" field="boat_name"></has-error>
                </div>

                                   
                    <div class="form-group">
                        <label for="paycheck">Prosječna plata</label>
                        <select v-model="shipForm.avg_paycheck_id" type="text" name="paycheck"
                            class="form-control" :class="{ 'is-invalid': shipForm.errors.has('avg_paycheck_id') }">
                            <option value="">Izaberi troškove prosječne plate</option>
                            <option v-for="paycheck in expenceAvgPaycheck" v-bind:key="paycheck.id" :value="paycheck.id">{{paycheck.expence_amount}}</option>
                        </select>
                        <has-error :form="shipForm" field="avg_paycheck_id"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="fuel_id">Prosječna cijena goriva</label>
                        <select v-model="shipForm.fuel_price_id" type="text" name="fuel_id"
                            class="form-control" :class="{ 'is-invalid': shipForm.errors.has('fuel_price_id') }">
                            <option value="">Izaberi troškove goriva</option>
                            <option v-for="fuel in expenceFuelPrice" :key="fuel.id" :value="fuel.id">{{fuel.expence_amount}}</option>
                        </select>
                        <has-error :form="shipForm" field="fuel_price_id"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="paycheck">Prosječna cijena obroka po članu posade</label>
                        <select v-model="shipForm.food_price_id" type="text" name="food_price"
                            class="form-control" :class="{ 'is-invalid': shipForm.errors.has('food_price_id') }">
                            <option value="">Izaberi troškove obroka</option>
                            <option v-for="food in expenceFoodPrice" :key="food.id" :value="food.id">{{ food.expence_amount }}</option>
                        </select>
                        <has-error :form="shipForm" field="food_price_id"></has-error>
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

<!-- AddEditExpence MODAL -->
<div class="modal hide fade" id="addEditExpenceModal" tabindex="-1" role="dialog" aria-labelledby="addPropertyConsumptionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="!editExpencemode" class="modal-title">Dodaj novu potrošnju</h5>
        <h5 v-show="editExpencemode" class="modal-title">Ažuriraj potrošnju</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form @submit.prevent="editExpencemode ? updateExpence() : createExpence()">
            <div class="modal-body">

                 <div v-show="!editExpencemode" class="form-group">
                        <select v-model="form.expence_name" type="text" name="expence_name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('expence_name') }">
                            <option value="">Izaberi vrstu troška</option>
                            <option value="avg_paycheck">Prosječna plata</option>
                            <option value="fuel_price">Cijena goriva</option>
                            <option value="food_price">Cijena obroka</option>
                        </select>
                        <has-error :form="form" field="expence_name"></has-error>
                    </div>

                <div class="form-group">
                    <input v-model="form.expence_amount" type="text" name="expence_amount" :class="{ 'is-invalid': form.errors.has('expence_amount') }" placeholder="Količina"
                        class="form-control">
                        <has-error :form="form" field="expence_amount"></has-error>
                </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
        <button v-show="!editExpencemode" type="submit" class="btn btn-primary">Sačuvaj</button>
        <button v-show="editExpencemode" type="submit" class="btn btn-primary">Ažuriraj</button>
      </div>

      </form>
    </div>
  </div>
</div>
<!-- /AddEditExpence MODAL -->


    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode : false,
                editExpencemode: false,
                ships: [],
                expences: [],
                avg_paycheck: '',
                fuel_price: '',
                food_price: '',
                form: new Form({
                    id: '',
                    expence_name : '',
                    expence_amount : ''
                }),
                shipForm: new Form({
                    id:'',
                    boat_name:'',
                    avg_paycheck_id: '',
                    fuel_price_id: '',
                    food_price_id: '',
                })
            }
        },
        computed: {
            // a computed getter
            expenceAvgPaycheck: function () {
               return this.expences.filter(expence => expence.expence_name == 'avg_paycheck');
            },
            expenceFuelPrice: function () {
                return this.expences.filter(expence => expence.expence_name == 'fuel_price')
            },
            expenceFoodPrice: function () {
                return this.expences.filter(expence => expence.expence_name == 'food_price')
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
            loadExpences(){
                axios.get('api/expence', {
                    headers: {
                        Authorization: 'Bearer ' + this.$gate.token()
                    }
                }).then(({data}) => (this.expences = data));
            },
            editExpenceModal(exp){
                this.editExpencemode = true;
                $('#addEditExpenceModal').modal('show');
                this.form.fill(exp);
            },
            editShipModal(ship){
                $('#editShipModal').modal('show');
                    this.shipForm.id = ship.id;
                    this.shipForm.boat_name = ship.boat_name;
                    this.shipForm.avg_paycheck_id =  ship.expences[0].id;
                    this.shipForm.fuel_price_id = ship.expences[1].id;
                    this.shipForm.food_price_id = ship.expences[2].id;
                // this.shipForm.fill(ship);
            },
            updateExpence(){
                this.form.put("api/expence/"+this.form.id,  {
                    headers: {
                        Authorization: 'Bearer ' + this.$gate.token()
                    }
                })
                .then(() => {
                    Event.$emit('dbExpenceChanged');
                    
                    $('#addEditExpenceModal').modal('hide');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Podaci o trošku izmijenjeni',
                        showConfirmButton: false,
                        timer: 2000
                        })
                 })
                .catch(() => {
                     Swal.fire("Neuspješno!", "Nešto je pošlo do đavola", "warning");
                });
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
            },
            createExpence(){
                this.form.post('api/expence',  {
                    headers: {
                        Authorization: 'Bearer ' + this.$gate.token()
                    }
                })
                .then(() => { 
                    Event.$emit('dbExpenceChanged');
                    
                    $('#addEditExpenceModal').modal('hide');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Trošak sačuvan u bazi podataka',
                        showConfirmButton: false,
                        timer: 1500
                        })
                })
                .catch(() => {
                     Swal.fire("Neuspješno!", "Nešto je pošlo do đavola", "warning");
                })

            },
            createShip(){
                this.shipForm.post('api/ship',  {
                    headers: {
                        Authorization: 'Bearer ' + this.$gate.token()
                    }
                })
                .then(() => { 
                    Event.$emit('dbShipChanged');
                    
                    $('#addShipModal').modal('hide');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Brod sačuvan u bazi podataka',
                        showConfirmButton: false,
                        timer: 1500
                        })
                })
                .catch(() => {
                     Swal.fire("Neuspješno!", "Nešto je pošlo do đavola", "warning");
                })

            },
            addExpenceModal(){
              this.editExpencemode = false;
              this.form.reset();
              $('#addEditExpenceModal').modal('show');
            },
            newPropertyConsumptionModal(){
                // console.log('Hitting it');
                $('#addPropertyConsumptionModal').modal('show');
            },
            newPropertyMaxSpeedModal(){
                $('#addPropertyMaxSpeedModal').modal('show');
            },
            newPropertyCrewNumberModal(){
                $('#addPropertyCrewNumberModal').modal('show');
            }
        },
        mounted() {
            this.loadExpencesShips();
            this.loadExpences();

            Event.$on('dbExpenceChanged', () => {
                this.loadExpences();
                this.loadExpencesShips();
            });

            Event.$on('dbShipChanged', () => {
                this.loadExpencesShips()
            });

        }
    }
</script>

