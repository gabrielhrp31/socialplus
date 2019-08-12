import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);

export default new Vuetify({
  theme: {
    themes: {
      light: {
        primary: '#ee343c',
        secondary: '#ffffff',
        black:'#000000',
        accent: '#2e53e6',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107',
        danger: '#d0060e',
      },
    },
  },
  icons: {
    iconfont: 'mdi',
  },
});
