import moment from 'moment';

/* eslint-disable no-shadow */
const state = {
  tickets: [],
};

const getters = {
  cartTickets: state => state.tickets,
};

// mutations
const mutations = {
  addToCart(state, { id, amount, city, place, date, price }) {
    const record = state.tickets.find(t => t.id === id);
    const currentDate = moment(new Date());
    const expirationDate = currentDate.add(1, 'minutes');

    if (!record) {
      state.tickets.push({
        id,
        city,
        place,
        price,
        date,
        amount,
      });
    } else {
      record.id = id;
      record.city = city;
      record.place = place;
      record.price = price;
      record.date = date;
      record.amount = amount;
    }

    // Set to LocalStorage
    localStorage.setItem('cartTickets', JSON.stringify(state.tickets));
    localStorage.setItem('cartExpiration', expirationDate);
  },
  removeFromCart(state, id) {
    state.tickets.forEach((ticket, index) => {
      if (ticket.id === id) {
        state.tickets.splice(index, 1);
      }
    });

    const currentDate = moment(new Date());
    const expirationDate = currentDate.add(1, 'minutes');

    // Set to LocalStorage
    localStorage.setItem('cartTickets', JSON.stringify(state.tickets));
    localStorage.setItem('cartExpiration', expirationDate);
  },
  initializeCart(state, tickets) {
    tickets.forEach(ticket => state.tickets.push(ticket));
  },
};

export default {
  state,
  getters,
  mutations,
};
