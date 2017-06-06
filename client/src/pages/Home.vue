<template>
  <main>
    <div class="c-scene" v-if="analyserLoaded">
      <grid-scene v-show="scene === 'grid'" :analyser="audioAnalyser" :is-animating="scene === 'grid'"></grid-scene>
      <circle-scene v-show="scene === 'circle'" :analyser="audioAnalyser"
                    :is-animating="scene === 'circle'"></circle-scene>
      <half-circle-scene v-show="scene === 'halfCircle'" :analyser="audioAnalyser"
                         :is-animating="scene === 'halfCircle'"></half-circle-scene>
    </div>
    <player></player>
  </main>
</template>

<script>
  import GridScene from '../scenes/GridScene.vue';
  import CircleScene from '../scenes/CircleScene.vue';
  import HalfCircleScene from '../scenes/HalfCircleScene.vue';
  import Player from '../components/Player/Player';

  import EventBus from '../eventBus';

  export default {
    name: 'home',
    data() {
      return {
        scene: 'grid',
        analyserLoaded: false,
        audioAnalyser: '',
      };
    },
    mounted() {
      EventBus.$on('audioAnalyser:loaded', (audioAnalyser) => {
        this.audioAnalyser = audioAnalyser;
        this.analyserLoaded = true;
      });

      document.addEventListener('keyup', (event) => {
        event.preventDefault();
        if (event.keyCode === 32) {
          this.toggleScene();
        }
      });
    },
    components: {
      GridScene,
      CircleScene,
      HalfCircleScene,
      Player,
    },
    methods: {
      toggleScene() {
        if (this.scene === 'grid') {
          this.scene = 'circle';
        } else if (this.scene === 'circle') {
          this.scene = 'halfCircle';
        } else {
          this.scene = 'grid';
        }
      },
    },
  };
</script>

<style lang="scss">
  .c-scene {
    width: 100vw;
    height: 100vh;

    canvas {
      display: block;
    }
  }
</style>
