/* eslint-disable no-shadow */
/* eslint-disable arrow-body-style */
/* eslint-disable no-param-reassign */

import axios from 'axios';
import config from '../config';
import Router from '../router/index';

const state = {
  email: localStorage.getItem('email'),
  lastConnection: localStorage.getItem('lastConnection'),
};

const getters = {
  email: state => state.email,
  lastConnection: state => state.lastConnection,
};

const mutations = {
  setLogin: (state, { email, lastConnection }) => {
    state.email = email;
    state.lastConnection = lastConnection;
  },
};

const actions = {
  login: (context, email) => {
    axios.post(`${config.apiEndpoint}/guests`, { email })
      /* eslint-disable no-unused-vars */
      .then((response) => {
        const lastConnection = new Date();
        context.commit('setLogin', { email, lastConnection });
        localStorage.setItem('email', email);
        localStorage.setItem('lastConnection', lastConnection);
        Router.push('/');
      })
      .catch((error) => {
        console.log(error);
      });
  },
};

export default { state, getters, mutations, actions };
