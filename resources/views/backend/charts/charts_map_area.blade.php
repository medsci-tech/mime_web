@extends('backend.charts.index')

@section('title', '图表')
@section('box_title','图表')

@section('charts_data')
  <template id="template">
    <chart :options="map"></chart>
  </template>

  <style>
    .echarts {
      width: 100%;
      height: 600px;
    }
  </style>

  <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=LTE6HGnzAZd2C4AS0BWjk9nEgDglWay8"></script>

  <script>
    Vue.component('echart', {
      template: '#template',
      data: function () {
        var data = [
          //{name:'武汉',value:[114.300908,30.609866, 50]},
                @foreach($cities as $city)
                   {name:'{{$city->city.$city->area}}', value:[{{$city->longitude}}, {{$city->latitude}}, {{$city->student_count}}]},
                @endforeach
        ];

        return {
          map: {
            title: {
              text: '全国mime用户分布图',
              left: 'center'
            },
            tooltip : {
              trigger: 'item'
            },
            bmap: {
              center: [104.114129, 37.550339],
              zoom: 5,
              roam: true,
              mapStyle: {
                styleJson: [{
                  'featureType': 'water',
                  'elementType': 'all',
                  'stylers': {
                    'color': '#d1d1d1'
                  }
                }, {
                  'featureType': 'land',
                  'elementType': 'all',
                  'stylers': {
                    'color': '#f3f3f3'
                  }
                }, {
                  'featureType': 'railway',
                  'elementType': 'all',
                  'stylers': {
                    'visibility': 'off'
                  }
                }, {
                  'featureType': 'highway',
                  'elementType': 'all',
                  'stylers': {
                    'color': '#fdfdfd'
                  }
                }, {
                  'featureType': 'highway',
                  'elementType': 'labels',
                  'stylers': {
                    'visibility': 'off'
                  }
                }, {
                  'featureType': 'arterial',
                  'elementType': 'geometry',
                  'stylers': {
                    'color': '#fefefe'
                  }
                }, {
                  'featureType': 'arterial',
                  'elementType': 'geometry.fill',
                  'stylers': {
                    'color': '#fefefe'
                  }
                }, {
                  'featureType': 'poi',
                  'elementType': 'all',
                  'stylers': {
                    'visibility': 'off'
                  }
                }, {
                  'featureType': 'green',
                  'elementType': 'all',
                  'stylers': {
                    'visibility': 'off'
                  }
                }, {
                  'featureType': 'subway',
                  'elementType': 'all',
                  'stylers': {
                    'visibility': 'off'
                  }
                }, {
                  'featureType': 'manmade',
                  'elementType': 'all',
                  'stylers': {
                    'color': '#d1d1d1'
                  }
                }, {
                  'featureType': 'local',
                  'elementType': 'all',
                  'stylers': {
                    'color': '#d1d1d1'
                  }
                }, {
                  'featureType': 'arterial',
                  'elementType': 'labels',
                  'stylers': {
                    'visibility': 'off'
                  }
                }, {
                  'featureType': 'boundary',
                  'elementType': 'all',
                  'stylers': {
                    'color': '#fefefe'
                  }
                }, {
                  'featureType': 'building',
                  'elementType': 'all',
                  'stylers': {
                    'color': '#d1d1d1'
                  }
                }, {
                  'featureType': 'label',
                  'elementType': 'labels.text.fill',
                  'stylers': {
                    'color': '#999999'
                  }
                }]
              }
            },
            series : [
              {
                name: 'mime用户数',
                type: 'scatter',
                coordinateSystem: 'bmap',
                data: data,
                symbolSize: function (val) {
                  if(val[2] > 150) {
                      return 30;
                  } else if(val[2] < 30 && val[2] > 0) {
                    return 6;
                  } else {
                    return val[2]/ 5;
                  }
                },
                label: {
                  normal: {
                    formatter: '{b}',
                    position: 'right',
                    show: false
                  },
                  emphasis: {
                    show: true
                  }
                },
                itemStyle: {
                  normal: {
                    color: 'green'
                  }
                }
              },
//              {
//                name: 'Top 5',
//                type: 'effectScatter',
//                coordinateSystem: 'bmap',
//                data: convertData(data.sort(function (a, b) {
//                  return b.value - a.value;
//                }).slice(0, 6)),
//                symbolSize: function (val) {
//                  return val[2] / 10;
//                },
//                showEffectOn: 'render',
//                rippleEffect: {
//                  brushType: 'stroke'
//                },
//                hoverAnimation: true,
//                label: {
//                  normal: {
//                    formatter: '{b}',
//                    position: 'right',
//                    show: true
//                  }
//                },
//                itemStyle: {
//                  normal: {
//                    color: 'purple',
//                    shadowBlur: 10,
//                    shadowColor: '#333'
//                  }
//                },
//                zlevel: 1
//              }
            ]
          }
        }
      }
    })
  </script>
@endsection