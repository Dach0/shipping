<template>
    <div class="container">
        <div class="row justify-content-center">
             <div class="col-12 mt-2 mb-3">
                    <div class="d-flex justify-content-between">
                        <h4>Spisak brodova</h4>  
                        <button class="btn btn-sm btn-primary mb-2"  @click="newShipModal">Dodaj brod</button>
                    </div>
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">Ime broda</th>
                                <th scope="col">Potrošnja</th>
                                <th scope="col">Broj posade</th>
                                <th scope="col">Maksimalna brzina</th>
                                <th scope="col">Izmijeni</th>
                                <th scope="col">Uništi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  v-for="ship in ships" :key="ship.id">
                                    <td>{{ ship.boat_name }}</td>
                                    <td>{{ ship.properties[1].property_amount }} l/km</td>
                                    <td>{{ ship.properties[2].property_amount }}</td>
                                    <td>{{ ship.properties[0].property_amount }} čvorova</td>
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
            
             <div class="col-12 mt-3">
                 <div class="d-flex justify-content-between">
                    <h4>Spisak destinacija</h4>  
                    <button class="btn btn-sm btn-primary mb-2"  @click="newModal">Dodaj destinaciju</button>
                 </div>
                   <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Destinacija</th>
                            <th scope="col">Udaljenost</th>
                            <th scope="col">Napravljena</th>
                            <th scope="col">Izmijenjena</th>
                            <th scope="col">Izmijeni</th>
                            <th scope="col">Uništi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="dist in destinations" :key="dist.id">
                                <td>{{ dist.destination_name }}</td>
                                <td>{{ dist.distance }}</td>
                                <td>{{ dist.created_at }}</td>
                                <td>{{ dist.updated_at }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" @click="editDestinationModal(dist)">Izmijeni</button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger" @click="deleteDestination(dist.id)">Obriši</button>
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

<!-- AddPropertyConsumption MODAL -->
<div class="modal hide fade" id="addPropertyConsumptionModal" tabindex="-1" role="dialog" aria-labelledby="addPropertyConsumptionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dodaj novu potro[nju</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form @submit.prevent="storePropertyConsumption()">
            <div class="modal-body">

                <div class="form-group">
                    <input v-model="newPropertyConsumption" type="text" name="newPropertyConsumption" placeholder="Potrošnja l/km"
                        class="form-control">
                </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
        <button v-show="!editmode" type="submit" class="btn btn-primary">Sačuvaj</button>
      </div>

      </form>
    </div>
  </div>
</div>
<!-- /AddPropertyConsumption MODAL -->

<!-- AddPropertyCrewNumber MODAL -->
<div class="modal hide fade" id="addPropertyCrewNumberModal" tabindex="-1" role="dialog" aria-labelledby="addPropertyCrewNumberModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dodaj novi broj posade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form @submit.prevent="storePropertyCrewNumber()">
            <div class="modal-body">

                <div class="form-group">
                    <input v-model="newPropertyCrewNumber" type="text" placeholder="Unesite broj posade"
                        class="form-control">
                </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
        <button v-show="!editmode" type="submit" class="btn btn-primary">Sačuvaj</button>
      </div>

      </form>
    </div>
  </div>
</div>
<!-- /AddPropertyCrewNumber MODAL -->

<!-- AddPropertyMaxSpeed MODAL -->
<div class="modal hide fade" id="addPropertyMaxSpeedModal" tabindex="-1" role="dialog" aria-labelledby="addPropertyMaxSpeedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dodaj novu maksimalnu brzinu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form @submit.prevent="storePropertyMaxSpeed()">
            <div class="modal-body">

                <div class="form-group">
                    <input v-model="newPropertyMaxSpeed" type="text" placeholder="Unesite max brzinu u čvorovima"
                        class="form-control">
                </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
        <button v-show="!editmode" type="submit" class="btn btn-primary">Sačuvaj</button>
      </div>

      </form>
    </div>
  </div>
</div>
<!-- /AddPropertyMaxSpeed MODAL -->

    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode : false,
                editShipmode: false,
                ships: [],
                destinations: [],
                properties: [],
                newPropertyConsumption: '',
                newPropertyCrewNumber: '',
                newPropertyMaxSpeed: '',
                form: new Form({
                    id: '',
                    destination_name : '',
                    distance : ''
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
            propertyConsumption: function () {
                let properties = this.properties.filter(property => property.property_name == 'consumption');
                return _.orderBy(properties, properties.property_amount)
            },
            propertyMaxSpeed: function () {
                return this.properties.filter(property => property.property_name == 'max_speed')
            },
            propertyCrewNumber: function () {
                return this.properties.filter(property => property.property_name == 'crew_number')
            }
        },
        methods:{
            loadShips(){
                axios.get('api/ship').then( ({data}) => (this.ships = data) );
            },
            loadDestinatios(){
                axios.get('api/destination').then( ({data}) => (this.destinations = data) );
            },
            loadProperties(){
                axios.get('api/property').then(({data}) => (this.properties = data));
            },
            editDestinationModal(dist){
                this.editmode = true;
                $('#addDestinationModal').modal('show');
                this.form.fill(dist);
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
            deleteDestination(id){
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
                            this.form.delete('api/destination/'+id)
                            .then(()=> {
                                Swal.fire(
                                'Obrisano!',
                                'Destinacija je obrisana',
                                'success'
                                )
                            Event.$emit('dbChanged');
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
            updateDestination(){
                this.form.put("api/destination/"+this.form.id)
                .then(() => {
                    Event.$emit('dbChanged');
                    
                    $('#addDestinationModal').modal('hide');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Podaci o destinaciji izmijenjeni',
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
                    
                    $('#addDestinationModal').modal('hide');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Podaci o destinaciji izmijenjeni',
                        showConfirmButton: false,
                        timer: 2000
                        })
                 })
                .catch(() => {
                     Swal.fire("Neuspješno!", "Nešto je pošlo do đavola", "warning");
                });
            },
            createDestination(){
                this.form.post('api/destination')
                .then(() => { 
                    Event.$emit('dbChanged');
                    
                    $('#addDestinationModal').modal('hide');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Destinacija sačuvana u bazi podataka',
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
            newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addDestinationModal').modal('show');
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
            this.loadDestinatios();
            this.loadShips();
            this.loadProperties();

            Event.$on('dbChanged', () => {
                this.loadDestinatios()
            });

            Event.$on('dbShipChanged', () => {
                this.loadShips()
            });

            Event.$on('dbPropertyChanged', () => {
                this.loadProperties()
            });
        }
    }
</script>

