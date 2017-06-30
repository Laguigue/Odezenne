<template>
    <div>
        <header>
            <img v-if="!opened" @click="burgerAction" class="burger" src="../assets/images/burger.png">
            <img v-else="opened" @click="burgerAction" class="burger" src="../assets/images/burger-close.png">
            <svg :class="{goWhite: opened}" @click="burgerAction" id="logo_header" data-name="Calque 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 659.99 195.95"><title>odezenne_logotype</title><path d="M120.2,180.05v50.72l-16.37-50.72H90v80.69h11.41V210l16.37,50.72h13.95V180.05Zm308.76,0v50.72l-16.37-50.72H398.76v80.69h11.41V210l16.37,50.72h13.95V180.05Zm278.55,0v80.69h36.65v-10H718.92V225.47H750V215.32H718.92V190.2h25.24V180.05Z" transform="translate(-90 -64.79)"/><path d="M744.16,74.93V64.79H707.51v80.69h36.65v-10H718.92V110.2H750V100.06H718.92V74.93ZM593.59,64.79H551.86V74.93H581.6l-29.74,59.48v11.06h41.73v-10H563.85l29.74-59.59ZM437.94,74.93V64.79H401.29v80.69h36.65v-10H412.7V110.2h31.07V100.06H412.7V74.93Zm-180.89,0h9.45c8.18,0,9.34,8.19,9.34,10V125.3a9.93,9.93,0,0,1-9.8,10.14h-9Zm9.45,70.54a26,26,0,0,0,10.14-2.42c6.92-3.46,10.72-9.8,10.72-17.75V85a24.58,24.58,0,0,0-2.54-9.8c-3.34-6.68-9.91-10.37-18.33-10.37H245.65v80.69ZM101.41,85c0-1.73,1.27-10,9.45-10s9.34,8.19,9.34,10V125.3c0,1.84-1.15,10.14-9.34,10.14s-9.45-8.41-9.45-10.14Zm9.45,60.51c8.41,0,15-3.69,18.33-10.38a24.56,24.56,0,0,0,2.54-9.8V85a24.58,24.58,0,0,0-2.54-9.8c-3.34-6.68-9.91-10.37-18.33-10.37s-15,3.69-18.33,10.37A24.58,24.58,0,0,0,90,85V125.3a24.56,24.56,0,0,0,2.54,9.8c3.34,6.69,9.91,10.38,18.33,10.38" transform="translate(-90 -64.79)"/></svg>
            <div class="panier" :class="{goWhite: opened}">
                <span>({{tickets.length}})</span>
                <svg @click="openCartAction" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 98.57 136.5"><title>panier_1</title><g id="Calque_2" data-name="Calque 2"><g id="Calque_1-2" data-name="Calque 1"><path d="M98.51,125.24c-.48-7.4-.12-14.85-.13-22.25,0-7.57-.68-15.1-.63-22.67,0-.85,0-1.7,0-2.55s-.26-1.66-.36-2.5a52.63,52.63,0,0,1-.12-5.9c0-3.73-.13-7.45-.37-11.17s-.59-7.51-.83-11.27c-.19-3,.52-5.93-.75-8.74a7.65,7.65,0,0,0-3-3.46,7.33,7.33,0,0,0-4.41-.83c-4.17.27-8.3.38-12.48.37.12-1.26.33-2.52.44-3.78a3,3,0,0,0-1-2.71c-.24-1.41.18-3,.18-4.44a3.73,3.73,0,0,0-.3-1.71A8.64,8.64,0,0,1,73.82,20c-.37-1.35-.32-2.79-.68-4.16a13.79,13.79,0,0,0-2.22-4.18,42.48,42.48,0,0,0-4.73-6.14A14.58,14.58,0,0,0,62.63,2.9c-1.41-.75-2.78-1.58-4.26-2.19C55.43-.52,52,.22,49,.2a16.12,16.12,0,0,0-4.46.51,24.55,24.55,0,0,0-3.93,1.64A20.93,20.93,0,0,0,34,6.89a35.93,35.93,0,0,0-4.53,6.69,24.83,24.83,0,0,0-2,4.24A31.89,31.89,0,0,0,26.54,23a21.28,21.28,0,0,0-.28,2.64c0,.92.12,1.84.12,2.76s-.09,1.8-.17,2.69A24.29,24.29,0,0,1,26,33.84a13.77,13.77,0,0,1-2.25.08L21.19,34l-4.58.16c-.95.95-1.83,1.95-2.85,2.82.06.74.12,1.47.17,2.21,2.49,0,5,0,7.43-.14A28.38,28.38,0,0,0,7.47,50.87a57.5,57.5,0,0,1-.25-8c-.89-.53-1.61-.75-2.41,0-.59,5-1.07,10-1.26,15.11-.2,5.43-.54,10.84-.91,16.26s-.64,10.65-.89,16S1,100.8.68,106.07c-.17,2.59-.15,5.18-.23,7.77S.24,119.26.16,122c-.07,2.38-.23,4.82-.13,7.2a7.14,7.14,0,0,0,3.19,5.29c1.87,1.44,4,1.26,6.23,1.3l5.17.12c5,.11,9.93.25,14.9.34,6,.11,12-.09,18.07,0,2.81,0,5.68.46,8.48.16,1.46-.16,2.9-.45,4.36-.64a17.36,17.36,0,0,1,2.14-.16c.3,0,.62,0,.92,0,.12,0,.71-.21.78-.19A19.21,19.21,0,0,1,67.4,135c.65,0,1.28.09,1.94.06s1.55-.06,2.33-.08c3.09,0,6.07.52,9.14.73,1.54.11,3.08.15,4.61.18s3,.2,4.48.08c1.12-.09,1.87-.93,3-1,1.31-.06,2.49.1,3.59-.78,1.31-1,1-2.7,1.36-4.16.2-.78.53-1.53.66-2.32A11,11,0,0,0,98.51,125.24Zm-93.37-10a8,8,0,0,0,2.62,2.14A21.44,21.44,0,0,0,5,119.9Q5.09,117.59,5.14,115.28Zm-.55,14.25c.07-.54.12-1.09.17-1.64a7.89,7.89,0,0,0,3.6,1.68c.19.19.38.34.56.49C7.47,130,6,129.75,4.59,129.54ZM7.15,83.21c-.11.65-.32,1.53-.59,2.56.13-2.41.25-4.82.34-7.23.11-3,.46-6,.7-9q.19-2.37.36-4.73a11.62,11.62,0,0,0,.13-1.89c0-.06,0-.12,0-.18,1.32,2.14,2.8,4.26,3.15,6.66C11.78,73.37,7.81,79.14,7.15,83.21Zm9.78,47.07h-.74l-3.68-.08c1.42-1.34,2.45-3.93,4.6-3.26A2.47,2.47,0,0,0,16.93,130.28Zm11.82.2a3.31,3.31,0,0,1,1.09-.07.51.51,0,0,1,.23.09Zm3-87.34c0-.13-.05-.23-.08-.35.24-1.45.33-2.91.52-4.37a66.6,66.6,0,0,1,6.86.06C36.36,39.88,33.48,42.2,31.77,43.13ZM43,130.64a2.49,2.49,0,0,1,.58-.27,1.13,1.13,0,0,1,.77.26Zm14.12-.42c-1.9.05-3.79.12-5.68.19a7.27,7.27,0,0,1,3.13-2c.7-.13,4,.95,6.77,1.78C59.89,130.17,58.49,130.19,57.08,130.23Zm-5.19-17.18,2.22-1.36q.49.91-.31,1.11Q52.77,114.46,51.89,113.05ZM66.83,34.22V34l-7.67,0-13.57-.07-6.7,0h-5a6.15,6.15,0,0,0-1.46,0,5.59,5.59,0,0,1-.42-2,16.21,16.21,0,0,1-.1-2.44,28.1,28.1,0,0,1,.57-4.87A45.81,45.81,0,0,1,33.76,20c.23-.71.42-1.44.67-2.14s.72-1.48,1-2.24.34-1.82.64-2.7a11.9,11.9,0,0,1,6.75-7.17c2.24-.92,5.28-1.43,7.47-.16,2.57-.24,4.7.53,7.1,1.28A16.39,16.39,0,0,1,64,10.41a10.94,10.94,0,0,1,2.18,2.72A22.05,22.05,0,0,1,67.4,16.8c.4,1.25,1.12,2.34,1.47,3.62a20.93,20.93,0,0,1,.58,3.78c.28,3.36.22,6.66.25,10C68.77,34.31,67.78,34.21,66.83,34.22ZM93,57.48c0,1.53-.12,3.1,0,4.62a3,3,0,0,0,0,.32,9,9,0,0,1,.17,2.09C93.1,65.77,93,67,93,68.27c0,1.52,0,3,0,4.55a8.39,8.39,0,0,1-.1,1.75c.09-8.07,0-15.49-.53-20.82A6.51,6.51,0,0,1,93,57.48ZM77.57,80.34q.79,3.69-2,4.36l.24-.32A3.61,3.61,0,0,1,77.57,80.34Zm2.69,28.85c-3.62,2.26-3.48-1.91-6.74-.24a5.11,5.11,0,0,1,7.06.11A1.63,1.63,0,0,0,80.26,109.19Zm1.57-14.3,0,0,0,0Zm2.92-41.22q-.61,7-1.27,14c-6.19-7.28-4.11-.3-1.27-9.1.94-2.91.25-5.78,2-7.75C84.81,52.22,84.91,51.85,84.75,53.67ZM91.59,47c0,.76.07,1.51.1,2.27a9.2,9.2,0,0,0-1.13-3.16c-2.61-3.74-6.8-5.68-11.2-7L84.16,39l2.34-.08a5.73,5.73,0,0,1,2.08.08c.57.2,1.12.45,1.68.67a5.9,5.9,0,0,0,1.73.59,4.41,4.41,0,0,1-.24,1.36,13.74,13.74,0,0,0-.25,1.73A36.05,36.05,0,0,0,91.59,47Zm2.47,80.89a19.29,19.29,0,0,0-1.31-1.69C91.12,126,92,107,92.59,87.5c0,.66.06,1.32.09,2,.19,3.55.3,7,.16,10.61s.14,7.1.31,10.64q.15,3.25.32,6.51c.09,1.84.19,3.67.29,5.51q.08,1.53.16,3.07A17.38,17.38,0,0,1,94.06,127.91Z"/></g></g></svg>
                <cart :isOpen="isCartOpened"></cart>
            </div>
        </header>
        <nav :class="{active: opened}">
            <router-link class="router-link" :to="{ name: 'Home' }" exact @click.native="burgerAction">Giga Timeline</router-link>
            <a href="#" class="router-link">Shop</a>
            <router-link class="router-link" :to="{ name: 'Billetterie' }" @click.native="burgerAction">Billeterie</router-link>
            <a href="#" class="router-link">Historique</a>
            <router-link class="router-link" :to="{ name: 'Blog' }" @click.native="burgerAction">Blog</router-link>
            <div class="RS">
                <a href="https://twitter.com/odezenne" target="_blank"><img src="../assets/images/twitter.png"></a>
                <a href="https://www.facebook.com/odezenne/" target="_blank"><img src="../assets/images/facebook-logo.png"></a>
                <a href="https://www.instagram.com/odezenne_/?hl=fr" target="_blank"><img src="../assets/images/instagram.png"></a>
                <a href="https://www.youtube.com/user/alo2zen" target="_blank"><img src="../assets/images/youtube.png"></a>
                <a href="https://soundcloud.com/odezenne" target="_blank"><img src="../assets/images/soundcloud.png"></a>
            </div>
        </nav>
        <div v-if="opened" :class="{active: opened, overlay: true}"></div>
    </div>
</template>

<script>
  import { mapGetters } from 'vuex';

  import cart from './Ticket/Cart';

  export default {
    name: 'OHeader',
    components: {
      cart,
    },
    data() {
      return {
        opened: false,
        isCartOpened: false,
      };
    },
    mounted() {
      document.onclick = (e) => {
        if (e.target.classList.contains('overlay')) {
          this.opened = false;
        }
      };
    },
    computed: {
      ...mapGetters({
        tickets: 'cartTickets',
      }),
    },
    methods: {
      burgerAction() {
        this.opened = !this.opened;
      },
      openCartAction() {
        this.isCartOpened = !this.isCartOpened;
      },
    },
  };
</script>

<style lang="scss" scoped>
    header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        height: 200px;
        padding: 30px;
        z-index: 12;
    }
    nav {
        transition: all 0.6s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        background-color: rgba(0,0,0,0.9);
        position: absolute;
        top: -550px;
        width: 100%;
        height: 550px;
        z-index: 10;
    }
    nav>a {
        color: #fff;
        text-decoration: none;
        padding: 17px 0;
        text-transform: uppercase;
    }
    nav a {
        opacity: 0;
    }
    nav.active {
        top: 0;
    }
    nav.active a {
        animation-name: nav-appear;
        animation-duration: 500ms;
        animation-delay: 250ms;
        animation-fill-mode: forwards;
    }
    header>div {
        transition: all 0.6s ease;
    }
    .goWhite {
        color: #fff;
    }
    .RS {
        display: flex;
        justify-content: center;
        padding: 30px 0px 12px 0px;
    }
    .RS img {
        width: 20px;
    }
    .RS>a {
        color: #fff;
        text-decoration: none;
        padding: 10px 15px;
    }
    .RS>a:hover {
        cursor: pointer;
    }
    #logo_header, .panier svg {
        transition: all 0.6s ease;
        height: 100%;
        fill: black;
    }
    #logo_header.goWhite, .panier svg.goWhite {
        fill: #fff;
    }
    .router-link {
        position: relative;
    }
    .router-link::before {
        transition: all 0.4s ease;
        display: block;
        content: '';
        height: 1px;
        position: absolute;
        top:0;
        bottom:2px;
        margin: auto;
        width:0;
        background-color: #fff;
    }
    .router-link.router-link-active::before, .router-link:hover::before {
        width:100%;
    }
    .burger {
        width: 24px;
    }
    .panier {
        display: flex;
        align-items: center;
    }
    .panier span {
        padding-right: 8px;
    }
    .burger:hover, .panier:hover {
        cursor: pointer;
    }
    .panier svg {
        width: 20px;
    }
    .panier.goWhite svg {
        fill: #fff;
    }
    .overlay {
      position:fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #000;
      opacity: 0;
      transition: all 0.6s ease;
      &.active{
        z-index: 9;
      }
    }
    @keyframes nav-appear {
        0% { opacity: 0 }
        100% { opacity: 1 }
    }
</style>
