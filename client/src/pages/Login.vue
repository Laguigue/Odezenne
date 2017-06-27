<template>
  <main class="login-page" role="main">
    <h1><img src="../assets/images/odezenne_logotype.svg"></h1>
    <div>Entrez votre adresse mail <br> et plongez dans l'univers d'Odezenne.</div>
    <form class="login-form">
      <div class="email-input">
        <input type="email" v-model="email" placeholder="Entrez votre adresse mail" required />
        <img src="../assets/images/trait_2.svg">
      </div>
      <div class="postcode-input">
        <input type="text" v-model="postCode" placeholder="Entrez votre code postal" required maxlength="5"/>
        <img src="../assets/images/trait_2.svg">
      </div>
      <div class="drawbox" @click.prevent="onLogin">
        <div class="draw">
          <input type="submit" value="VALIDER" />
        </div>
      </div>
      <div class="error-mail" :class="{active: errorMailLog != ''}">{{errorMailLog}}</div>
      <div class="error-postcode" :class="{active: errorPostcodeLog != ''}">{{errorPostcodeLog}}</div>
    </form>
  </main>
</template>

<script>
  import { mapActions } from 'vuex';

  export default {
    name: 'Login',
    data() {
      return {
        email: '',
        errorMailLog: '',
        errorPostcodeLog: '',
        postCode: '',
      };
    },
    methods: {
      ...mapActions({
        login: 'login',
      }),
      postCodeTest(code) {
        if (code.length !== 5 || isNaN(code) || code.length === 0) {
          return false;
        }
        return true;
      },
      onLogin() {
        /* eslint-disable no-useless-escape*/
        const reMail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        if (reMail.test(this.email) && this.postCodeTest(this.postCode)) {
          this.login({ email: this.email, postCode: this.postCode });
          this.errorMailLog = 'Chargement ...';
          this.errorPostcodeLog = '';
        } else {
          if (!reMail.test(this.email)) {
            this.errorMailLog = 'Veuillez entrer un e-mail valide';
          } else {
            this.errorMailLog = '';
          }
          if (this.postCodeTest(this.postCode)) {
            this.errorPostcodeLog = '';
          } else {
            this.errorPostcodeLog = 'Veuillez entrer un code postal valide';
          }
        }
      },
    },
  };
</script>

<style lang="scss">
  .login-page {
    display: flex;
    align-items: center;
    flex-direction: column;
    width: 100%;
    font-weight: 700;
  }
  .login-page h1 {
    text-align: center;
    margin: 80px 0;
    width: 100%;
  }
  .login-page img {
    width: 80%;
  }
  .login-page>div {
    text-align: center;
    margin-bottom: 30px;
  }
  .login-form {
    display: flex;
    flex-direction: column;
    width: 80%;
    margin: 0 auto;
    align-items: center;
  }
  .email-input, .postcode-input {
    position: relative;
    width: 80%;
  }
  .postcode-input {
    margin-top: 18px;
  }
  .email-input img, .postcode-input img {
    position: absolute;
    bottom:0;
    left:0;
    width:80%;
    right: 0;
    margin: auto;
  }
  .drawbox {
    position:relative;
    padding:8px 30px;
    cursor: pointer;
    margin-top: 60px;
  }

  .draw:after {
    transition: all 0.4s ease;
    border: 0.1em solid transparent;
    border-image: url('http://emptyeasel.com/wp-content/uploads/2012/11/creatingtexture2-carrielewis.jpg') 0 27 27 27 round stretch;
    transform: rotate(-1deg);
    content: '';
    top:0px;
    left:0px;
    position:absolute;
    width:100%;
    height:100%;

  }
  .draw:before:hover {
    transform: rotate(-50deg);
  }
  .draw:before {
    transition: all 0.4s ease;
    border-top: 0.1em solid transparent;
    border-image: url('http://emptyeasel.com/wp-content/uploads/2012/11/creatingtexture2-carrielewis.jpg') 27 0 0 0 stretch round;
    content: '';
    height: 3em;
    left: 0;
    top: 0;
    transform: rotate(-1deg);
    width:100%;
    position:absolute;
  }
  input[type=email], input[type=text] {
    width: 100%;
    height: 50px;
    background-color: transparent;
    border: none;
    outline: none;
    font-family: "Roboto Condensed";
    font-size: 1rem;
    font-weight: 700;
    position: relative;
    text-align: center;
  }
  .error-mail, .error-postcode {
    transition: all 0.5s ease;
    /*background-color: #E040FB;*/
    background-color: black;
    padding: 8px;
    margin-top: 20px;
    display: inline-flex;
    opacity: 0;
    transform: translateY(50px);
    color: #fff;
  }
  .error-mail.active, .error-postcode.active {
    transform: translateY(0px);
    opacity: 1;
  }
  @media(min-width: 720px) {
    .login-form {
      width: 50%;
    }
    .email-input, .postcode-input {
      width: 60%;
    }
  }
</style>
