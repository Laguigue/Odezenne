<template>
  <main>
    <o-header></o-header>
    <div class="o-container">
        <grid></grid>
    </div>
  </main>
</template>

<script>
  import Grid from '../components/Home/Grid';
  import OHeader from '../components/Header';

  export default {
    name: 'home',
    data() {
      return {
      };
    },
    components: {
      Grid,
      OHeader,
    },
  };
</script>

<style lang="scss">

</style>
