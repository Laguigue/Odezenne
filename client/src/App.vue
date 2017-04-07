<template>
  <div id="app">
    <router-view></router-view>
    <player></player>
  </div>
</template>

<script>
  import Player from './components/Player';

  export default {
    name: 'app',
    components: {
      Player,
    },
  };
</script>

<style lang="scss">
  @import '~reset-css/_reset';
  @import 'assets/scss/03_generic/button';
  @import 'assets/scss/04_elements/body';
</style>
