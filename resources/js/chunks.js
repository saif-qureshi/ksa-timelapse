window.Vue = require('vue').default;

Vue.component('add-developer', () => import(/*viteChunkName:"ArtistAdd"*/'./components/backend/developer/Add.vue'));
Vue.component('edit-developer', () => import(/*viteChunkName:"ArtistEdit"*/'./components/backend/developer/Edit.vue'));
