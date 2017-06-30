<template>
  <main>
    <div class="o-container">
      <div class="o-grid o-grid--guttered">
        <loader v-if="!isLoaded"></loader>
        <search v-if="isLoaded"></search>
        <ticket v-for="regionalTicket in regionalTickets"
                :ticket="regionalTicket"
                :key="regionalTicket.id"
                :modifier="'regional'"></ticket>
        <ticket v-for="ticket in tickets"
                :ticket="ticket"
                :key="ticket.id"
                :modifier="'current'"></ticket>
        <ticket v-for="passedTicket in passedTickets"
                :ticket="passedTicket"
                :key="passedTicket.id"
                :modifier="'passed'"></ticket>
      </div>
    </div>
  </main>
</template>

<script>
  import { mapGetters } from 'vuex';
  import axios from 'axios';

  import config from '../config';

  import Ticket from '../components/Ticket/Ticket';
  import Search from '../components/Ticket/Search';
  import Loader from '../components/Loader';

  export default {
    name: 'ticketing',
    data() {
      return {
        allTickets: [],
        regionalTickets: [],
        passedTickets: [],
        search: '',
        isLoaded: false,
      };
    },
    computed: {
      ...mapGetters({
        postCode: 'postCode',
      }),
      tickets() {
        return this.allTickets.filter((ticket) => {
          const lowerCaseCity = ticket.city.toLowerCase();
          const lowerCaseSearch = this.search.toLowerCase();

          return lowerCaseCity.indexOf(lowerCaseSearch) !== -1;
        });
      },
    },
    mounted() {
      this.getTickets();
      this.$on('emitSearch', (search) => {
        this.search = search;
      });
    },
    methods: {
      getTickets() {
        axios.get(`${config.apiEndpoint}/tickets`)
          .then((response) => {
            this.orderTickets(response.data);
            this.isLoaded = true;
          });
      },
      orderTickets(allTickets) {
        const upcomingTickets = allTickets.filter(ticket => new Date(ticket.date) >= new Date());
        const passedTickets = allTickets.filter(ticket => new Date(ticket.date) < new Date());

        if (this.postCode) {
          const formattedZipcode = this.postCode.substring(0, 2);
          const filteredRegionalTickets = upcomingTickets.filter((ticket) => {
            const formattedTicketZipcode = ticket.zipcode.substring(0, 2);
            return formattedZipcode === formattedTicketZipcode;
          });
          this.regionalTickets = this.regionalTickets.concat(filteredRegionalTickets);
        }

        upcomingTickets.sort((a, b) => new Date(a.date) - new Date(b.date));
        passedTickets.sort((a, b) => new Date(a.date) - new Date(b.date));

        this.allTickets = this.allTickets.concat(upcomingTickets);
        this.passedTickets = this.passedTickets.concat(passedTickets);
      },
    },
    components: {
      Ticket,
      Search,
      Loader,
    },
  };
</script>

<style lang="scss" scoped>
  @import '../assets/scss/05_objects/container';
  @import '../assets/scss/01_settings/typography';
  @import '../assets/scss/01_settings/colors';

.logo {
    text-align: center;
    margin: 80px 0;
    width: 100%;
  }

.logo img {
    width: 40%;
  }

.search{
  width: 300px;
  margin: 45px auto 80px;
  margin-top: 20px;
  position:relative;
}

.search input{
  -webkit-appearance: none;
  border: none;
  border-radius: 0;
  background-color: transparent;
  border-bottom: 1px solid $_black;
  display: block;
  width: 300px;
  font-size: $font-smaller;
  padding: .25em;
  box-sizing: border-box;
  outline: none;
  font-family: $primary-font-family;
  letter-spacing: 2px;
}

.right{
  float: right;
  position: relative;
  left: 50px;
  bottom: 40px;
  font-size: 40px !important;
}

</style>
