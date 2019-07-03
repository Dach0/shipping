<template>
    <div class="container">
        <div class="row justify-content-center">
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
                                        <button class="btn btn-sm btn-success" @click="editShipModal(ship.id)">Izmijeni</button>
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


      <!-- DESTINATION MODAL -->
<div class="modal fade" id="addDestinationModal" tabindex="-1" role="dialog" aria-labelledby="addDestinationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="editmode" class="modal-title" id="addUserModalLabel">Ažuriraj podatke o destinaciji</h5>
        <h5 v-show="!editmode" class="modal-title" id="addUserModalLabel">Nova destinacija</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form @submit.prevent="editmode ? updateDestination() : createDestination()">
            <div class="modal-body">

                <div class="form-group">
                    <input v-model="form.destination_name" type="text" name="destination_name" placeholder="Naziv destinacije"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('destination_name') }">
                    <has-error :form="form" field="destination_name"></has-error>
                </div>

        <div class="form-group">
            <input v-model="form.distance" type="text" name="distance" placeholder="Udaljenost"
                class="form-control" :class="{ 'is-invalid': form.errors.has('distance') }">
            <has-error :form="form" field="distance"></has-error>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
        <button v-show="editmode" type="submit" class="btn btn-success">Ažuriraj</button>
        <button v-show="!editmode" type="submit" class="btn btn-primary">Sačuvaj</button>
      </div>

      </form>
    </div>
  </div>
</div>
<!-- /MODAL -->


      <!-- SHIP MODAL -->
<div class="modal hide fade" id="addShipModal" tabindex="-1" role="dialog" aria-labelledby="addDestinationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="editShipmode" class="modal-title">Promijeni ime broda</h5>
        <h5 v-show="!editShipmode" class="modal-title">Novi brod</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form @submit.prevent="editShipmode ? updateShip() : createShip()">
            <div class="modal-body">

                <div class="form-group">
                    <input v-model="shipForm.boat_name" type="text" name="boat_name" placeholder="Naziv broda"
                        class="form-control" :class="{ 'is-invalid': shipForm.errors.has('boat_name') }">
                    <has-error :form="shipForm" field="boat_name"></has-error>
                </div>

                                   
                    <div class="form-group input-group">
                        <select v-model="shipForm.selected_consumption" type="text" name="consumption"
                            class="form-control" :class="{ 'is-invalid': shipForm.errors.has('selected_consumption') }">
                            <option :value="null">Izaberi potrošnju</option>
                            <option v-for="consumption in propertyConsumption" v-bind:key="consumption.id" :value="consumption.id">{{consumption.property_amount}}</option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-info" type="button" @click="newPropertyConsumptionModal">Dodaj potrošnju</button>
                        </div>
                        <has-error :form="shipForm" field="selected_consumption"></has-error>
                    </div>
                    <div class="form-group input-group">
                        <select v-model="shipForm.selected_crew_number" type="text" name="crew_number"
                            class="form-control" :class="{ 'is-invalid': shipForm.errors.has('selected_crew_number') }">
                            <option value="null">Izaberi broj članova posade</option>
                            <option v-for="crew_number in propertyCrewNumber" :key="crew_number.id" :value="crew_number.id">{{crew_number.property_amount}}</option>
                        </select>
                         <div class="input-group-append">
                            <button class="btn btn-info" type="button" @click="newPropertyCrewNumberModal">Dodaj posadu</button>
                        </div>
                        <has-error :form="shipForm" field="selected_crew_number"></has-error>
                    </div>
                    <div class="form-group input-group">
                        <select v-model="shipForm.selected_max_speed" type="text" name="max_speed"
                            class="form-control" :class="{ 'is-invalid': shipForm.errors.has('selected_max_speed') }">
                            <option value="null">Izaberi maksimalnu brzinu</option>
                            <option v-for="max_speed in propertyMaxSpeed" :key="max_speed.id" :value="max_speed.id">{{ max_speed.property_amount }}</option>
                        </select>
                         <div class="input-group-append">
                            <button class="btn btn-info" type="button" @click="newPropertyMaxSpeedModal">Dodaj brzinu</button>
                        </div>
                        <has-error :form="shipForm" field="selected_max_speed"></has-error>
                    </div>

             </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
            <button v-show="editShipmode" type="submit" class="btn btn-success">Ažuriraj</button>
            <button v-show="!editShipmode" type="submit" class="btn btn-primary">Sačuvaj</button>
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
                destinations: [],
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
                    property_id:'',
                    selected_consumption: null,
                    selected_crew_number: null,
                    selected_max_speed: null,
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
            loadShips(){
                axios.get('api/ship/expences/all').then( ({data}) => (this.ships = data) );
            },
            loadExpences(){
                axios.get('api/expence').then(({data}) => (this.expences = data.data));
            },
            editExpenceModal(exp){
                this.editExpencemode = true;
                $('#addEditExpenceModal').modal('show');
                this.form.fill(exp);
            },
            editShipModal($id){
                this.editShipmode = true;
                $('#addShipModal').modal('show');
                axios.get('api/ship/'+$id)
                    .then(({data}) => (
                        this.shipForm.id = data.boat_id,
                        this.shipForm.boat_name = data.boat_name,
                        this.shipForm.selected_consumption = data.consumption_id,
                        this.shipForm.selected_crew_number = data.crew_number_id,
                        this.shipForm.selected_max_speed = data.max_speed_id ));
                // this.shipForm.fill(ship);
            },
            deleteExpence(id){
                Swal.fire({
                    title: 'Jeste li sigurni?',
                    text: "Nećete moći da opozovete akciju!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Da, obriši!'
                        }).then((result) => {

                        if (result.value) {
                            this.form.delete('api/expence/'+id)
                            .then(()=> {
                                Swal.fire(
                                'Obrisano!',
                                'Destinacija je obrisana',
                                'success'
                                )
                            Event.$emit('dbExpenceChanged');
                            })
                            .catch( () => {
                                Swal.fire("Neuspješno!", "Nešto je pošlo do đavola", "warning");
                            });
                        }
                })
            },
            deleteShip(id){
                Swal.fire({
                    title: 'Jeste li sigurni?',
                    text: "Nećete moći da opozovete akciju!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Da, obriši!'
                        }).then((result) => {

                        if (result.value) {
                            this.shipForm.delete('api/ship/'+id)
                            .then(()=> {
                                Swal.fire(
                                'Obrisano!',
                                'Brod je obrisan',
                                'success'
                                )
                            Event.$emit('dbShipChanged');
                            })
                            .catch( () => {
                                Swal.fire("Neuspješno!", "Nešto je pošlo do đavola", "warning");
                            });
                        }
                })
            },
            updateExpence(){
                this.form.put("api/expence/"+this.form.id)
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
            updateShip(){
                this.shipForm.put("api/ship/"+this.shipForm.id)
                .then(() => {
                    Event.$emit('dbShipChanged');
                    
                    $('#addShipModal').modal('hide');

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
                this.form.post('api/expence')
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
                this.shipForm.post('api/ship')
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
            newShipModal(){
                this.editShipmode = false;
                this.shipForm.reset();
                $('#addShipModal').modal('show');
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
            },
            storePropertyConsumption(){
                axios.post('api/property', {
                    "property_name" : 'consumption',
                    "property_amount" : this.newPropertyConsumption
                })
                 .then(() => { 
                    Event.$emit('dbPropertyChanged');
                    
                    $('#addPropertyConsumptionModal').modal('hide');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Nova potrošnja unešena u bazu',
                        showConfirmButton: false,
                        timer: 1500
                        })
                })
                .catch(() => {
                     Swal.fire("Neuspješno!", "Nešto je pošlo do đavola", "warning");
                })
            },
            storePropertyCrewNumber(){
                axios.post('api/property', {
                    "property_name" : 'crew_number',
                    "property_amount" : this.newPropertyCrewNumber
                })
                 .then(() => { 
                    Event.$emit('dbPropertyChanged');
                    
                    $('#addPropertyCrewNumberModal').modal('hide');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Novi broj posade unešen u bazu',
                        showConfirmButton: false,
                        timer: 1500
                        })
                })
                .catch(() => {
                     Swal.fire("Neuspješno!", "Nešto je pošlo do đavola", "warning");
                })
            },
            storePropertyMaxSpeed(){
                axios.post('api/property', {
                    "property_name" : 'max_speed',
                    "property_amount" : this.newPropertyMaxSpeed
                })
                 .then(() => { 
                    Event.$emit('dbPropertyChanged');
                    
                    $('#addPropertyMaxSpeedModal').modal('hide');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Nova brzina unešena u bazu',
                        showConfirmButton: false,
                        timer: 1500
                        })
                })
                .catch(() => {
                     Swal.fire("Neuspješno!", "Nešto je pošlo do đavola", "warning");
                })
            }
        },
        mounted() {
            this.loadShips();
            this.loadExpences();

            Event.$on('dbExpenceChanged', () => {
                this.loadExpences();
                this.loadShips();
            });

            Event.$on('dbShipChanged', () => {
                this.loadShips()
            });

        }
    }
</script>

