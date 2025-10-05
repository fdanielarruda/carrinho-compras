import type { App } from 'vue';
import vuetify from './vuetify';
// import pinia from '../stores';
import router from '../router';

export function registerPlugins(app: App) {
  app
    .use(vuetify)
    // .use(pinia)
    .use(router)
}