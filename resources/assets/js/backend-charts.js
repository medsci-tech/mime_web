var ECharts = require('vue-echarts/src/components/ECharts.vue');
require('echarts');
require('./map/china');
require('echarts/extension/bmap/bmap');
// register the component to use
Vue.component('chart', ECharts);
