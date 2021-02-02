require('./bootstrap');

require('moment');

import Vue from 'vue';

import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';

Vue.mixin({ methods: { route } });
Vue.use(plugin)
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.component('top-menu', require('./Components/TopMenu').default)
Vue.component('drop-down-menu', require('./Components/DropDownMenu').default)
Vue.component('like-red-heart', require('./Components/LikeRedHeart').default)
Vue.component('like-empty-heart', require('./Components/LikeEmptyHeart').default)
Vue.component('post-item', require('./Components/PostItem').default)
Vue.component('primary-post-item', require('./Components/PrimaryPostItem').default)

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(App, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
