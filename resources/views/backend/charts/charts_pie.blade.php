@extends('backend.charts.index')

@section('title', '图表')
@section('box_title','图表')

@section('charts_data')

  <template id="template">
    <chart :options="chart"></chart>
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
          {value:335, name:'直接访问'},
          {value:310, name:'邮件营销'},
          {value:234, name:'联盟广告'},
          {value:135, name:'视频广告'},
          {value:1548, name:'搜索引擎'}
        ];

        var title = [];
        var length = data.length;

        for(i=0; i< length; i++){
          title.push(data[i].name);
        }

        return {
          chart: {
            title : {
              text: '某站点用户访问来源',
              subtext: '纯属虚构',
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
                name: '访问来源',
                type: 'pie',
                radius : '55%',
                center: ['50%', '50%'],
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
    });


  </script>
@endsection

@section('charts_function')
  <script>
    myChart.on('click', function (params) {
      if (params.seriesType === 'pie') {
        console.log(params.seriesIndex);
        if (params.seriesIndex === 0) {
          var data2 = [
            {value:335, name:'直接访问'},
            {value:310, name:'邮件营销'},
            {value:234, name:'联盟广告'},
            {value:135, name:'视频广告'},
            {value:1548, name:'搜索引擎'}
          ];
//          $.get(url,function(data){
//            data2 = data;
//          });
          myChart.setOption({
            series : [
              {
                name: '访问来源1',
                type: 'pie',
                radius : '55%',
                center: ['25%', '50%']
              },
              {
                name: '访问来源2',
                type: 'pie',
                radius : '55%',
                center: ['75%', '50%'],
                data: data2,
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