<template>
    <div class="container">
        <div class="row justify-content-center" v-if="$gate.isAdminOrSales()">
             <div class="col-12 mt-2 mb-3">
                    <div class="d-flex justify-content-between">
                        <h4>Spisak porudžbina</h4>  
                        <button class="btn btn-sm btn-primary mb-2"  @click="newOrderModal">Napravi porudžbinu</button>
                    </div>
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">Poručilac</th>
                                <th scope="col">Destinacija</th>
                                <th scope="col">Brod</th>
                                <th scope="col">Ukupna cijena</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  v-for="order in orders" :key="order.id">
                                    <td>{{ order.order_name }}</td>
                                    <td>{{ order.destination.destination_name }}</td>
                                    <td>{{ order.ship.boat_name }}</td>
                                    <td>{{ order.price }} €</td>
                                </tr>
                            </tbody>
                        </table>
             </div>
        </div>

<div v-if="!$gate.isAdminOrSales()">
    <forbiden-notfound-component></forbiden-notfound-component>
</div>

     <!-- ORDER MODAL -->
<div class="modal hide fade" id="newOrderModal" tabindex="-1" role="dialog" aria-labelledby="newOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Napravi porudžbinu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form @submit.prevent="storeOrder()">
            <div class="modal-body">

                <div class="form-group">
                    <input v-model="orderForm.order_name" type="text" name="order_name" placeholder="Naziv porudžbine (poručioca)"
                        class="form-control" :class="{ 'is-invalid': orderForm.errors.has('order_name') }">
                    <has-error :form="orderForm" field="order_name"></has-error>
                </div>

                                   
                    <div class="form-group">
                        <label for="destination">Destinacija</label>
                        <select v-model="orderForm.destination_id" type="text" name="destination"
                            class="form-control" :class="{ 'is-invalid': orderForm.errors.has('destination_id') }">
                            <option value="null">Izaberi destinaciju</option>
                            <option v-for="destination in destinations" v-bind:key="destination.id" :value="destination.id">{{destination.destination_name}}</option>
                        </select>
                        <has-error :form="orderForm" field="destination_id"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="ship_id">Brod</label>
                        <select v-model="orderForm.ship_id" type="text" name="ship_id"
                            class="form-control" :class="{ 'is-invalid': orderForm.errors.has('ship_id') }">
                            <option value="null">Izaberi brod za angažovanje</option>
                            <option v-for="ship in ships" :key="ship.id" :value="ship.id">{{ship.boat_name}}</option>
                        </select>
                        <has-error :form="orderForm" field="ship_id"></has-error>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <button class="btn btn-sm btn-primary" @click.prevent="calculatePrice(orderForm.destination_id, orderForm.ship_id)" >Izračunaj cijenu usluge</button>
                        <label :v-bind="orderForm.price" :class="{ 'is-invalid': orderForm.errors.has('price')}" >{{orderForm.price}} €</label> 
                    </div>
                        <div v-show="orderForm.errors.errors.price" field="price">
                            <p class="text-danger">{{ orderForm.errors.errors.price }}</p>
                        </div>
                        
                    

             </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
            <button type="submit" class="btn btn-success">Sačuvaj</button>
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
        data(){
            return{
                orders: [],
                destinations: [],
                ships: [],
                orderForm: new Form({
                    order_name: '',
                    destination_id: null,
                    ship_id: null,
                    price: ''
                })
            }
        },
        methods: {
            loadOrders(){
                axios.get('api/order', {
                    headers: {
                        Authorization: 'Bearer ' + this.$gate.token()
                    }
                }).then( ({data}) => (this.orders = data));
            },
             loadShips(){
                axios.get('api/ship', {
                    headers: {
                        Authorization: 'Bearer ' + this.$gate.token()
                    }
                }).then( ({data}) => (this.ships = data) );
            },
            loadDestinatios(){
                axios.get('api/destination', {
                    headers: {
                        Authorization: 'Bearer ' + this.$gate.token()
                    }
                }).then( ({data}) => (this.destinations = data) );
            },
            newOrderModal(){
                this.orderForm.reset();
                $('#newOrderModal').modal('show');
            },
            calculatePrice(destination_id, ship_id){
                axios.get('api/order/price?dest_id=' + destination_id + '&ship_id=' + ship_id, {
                    headers: {
                        Authorization: 'Bearer ' + this.$gate.token()
                    }
                })
                .then(({data}) => (this.orderForm.price = data.price));
                // console.log(destination_id + ' ' + ship_id);
            },
            storeOrder(){
                this.orderForm.post('api/order', {
                    headers: {
                        Authorization: 'Bearer ' + this.$gate.token()
                    }
                })
                .then(() => { 
                    Event.$emit('newOrderStored');
                    
                    $('#newOrderModal').modal('hide');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Porudžbina sačuvana u bazi podataka',
                        showConfirmButton: false,
                        timer: 1500
                        })
                })
                .catch(() => {
                     Swal.fire("Neuspješno!", "Nešto je pošlo do đavola", "warning");
                })

            }
        },
        created(){
            this.loadOrders();
            this.loadDestinatios();
            this.loadShips();

            Event.$on('newOrderStored', () => {
                this.loadOrders();
            });
        }
    }
</script>
