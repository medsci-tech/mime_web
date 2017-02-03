@extends('admin::backend.charts.index')

@section('title', '图表')
@section('box_title','图表')

@if (Auth::guest())
@else
  @include('admin::backend.layouts.site_aside')
@endif
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

  <script>
    Vue.component('echart', {
      template: '#template',
      data: function () {
        var data = [
          {name: '北京',value: {{\App\Models\City::where('province', '北京')->sum('student_count')}}},
          {name: '天津',value: {{\App\Models\City::where('province', '天津')->sum('student_count')}}},
          {name: '上海',value: {{\App\Models\City::where('province', '上海')->sum('student_count')}}},
          {name: '重庆',value: {{\App\Models\City::where('province', '重庆')->sum('student_count')}}},
          {name: '河北',value: {{\App\Models\City::where('province', '河北')->sum('student_count')}}},
          {name: '河南',value: {{\App\Models\City::where('province', '河南')->sum('student_count')}}},
          {name: '云南',value: {{\App\Models\City::where('province', '云南')->sum('student_count')}}},
          {name: '辽宁',value: {{\App\Models\City::where('province', '辽宁')->sum('student_count')}}},
          {name: '黑龙江',value: {{\App\Models\City::where('province', '黑龙江')->sum('student_count')}}},
          {name: '湖南',value: {{\App\Models\City::where('province', '湖南')->sum('student_count')}}},
          {name: '安徽',value: {{\App\Models\City::where('province', '安徽')->sum('student_count')}}},
          {name: '山东',value: {{\App\Models\City::where('province', '山东')->sum('student_count')}}},
          {name: '新疆',value: {{\App\Models\City::where('province', '新疆')->sum('student_count')}}},
          {name: '江苏',value: {{\App\Models\City::where('province', '江苏')->sum('student_count')}}},
          {name: '浙江',value: {{\App\Models\City::where('province', '浙江')->sum('student_count')}}},
          {name: '江西',value: {{\App\Models\City::where('province', '江西')->sum('student_count')}}},
          {name: '湖北',value: {{\App\Models\City::where('province', '湖北')->sum('student_count')}}},
          {name: '广西',value: {{\App\Models\City::where('province', '广西')->sum('student_count')}}},
          {name: '甘肃',value: {{\App\Models\City::where('province', '甘肃')->sum('student_count')}}},
          {name: '山西',value: {{\App\Models\City::where('province', '山西')->sum('student_count')}}},
          {name: '内蒙古',value: {{\App\Models\City::where('province', '内蒙古')->sum('student_count')}}},
          {name: '陕西',value: {{\App\Models\City::where('province', '陕西')->sum('student_count')}}},
          {name: '吉林',value: {{\App\Models\City::where('province', '吉林')->sum('student_count')}}},
          {name: '福建',value: {{\App\Models\City::where('province', '福建')->sum('student_count')}}},
          {name: '贵州',value: {{\App\Models\City::where('province', '贵州')->sum('student_count')}}},
          {name: '广东',value: {{\App\Models\City::where('province', '广东')->sum('student_count')}}},
          {name: '青海',value: {{\App\Models\City::where('province', '青海')->sum('student_count')}}},
          {name: '西藏',value: {{\App\Models\City::where('province', '西藏')->sum('student_count')}}},
          {name: '四川',value: {{\App\Models\City::where('province', '四川')->sum('student_count')}}},
          {name: '宁夏',value: {{\App\Models\City::where('province', '宁夏')->sum('student_count')}}},
          {name: '海南',value: {{\App\Models\City::where('province', '海南')->sum('student_count')}}},
          {name: '台湾',value: {{\App\Models\City::where('province', '台湾')->sum('student_count')}}},
          {name: '香港',value: {{\App\Models\City::where('province', '香港')->sum('student_count')}}},
          {name: '澳门',value: {{\App\Models\City::where('province', '澳门')->sum('student_count')}}}
        ];

        return {
          map: {
            title : {
              text: 'mime用户数',
              left: 'center'
            },
            tooltip : {
              trigger: 'item'
            },
            visualMap: {
              min: 0,
              max: 100,
              left: 'left',
              top: 'bottom',
              text:['高','低'],           // 文本，默认为数值文本
              calculable : true,
              inRange: {
                color: ['#eee','rgba(66, 139, 202, 0.9)']
              }
            },
            toolbox: {
              show: true,
              orient : 'vertical',
              left: 'right',
              top: 'center',
              feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                restore : {show: true},
                saveAsImage : {show: true}
              }
            },
            series : [
              {
                name: 'mime用户',
                type: 'map',
                mapType: 'china',
                roam: false,
                label: {
                  normal: {
                    show: false
                  },
                  emphasis: {
                    show: true
                  }
                },
                itemStyle:{
                  emphasis:{
                    areaColor: 'yellow'
                  }
                },
                data: data
              },
            ]
          }
        }
      }
    })
  </script>
@endsection