<template>
    <div class="container">
        <div class="row justify-content-center">
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
                                <th scope="col">Cijena</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  v-for="order in orders" :key="order.id">
                                    <td>{{  }}</td>
                                    <td>{{  }} €</td>
                                    <td>{{  }} €/litru</td>
                                    <td>{{  }} €/obroku</td>
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
            return{
                orders: []
            }
        },
        methods: {
            loadOrders(){
                axios.get('api/order').then( ({data}) => (this.orders = data));
            },
            newOrderModal(){
                this.orderForm.reset();
                $('#newOrderModal').modal('show');
            },
        },
        created(){
            this.loadOrders();
        }
    }
</script>
