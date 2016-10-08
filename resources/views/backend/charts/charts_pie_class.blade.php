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
    Vue.component('echart', {
      template: '#template',
      data: function () {

        var data = [
                @foreach($phases as $phase)
                  @foreach($phase->thyroidClassCourses as $course)
                    {value:{{$course->play_count}}, name:'{{$course->title}}'},
                  @endforeach
                @endforeach

//          {value:310, name:'邮件营销'},
//          {value:234, name:'联盟广告'},
//          {value:135, name:'视频广告'},
//          {value:1548, name:'搜索引擎'}
        ];

        var title = [];
        var length = data.length;

        for(i=0; i< length; i++){
          title.push(data[i].name);
        }

        return {
          pie: {
            title : {
              text: '甲状腺公开课',
              subtext: '课程统计',
              x:'center'
            },
            tooltip : {
              trigger: 'item',
              formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
//            legend: {
//              orient: 'vertical',
//              left: 'left',
//              data: title
//            },
            series : [
              {
                name: '课程统计',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:data,
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