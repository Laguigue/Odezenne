<template>
  <main>
    <header></header>
    <div class="o-container">
      <div class="o-grid o-grid--guttered">
        <ticket v-for="ticket in tickets"
                :ticket="ticket"
                :key="ticket.id"></ticket>
      </div>
      <cart></cart>
    </div>
  </main>
</template>

<script>
  import axios from 'axios';
  import config from '../config';

  import Ticket from '../components/Ticket/Ticket';
  import Cart from '../components/Ticket/Cart';

  export default {
    name: 'ticketing',
    data() {
      return {
        tickets: [],
      };
    },
    mounted() {
      this.getTickets();
    },
    methods: {
      getTickets() {
        axios.get(`${config.apiEndpoint}/tickets`)
          .then((response) => {
            this.tickets = response.data;
          });
      },
    },
    components: {
      Ticket,
      Cart,
    },
  };
</script>

<style lang="scss">
  @import '../assets/scss/05_objects/container';
</style>
