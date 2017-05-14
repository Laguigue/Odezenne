<template>
  <div class="c-cart">
    <button class="c-cart__button"></button>
    <div class="c-cart__content">
      <div class="c-cart__item"
           v-for="ticket in tickets">
        <div class="c-cart__item-label">
          <span class="c-cart__item-title">{{ ticket.city }} - {{ ticket.place }}</span>
          <span class="c-cart__item-date">{{ ticket.date }}</span>
        </div>
        <div class="c-cart__item-information">
          <span class="c-cart__item-price">{{ ticket.price | currency }}€</span>
          <counter :number="ticket.amount" :id="ticket.id" @onMinus="removeItem" @onPlus="addItem"></counter>
        </div>
      </div>
      <div class="c-cart__action">
        <span class="c-cart__total">Total : {{ total | currency }}€</span>
        <button class="c-cart__checkout" @click.prevent="checkout">Passer la commande</button>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex';
  import currency from 'currency.js';

  import store from '../../store';
  import router from '../../router';

  import Counter from './Counter';

  export default {
    name: 'cart',
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
    mounted() {
      currency.settings.separator = ' ';
      currency.settings.decimal = ',';
    },
    methods: {
      removeItem(id) {
        const ticket = this.tickets.find(t => t.id === id);
        if (ticket.amount > 1) {
          ticket.amount -= 1;
          store.commit('addToCart', { id, amount: ticket.amount, city: ticket.city, place: ticket.place, date: ticket.date, price: ticket.price });
        } else {
          store.commit('removeFromCart', id);
        }
      },
      addItem(id) {
        const ticket = this.tickets.find(t => t.id === id);
        ticket.amount += 1;
        store.commit('addToCart', { id, amount: ticket.amount, city: ticket.city, place: ticket.place, date: ticket.date, price: ticket.price });
      },
      checkout() {
        router.push({ name: 'Checkout' });
      },
    },
    components: {
      Counter,
    },
  };
</script>

<style lang="scss">
  @import '../../assets/scss/01_settings/colors';

  .c-cart__content {
    display: inline-flex;
    flex-direction: column;
  }

  .c-cart__item {
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    margin: 15px 0;
  }

  .c-cart__item-label {
    margin-right: 50px;
  }

  .c-cart__item-title {
    display: block;
  }

  .c-cart__item-date {
    display: block;
  }

  .c-cart__item-information {
    display: flex;
    align-items: center;
  }

  .c-cart__item-price {
    margin-right: 15px;
  }

  .c-cart__action {
    margin: 20px 0;
  }

  .c-cart__total {
    display: block;
    text-align: right;
  }

  .c-cart__checkout {
    width: calc(100% - 40px);
    margin: 25px 20px;
    padding: 10px 20px;
    border: 2px solid $dark-color;
    text-align: center;
  }
</style>
