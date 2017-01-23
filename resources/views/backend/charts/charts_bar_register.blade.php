@extends('backend.charts.index')

@section('title', '图表')
@section('box_title','图表')

@if (Auth::guest())
@else
  @include('newback.layouts.site_aside')
@endif
@section('charts_data')

  <template id="template">
    <chart :options="bar"></chart>
  </template>

  <style>
    .echarts {
      width: 100%;
      height: 500px;
    }
  </style>

  <script>
    Vue.component('echart', {
      template: '#template',
      data: function () {

        return {
          bar: {
            title: {
              text: '2016甲状腺公开课 学员注册',
              subtext: 'By Medscience-tech'
            },
            tooltip: {
              trigger: 'axis'
            },
            legend: {
              data: ['注册人数', '报名人数']
            },
            toolbox: {
              show: true,
              feature: {
                mark: {show: true},
                dataView: {show: true, readOnly: false},
                magicType: {show: true, type: ['line', 'bar']},
                restore: {show: true},
                saveAsImage: {show: true}
              }
            },
            calculable: true,
            xAxis: [
              {
                type: 'category',
                data: ['3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月']
              }
            ],
            yAxis: [
              {
                type: 'value'
              }
            ],
            series: [
              {
                name: '注册人数',
                type: 'bar',
                data: [
                  {{\App\Models\Student::where('created_at', '>', '2016-03-01 00:00:00')->where('created_at', '<', '2016-04-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('created_at', '>', '2016-04-01 00:00:00')->where('created_at', '<', '2016-05-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('created_at', '>', '2016-05-01 00:00:00')->where('created_at', '<', '2016-06-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('created_at', '>', '2016-06-01 00:00:00')->where('created_at', '<', '2016-07-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('created_at', '>', '2016-07-01 00:00:00')->where('created_at', '<', '2016-08-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('created_at', '>', '2016-08-01 00:00:00')->where('created_at', '<', '2016-09-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('created_at', '>', '2016-09-01 00:00:00')->where('created_at', '<', '2016-10-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('created_at', '>', '2016-10-01 00:00:00')->where('created_at', '<', '2016-11-01 00:00:00')->count()}},
                ],
                markPoint: {
                  data: [
                    {type: 'max', name: '最大值'},
                    {type: 'min', name: '最小值'}
                  ]
                },
                markLine: {
                  data: [
                    {type: 'average', name: '平均值'}
                  ]
                }
              },
              {
                name: '报名人数',
                type: 'bar',
                data: [
                  {{\App\Models\Student::where('entered_at', '>', '2016-03-01 00:00:00')->where('entered_at', '<', '2016-04-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('entered_at', '>', '2016-04-01 00:00:00')->where('entered_at', '<', '2016-05-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('entered_at', '>', '2016-05-01 00:00:00')->where('entered_at', '<', '2016-06-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('entered_at', '>', '2016-06-01 00:00:00')->where('entered_at', '<', '2016-07-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('entered_at', '>', '2016-07-01 00:00:00')->where('entered_at', '<', '2016-08-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('entered_at', '>', '2016-08-01 00:00:00')->where('entered_at', '<', '2016-09-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('entered_at', '>', '2016-09-01 00:00:00')->where('entered_at', '<', '2016-10-01 00:00:00')->count()}},
                  {{\App\Models\Student::where('entered_at', '>', '2016-10-01 00:00:00')->where('entered_at', '<', '2016-11-01 00:00:00')->count()}}
                ],
                markPoint: {
                  data: [
                    {type: 'max', name: '最大值'},
                    {type: 'min', name: '最小值'}
                  ]
                },
                markLine: {
                  data: [
                    {type: 'average', name: '平均值'}
                  ]
                }
              }
            ]
          }
        }
      }
    })
  </script>
@endsection