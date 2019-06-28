<template>
    <div class="container">
        <div class="row justify-content-center">
             <div class="col-12">
                <div class="col-2"> 
                    <div class="d-flex justify-content-between">
                        <h4>Spisak brodova</h4>  
                        <button class="btn btn-sm btn-primary mb-2"  @click="newShipModal">Dodaj brod</button>
                    </div>
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">Ime broda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="ship in ships" :key="ship.id">
                                    <td>{{ ship.boat_name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" @click="editShipModal(ship)">Izmijeni</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" @click="deleteShip(ship.id)">Obriši</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>   
             </div>

             <div class="col-12">
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

        
<!--        
        <div class="form-group">
            <select v-model="form.role" type="text" name="role"
                class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                <option value="">Izaberi ulogu</option>
                <option value="admin">Administrator</option>
                <option value="user">Standardni korisnik</option>
                <option value="autor">Autor</option>
            </select>
            <has-error :form="form" field="password"></has-error>
            <has-error :form="form" field="role"></has-error>
        </div> -->

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
<div class="modal fade" id="addShipModal" tabindex="-1" role="dialog" aria-labelledby="addDestinationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="editmode" class="modal-title">Promijeni ime broda</h5>
        <h5 v-show="!editmode" class="modal-title">Novi brod</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form @submit.prevent="editmode ? updateShip() : createShip()">
            <div class="modal-body">

                <div class="form-group">
                    <input v-model="form.boat_name" type="text" name="boat_name" placeholder="Naziv broda"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('boat_name') }">
                    <has-error :form="form" field="boat_name"></has-error>
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
<!-- /SHIP MODAL -->

    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode : false,
                ships: [],
                destinations: [],
                form: new Form({
                    id: '',
                    destination_name : '',
                    distance : ''
                })
            }
        },
        methods:{
            loadShips(){
                axios.get('api/ship').then( ({data}) => (this.ships = data) );
            },
            loadDestinatios(){
                axios.get('api/destination').then( ({data}) => (this.destinations = data) );
            },
            editDestinationModal(dist){
                this.editmode = true;
                $('#addDestinationModal').modal('show');
                this.form.fill(dist);

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
            newModal(){
              this.editmode = false;
              this.formShip.reset();
              $('#addDestinationModal').modal('show');
            },
            newShipModal(){
            },
        },
        mounted() {
            this.loadDestinatios();
            this.loadShips();

            Event.$on('dbChanged', () => {
                this.loadDestinatios()
            });
        }
    }
</script>

