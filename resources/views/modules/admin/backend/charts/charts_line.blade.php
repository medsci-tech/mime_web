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
    var data = {
      time: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'],
      average: [120, 132, 101, 134, 90, 230, 210, 120, 132, 101, 134, 90, 230, 210, 120, 132, 101, 134, 90, 230, 210, 90, 230, 210, 120],
      today: [100, 52, 71, 204, 120, 50, 180, 100, 52, 71, 204]
    };

    Vue.component('echart', {
      template: '#template',
      data: function () {

        return {
          chart: {
            title: {
              text: '堆叠区域图'
            },
            tooltip: {
              trigger: 'axis'
            },
            legend: {
              data: ['总平均数', '当日']
            },
            toolbox: {
              feature: {
                mark: {show: true},
                dataView: {show: true, readOnly: true},
                magicType: {show: true, type: ['bar']},
                restore: {show: true},
                saveAsImage: {}
              }
            },
            grid: [{
              left: '3%',
              right: '4%',
              bottem: '5%'
            }],
            xAxis: [
              {
                type: 'category',
                boundaryGap: false,
                data: data.time,
              }
            ],
            yAxis: [
              {
                type: 'value'
              }
            ],
            smooth: true,
            sampling: 'average',
            series: [
              {
                name: '总平均数',
                type: 'line',
                smooth: true,
                areaStyle: {normal: {}},
                data: data.average
              }, {
                name: '当日',
                type: 'line',
                smooth: true,
                areaStyle: {normal: {}},
                data: data.today
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
      console.log(params.seriesIndex);
    });
  </script>
@endsection