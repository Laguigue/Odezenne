<template>
  <div class="c-player">
    <button class="c-player__action" v-on:click="playPause()">></button>
  </div>
</template>

<script>
  import * as SC from 'soundcloud';
  import Player from 'audio-player';

  const player = new Player();

  export default {
    name: 'player',
    data() {
      return {
        track: '',
        player: '',
      };
    },
    beforeCreate() {
      SC.initialize({
        client_id: 'aeb5b3f63ac0518f8362010439a77ca1',
      });

      SC.get('/tracks/305230891').then((track) => {
        const separator = track.stream_url.indexOf('?') === -1 ? '?' : '&';
        this.track = `${track.stream_url}${separator}client_id=aeb5b3f63ac0518f8362010439a77ca1`;
        player.play(this.track);
      });
    },
    methods: {
      playPause() {
        player.playPause(this.track);
      },
    },
  };
</script>

<style lang="scss">
  .c-player {
    position: fixed;
    bottom: 0;
    width: 100%;
    padding: 10px 20px;
    background-color: black;
    color: white;
  }

  .c-player__action {
    color: white;
  }
</style>
