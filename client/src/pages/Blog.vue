<template>
  <main>
    <o-header></o-header>
    <div class="o-container">
      <div>
        <post v-for="post in posts"
              :post="post"
              :key="post.id"></post>
      </div>
    </div>
  </main>
</template>

<script>
  import axios from 'axios';
  import config from '../config';
  import OHeader from '../components/Header';

  import Post from '../components/Blog/Post';

  export default {
    name: 'blog',
    data() {
      return {
        posts: [],
      };
    },
    mounted() {
      this.loadPosts();
    },
    methods: {
      loadPosts() {
        axios.get(`${config.cmsEndpoint}/posts`)
        .then((response) => {
          this.posts = response.data;
        });
      },
    },
    components: {
      Post,
      OHeader,
    },
  };
</script>
