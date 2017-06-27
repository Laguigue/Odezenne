import Vue from 'vue';
import Vuex from 'vuex';
import moment from 'moment';

import cart from './cart';
import login from './login';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    cart,
    login,
  },
});

export default store;

// Initialise the Cart store using the saved settings in localStorage
const localCartProducts = JSON.parse(localStorage.getItem('cartTickets'));

const currentDate = moment(new Date());
const expirationDate = moment(localStorage.getItem('cartExpiration'));

if (currentDate.isBefore(expirationDate)) {
  store.commit('initializeCart', localCartProducts);
} else {
  localStorage.clear();
}
