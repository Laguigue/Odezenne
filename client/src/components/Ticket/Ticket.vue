<template>
  <div class="o-grid__cell o-grid__cell--4/12">
    <div class="c-ticket">
      <div class="c-ticket__info">
        <span class="c-ticket__city">{{ ticket.city }}</span>
        <span class="c-ticket__date">{{ formattedDate }}</span>
        <span class="c-ticket__place">{{ ticket.location }}</span>
      </div>
      <div class="c-ticket__order">
        <accordion>
          <span class="c-ticket__price" slot="header">{{ formattedPrice }}€</span>
          <div class="c-ticket__buy" slot="content">
            <div class="c-ticket__amount">
              <label class="c-ticket__amount-label">Nombre de places</label>
              <counter :number="amount" :id="ticket.id" @onMinus="removeItem" @onPlus="addItem"></counter>
            </div>
            <button class="c-ticket__cart" @click="addToCart">Ajouter au panier</button>
          </div>
        </accordion>
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment';
  import currency from 'currency.js';

  import store from '../../store';

  import Accordion from './Accordion';
  import Counter from './Counter';

  export default {
    name: 'track',
    props: ['ticket'],
    data() {
      return {
        amount: 1,
      };
    },
    computed: {
      formattedDate() {
        return moment(this.ticket.date).format('dddd Do MMMM');
      },
      formattedPrice() {
        currency.settings.separator = ' ';
        currency.settings.decimal = ',';
        return currency(this.ticket.price).format();
      },
    },
    methods: {
      removeItem() {
        if (this.amount > 0) {
          this.amount -= 1;
        }
      },
      addItem() {
        this.amount += 1;
      },
      addToCart() {
        store.commit('addToCart', { id: this.ticket.id, amount: this.amount, city: this.ticket.city, place: this.ticket.location, date: this.formattedDate, price: this.ticket.price });
      },
    },
    components: {
      Accordion,
      Counter,
    },
  };
</script>

<style lang="scss">
  @import '../../assets/scss/01_settings/colors';
  @import '../../assets/scss/01_settings/typography';

  @import '../../assets/scss/05_objects/grid';

  .c-ticket {
    position: relative;
    margin: 25px 50px;
    border: 5px solid $primary-color;
  }

  .c-ticket__info {
    position: relative;
    top: -40px;
    left: -50px;
  }

  .c-ticket__city,
  .c-ticket__date,
  .c-ticket__place {
    margin: 10px 0;
  }

  .c-ticket__city {
    display: block;
    font-size: $font-huge;
    font-weight: bold;
    text-transform: uppercase;
  }

  .c-ticket__date {
    display: block;
    font-size: $font-biggest;
    font-weight: lighter;
    text-transform: uppercase;
  }

  .c-ticket__place {
    display: block;
    font-size: $font-big;
    font-weight: lighter;
  }

  .c-ticket__order {
    padding: 20px;
    background-color: $primary-color;
  }

  .c-ticket__price {
    font-size: $font-normal;
  }

  .c-ticket__amount {
    display: flex;
    align-items: center;
    padding: 30px 0;
  }

  .c-ticket__amount-label {
    margin-right: 25px;
  }

  .c-ticket__cart {
    width: calc(100% - 30px);
    margin: 0 15px;
    padding: 10px 20px;
    border: 3px solid $neutral-color;
    font-size: $font-small;
    text-align: center;
    text-transform: uppercase;
  }
</style>
