@extends('backend.charts.index')

@section('title', '图表')
@section('box_title','图表')

@section('charts_data')

  <template id="template">
    <chart :options="pie"></chart>
  </template>

  <style>
    .echarts {
      width: 100%;
      height: 500px;
    }
  </style>

  <script>

    var data = {
      phases: [
        @foreach($phases as $phase)
        {value:{{$phase->play_count}}, name: '{{$phase->title}}'},
        @endforeach
      ],
      course: {
        @foreach($phases as $phase)
        '{{$phase->title}}': [
                @foreach($phase->thyroidClassCourses as $course)
                    {value:{{$course->play_count}}, name: '{{$course->title.$course->sequence}}'},
                @endforeach
        ],
        @endforeach
      }
    };

    Vue.component('echart', {
      template: '#template',
      data: function () {

        return {
          pie: {
            title: {
              text: '甲状腺公开课',
              subtext: '课程统计',
              x: 'center'
            },
            tooltip: {
              trigger: 'item',
              formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
//            legend: {
//              orient: 'vertical',
//              left: 'left',
//              data: title
//            },
            series: [
              {
                name: '课程统计',
                type: 'pie',
                radius: '55%',
                center: ['50%', '60%'],
                data: data.phases,
                itemStyle: {
                  emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                  }
                }
              }
            ]
          }
        }
      }
    })
  </script>
@endsection

@section('charts_function')
  <script>
    myChart.on('click', function (params) {
      if (params.seriesType === 'pie') {
        console.log(params.seriesIndex);
        if (params.seriesIndex === 0) {
          myChart.setOption({
            series: [
              {
                center: ['25%', '50%']
              },
              {
                name: '访问来源2',
                type: 'pie',
                radius: '55%',
                center: ['75%', '50%'],
                data: data[params.name],
                itemStyle: {
                  emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                  }
                }
              }
            ]
          })
        }
      }

    });
  </script>
@endsection