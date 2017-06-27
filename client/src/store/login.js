/* eslint-disable no-shadow */
/* eslint-disable arrow-body-style */
/* eslint-disable no-param-reassign */

import axios from 'axios';
import config from '../config';
import Router from '../router/index';

const state = {
  email: localStorage.getItem('email'),
  lastConnection: localStorage.getItem('lastConnection'),
  postCode: localStorage.getItem('postCode'),
};

const getters = {
  email: state => state.email,
  lastConnection: state => state.lastConnection,
  postCode: state => state.postCode,
};

const mutations = {
  setLogin: (state, { email, lastConnection, postCode }) => {
    state.email = email;
    state.lastConnection = lastConnection;
    state.postCode = postCode;
  },
};

const actions = {
  login: (context, infos) => {
    const email = infos.email;
    const postCode = infos.postCode;
    axios.post(`${config.apiEndpoint}/guests`, { email, postCode })
      .then(() => {
        const lastConnection = new Date();
        context.commit('setLogin', { email, lastConnection, postCode });
        localStorage.setItem('email', email);
        localStorage.setItem('lastConnection', lastConnection);
        localStorage.setItem('postCode', postCode);
        Router.push('/');
      })
      .catch((error) => {
        console.log(error);
      });
  },
};

export default { state, getters, mutations, actions };
