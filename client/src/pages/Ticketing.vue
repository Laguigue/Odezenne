<template>
  <main>
    <o-header></o-header>
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
  import { mapGetters } from 'vuex';
  import axios from 'axios';

  import config from '../config';

  import Ticket from '../components/Ticket/Ticket';
  import Cart from '../components/Ticket/Cart';
  import OHeader from '../components/Header';

  export default {
    name: 'ticketing',
    data() {
      return {
        tickets: [],
      };
    },
    computed: {
      ...mapGetters({
        postCode: 'postCode',
      }),
    },
    mounted() {
      this.getTickets();
    },
    methods: {
      getTickets() {
        axios.get(`${config.apiEndpoint}/tickets`)
          .then((response) => {
            this.orderTickets(response.data);
          });
      },
      orderTickets(tickets) {
        const formattedZipcode = this.postCode.substring(0, 2);

        const upcomingTickets = tickets.filter(ticket => new Date(ticket.date) >= new Date());

        this.tickets = upcomingTickets.filter((ticket) => {
          const formattedTicketZipcode = ticket.zipcode.substring(0, 2);
          return formattedZipcode === formattedTicketZipcode;
        });

        upcomingTickets.sort((a, b) => new Date(a.date) - new Date(b.date));

        this.tickets = this.tickets.concat(upcomingTickets);
      },
    },
    components: {
      Ticket,
      Cart,
      OHeader,
    },
  };
</script>

<style lang="scss">
  @import '../assets/scss/05_objects/container';
</style>
