@extends('admin::backend.charts.index')

@section('title', '图表')
@section('box_title','图表')

@if (Auth::guest())
@else
  @include('admin::backend.layouts.aside')
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
              text: '学员统计',
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
                data: [
                  @foreach($data['date'] as $val)
                  '{{$val}}',
                  @endforeach
                ]
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
                  @foreach($data['register'] as $val)
                  {{$val}},
                  @endforeach
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
                  @foreach($data['sign'] as $val)
                  {{$val}},
                  @endforeach
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