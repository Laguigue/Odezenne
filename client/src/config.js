/* eslint-disable import/no-mutable-exports */
let config = {};

if (process.env.NODE_ENV === 'development') {
  config = {
    apiEndpoint: 'http://lumen.o2n/api/v1',
    cmsEndpoint: 'http://wordpress.o2n/wp-json/wp/v2',
  };
} else if (process.env.NODE_ENV === 'staging') {
  config = {
    apiEndpoint: 'https://api.o2n.bramvanosta.com/api/v1',
    cmsEndpoint: 'https://admin.o2n.bramvanosta.com/wp-json/wp/v2',
  };
} else {
  config = {
    apiEndpoint: 'http://api.odezenne.com/api/v1',
    cmsEndpoint: 'http://admin.odezenne.com/wp-json/wp/v2',
  };
}

export default config;
