<template>
  <main>
    <header></header>
    <div class="o-container">
      <div class="c-checkout__cart">
        <div class="c-checkout__cart-item"
             v-for="ticket in tickets">
          <div class="c-checkout__cart-item-label">
            <span class="c-checkout__cart-item-title">{{ ticket.city }} - {{ ticket.place }}</span>
            <span class="c-checkout__cart-item-date">{{ ticket.date }}</span>
          </div>
          <div class="c-checkout__cart-item-information">
            <span class="c-checkout__cart-item-price">{{ ticket.price | currency }}€</span>
            <!--<counter :number="ticket.amount" :id="ticket.id" @onMinus="removeItem" @onPlus="addItem"></counter>-->
          </div>
        </div>
        <div class="c-checkout__cart-action">
          <span class="c-checkout__cart-total">Total : {{ total | currency }}€</span>
        </div>
      </div>
      <div class="c-checkout__form">
        <div class="c-checkout__input">
          <label for="firstName">Prénom</label>
          <input id="firstName" type="text" name="firstName" v-model="user.firstName">
        </div>
        <div class="c-checkout__input">
          <label for="lastName">Nom</label>
          <input id="lastName" type="text" name="lastName" v-model="user.lastName">
        </div>
        <div class="c-checkout__input">
          <label for="email">Adresse mail</label>
          <input id="email" type="text" name="email" v-model="user.email">
        </div>
        <div class="c-checkout__input">
          <label for="address">Adresse</label>
          <input id="address" type="text" name="address" v-model="user.address">
        </div>
        <div class="c-checkout__input">
          <label for="postcode">Code postal</label>
          <input id="postcode" type="text" name="postcode" v-model="user.postcode">
        </div>
        <div class="c-checkout__input">
          <label for="city">Ville</label>
          <input id="city" type="text" name="city" v-model="user.city">
        </div>
        <div class="c-checkout__input">
          <label for="phoneNumber">Numéro de téléphone</label>
          <input id="phoneNumber" type="text" name="phoneNumber" v-model="user.phoneNumber">
        </div>
        <button @click.prevent="checkout">Commander</button>
      </div>
      <div class="c-checkout__payment" v-if="order.isOrdered">
        <div id="paypal-button"></div>
      </div>
    </div>
  </main>
</template>

<script>
//  import paypal from 'https://www.paypalobjects.com/api/checkout.js';

  import { mapGetters } from 'vuex';
  import currency from 'currency.js';
  import axios from 'axios';

  import config from '../config';

  export default {
    name: 'checkout',
    data() {
      return {
        order: {
          isOrdered: true,
          isPaid: false,
          id: '',
          total: '',
        },
        user: {
          firstName: '',
          lastName: '',
          email: '',
          address: '',
          postcode: '',
          city: '',
          phoneNumber: '',
        },
      };
    },
    computed: {
      ...mapGetters({
        tickets: 'cartTickets',
      }),
      total() {
        return this.tickets.reduce((a, b) => a + (b.amount * b.price), 0);
      },
    },
    filters: {
      currency: price => currency(price).format(),
    },
    methods: {
      checkout() {
        const formattedItems = [];

        this.tickets.forEach((ticket) => {
          formattedItems.push({
            id: ticket.id,
            quantity: ticket.amount,
          });
        });

        axios.post(`${config.apiEndpoint}/tickets/checkout`, { items: formattedItems, user: this.user })
          .then((response) => {
            console.log(response.data);
            this.order.isOrdered = true;
            this.order.id = response.data.id;
            this.order.total = response.data.total;

            this.showPaymentButton(response.data.id);
          });
      },
      updateOrder(transactionId, creationTime) {
        axios.put(`${config.apiEndpoint}/tickets/checkout`, { orderId: this.order.id, transactionId, creationTime })
          .then((response) => {
            console.log(response.data);
            localStorage.clear();
          });
      },
      showPaymentButton(orderId) {
        paypal.Button.render({
          env: 'sandbox',
          commit: true,
          payment() {
            return paypal.request.post(`${config.apiEndpoint}/tickets/checkout/payment/create`, { orderId })
              .then(response => response.paymentID);
          },
          onAuthorize(data) {
            return paypal.request.post(`${config.apiEndpoint}/tickets/checkout/payment/execute`,
              {
                paymentID: data.paymentID,
                payerID: data.payerID,
              })
              .then((response) => {
                axios.put(`${config.apiEndpoint}/tickets/checkout`, { orderId, transactionId: response.id, creationTime: response.creation_time })
                  .then((response2) => {
                    console.log(response2.data);
                    localStorage.clear();
                  });
              });
          },
        }, '#paypal-button');
      },
    },
    components: {
    },
  };
</script>

<style lang="scss">
  @import '../assets/scss/05_objects/container';
</style>
