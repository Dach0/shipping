<template>
    <div class="container">
        <div class="row justify-content-center">
             <div class="col-12">
                    <h4>Spisak brodova</h4>  
                   <b-table striped hover :items="ships"></b-table>
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


      <!-- MODAL -->
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
                    destination_name : '',
                    distance : ''
                })
            }
        },
        methods:{
            loadDestinatios(){
                axios.get('api/destination').then( ({data}) => (this.destinations = data) );
            },
            editDestination(){

            },
            deleteDestination(){

            },
            updateDestination(){

            },
            createDestination(){
                this.form.post('api/destination')
                .then(() => { console.log('Uspjesno upisan u bazu') })
                .catch(() => {

                })

            },
            newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addDestinationModal').modal('show');
            },
        },
        mounted() {
            this.loadDestinatios();
            console.log('Component mounted.')
        }
    }
</script>

