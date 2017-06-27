import Vue from 'vue';
import Router from 'vue-router';

import Page404 from '../pages/404';
import Login from '../pages/Login';
import Player from '../pages/Player';
import Home from '../pages/Home';
import Ticketing from '../pages/Ticketing';
import Checkout from '../pages/Checkout';
import Store from '../store/index';

Vue.use(Router);

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
      meta: { requiresAuth: true },
    },
    {
      path: '/login',
      name: 'Login',
      component: Login,
    },
    {
      path: '/player',
      name: 'Player',
      component: Player,
    },
    {
      path: '/billetterie',
      name: 'Billetterie',
      component: Ticketing,
      meta: { requiresAuth: true },
    },
    {
      path: '/checkout',
      name: 'Checkout',
      component: Checkout,
      meta: { requiresAuth: true },
    },
    {
      // This one MUST stay in last place as it handles redirection for unmatched routes
      path: '*',
      name: '404',
      component: Page404,
    },
  ],
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (Store.getters.email === null) {
      next({
        path: '/login',
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
