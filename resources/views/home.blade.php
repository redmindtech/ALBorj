@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
    <h2>Hello {{$user}}!</h2>
@stop

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <!-- {{-- <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{\App\Models\EmployeeMaster::count()}}</h3>
                    <p>Employees Count</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{url('employeemaster')}}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{\App\Models\ProjectMaster::count()}}</h3>
                    <p>Live Projects</p>

                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{url('employeemaster')}}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{\App\Models\SiteMaster::count()}}</h3>
                    <p>Sites</p>

                </div>
                <div class="icon">
                    <i class="fas fa-city"></i>
                </div>
                <a href="{{url('employeemaster')}}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div> --}} -->

    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <!-- BAR CHART -->
              <div class="card h-100">
                <div class="card-header">
                  <h3 class="card-title text-bold text-center">Accounts</h3>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <!-- DONUT CHART -->
              <div class="card h-100">
                <div class="card-header">
                  <h3 class="card-title text-bold">Profit and Loss</h3>
                </div>
                <div class="card-body">
                  <p style="font-size: 15px; padding: 0%;">Net income in the month of January: <b>AED 10,000.00</b></p>
                  <canvas id="donutChart" style="min-height: 100px; height: 100px; max-height: 100px; max-width: 100%;"></canvas>
                </div>
                <div class="card-body">
                  <p style="font-size: 15px; padding: 0%;">Net income in the year 2023: <b>AED 10,000.00</b></p>
                  <canvas id="horizondalChart" style="min-height: 100px; height: 100px; max-height: 100px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-6">
              <!-- BAR CHART -->
              <div class="card" style="height:200px">
                <div class="card-header">
                  <h3 class="card-title text-bold text-center">Invoice</h3>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="horizontalBarChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
                <!-- BAR CHART -->
                <div class="card" style="height:200px">
                  <div class="card-header">
                    <h3 class="card-title text-bold text-center">Expense</h3>
                  </div>
                  <div class="card-body">
                    <div class="chart">
                      <canvas id="pieChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                </div>
              </div>

          </div>
          <div class="row mt-4">
            <div class="col-md-8">
                <!-- BAR CHART -->
                <div class="card" style="height:400px">
                  <div class="card-header">
                    <h3 class="card-title text-bold text-center">Sales Order</h3>
                  </div>
                  <div class="card-body">
                    <div class="chart">
                      <canvas id="salesorderChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <!-- DONUT CHART -->
                <div class="card h-100">
                  <div class="card-header">
                    <h3 class="card-title text-bold">Projects</h3>
                  </div>
                  <div class="card-body">
                        <ul>
                            <h6 class="text-bold">PROJECTS:</h6>
                              <ul>
                              <li>Ongoing projects: <a href="``````````````````````````````{{ route('ongoing-projects') }}``````````````````````````````">{{ $ApipiechartData[0]->ongoing_pro }}</a></li>
                                <li>Completed projects :{{$complete[0]->complete}}</li>
                                <li>Overall invoice pending amount: AED 10,000.00</li>
                              </ul>
                              <h6 class="text-bold">EMPLOYEES:</h6>
                              <ul>
                                <li>Active employees: {{$emp_active[0]->Working}}</li>
                                <li>Inactive employees:{{$emp_inactive[0]->inactive}}</li>
                                <li>Document expire: {{$visa_date[0]->expiry_date}}</li>
                              </ul>
                              <h6 class="text-bold">PURCHASE:</h6>
                              <ul>
                                <li>Open purchase order: 9</li>
                                <li>Delivery pending: 3</li>
                                <li>Payment pending : 6</li>
                              </ul>
                              <h6 class="text-bold">ACCOUNTS:</h6>
                              <ul>
                                <li>Payable pending amount: AED 19,000.00 (2 Bills)</li>
                                <li>Receivable pending amount: AED 125,000.00 (5 Bills)</li>
                                <li>Advance paid: AED 95,000.00 (3 Bills)</li>
                                <li>Petty cash outward: AED 5,000.00</li>
                                <li>Vat balance as on today: AED 22,000.00</li>
                                <li>Business tax: AED 21,000.00</li>
                              </ul>
                          </ul>

                  </div>
                </div>
              </div>
          </div>
              </div>
          </div>

        </div>

      </section>




<!-- Page specific script -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
  label               : 'Invoice',
  backgroundColor     : 'rgba(255, 99, 132, 0.8)',
  borderColor         : 'rgba(255, 99, 132, 1)',
  pointRadius         : false,
  pointColor          : '#FFFF00',
  pointStrokeColor    : 'rgba(255, 99, 132, 1)',
  pointHighlightFill  : '#0000FF',
  pointHighlightStroke: 'rgba(255, 99, 132, 1)',
  data                : [45, 52, 53, 60, 45, 75, 78]
},
{
  label               : 'Payment',
  backgroundColor     : 'rgba(255, 206, 86, 0.8)',
  borderColor         : 'rgba(255, 206, 86, 1)',
  pointRadius         : false,
  pointColor          : 'rgba(255, 206, 86, 1)',
  pointStrokeColor    : 'rgba(255, 206, 86, 1)',
  pointHighlightFill  : '#0000FF',
  pointHighlightStroke: 'rgba(255, 206, 86, 1)',
  data                : [35, 50, 43, 55, 43, 55, 70]
},
{
  label               : 'Expense',
  backgroundColor     : 'rgba(54, 162, 235, 0.8)',
  borderColor         : 'rgba(54, 162, 235, 1)',
  pointRadius         : false,
  pointColor          : 'rgba(54, 162, 235, 1)',
  pointStrokeColor    : 'rgba(54, 162, 235, 1)',
  pointHighlightFill  : '#0000FF',
  pointHighlightStroke: 'rgba(54, 162, 235, 1)',
  data                : [35, 50, 43, 55, 43, 55, 70]
},
{
  label               : 'Vat',
  backgroundColor     : 'rgba(75, 192, 192, 0.8)',
  borderColor         : 'rgba(75, 192, 192, 1)',
  pointRadius         : false,
  pointColor          : 'rgba(75, 192, 192, 1)',
  pointStrokeColor    : 'rgba(75, 192, 192, 1)',
  pointHighlightFill  : '#0000FF',
  pointHighlightStroke: 'rgba(75, 192, 192, 1)',
  data                : [35, 50, 43, 55, 43, 55, 70]
}


      ]
    }

 //-------------
    // //- DONUT CHART -
    // //-------------


    var horizontalBarChartCanvas = $('#donutChart').get(0).getContext('2d');

var incomeValue = 10000;
var expenseValue = 4500;

var horizontalBarChartData = {
  labels: ['Income', 'Expense'],
  datasets: [
    {
      label: 'Amount',
      backgroundColor: ['rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)'],
      borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
      borderWidth: 1,
      data: [incomeValue, expenseValue]
    }
  ]
};

var horizontalBarChartOptions = {
  scales: {
    xAxes: [{
      ticks: {
        beginAtZero: true
      }
    }]
  }
};

new Chart(horizontalBarChartCanvas, {
  type: 'horizontalBar',
  data: horizontalBarChartData,
  options: horizontalBarChartOptions
});



    //horizondalchart
    var horizontalBarChartCanvas = $('#horizondalChart').get(0).getContext('2d');

var incomeValue = 10000;
var expenseValue = 4500;

var horizontalBarChartData = {
  labels: ['Income', 'Expense'],
  datasets: [
    {
      label: 'Amount',
      backgroundColor: ['rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)'],
      borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
      borderWidth: 1,
      data: [incomeValue, expenseValue]
    }
  ]
};

var horizontalBarChartOptions = {
  scales: {
    xAxes: [{
      ticks: {
        beginAtZero: true
      }
    }]
  }
};

new Chart(horizontalBarChartCanvas, {
  type: 'horizontalBar',
  data: horizontalBarChartData,
  options: horizontalBarChartOptions
});

//invoice

var horizontalBarChartCanvas = $('#horizontalBarChart').get(0).getContext('2d');

var receivedValueMonth = 7500;
var yetReceivedValueMonth = 2500;
var receivedValueThisMonth = 6000;
var yetReceivedValueThisMonth = 2000;


var horizontalBarChartData = {
  labels: ['This Month', '3Months(PDC)'],
  datasets: [
    {
      label: 'Received',
      backgroundColor: 'rgba(54, 162, 235, 0.8)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1,
      data: [receivedValueMonth, receivedValueThisMonth]
    },
    {
      label: 'Yet Received',
      backgroundColor: 'rgba(255, 99, 132, 0.8)',
      borderColor: 'rgba(255, 99, 132, 1)',
      borderWidth: 1,
      data: [yetReceivedValueMonth, yetReceivedValueThisMonth]
    }
  ]
};


var horizontalBarChartOptions = {
  scales: {
    xAxes: [{
      stacked: true,
      ticks: {
        beginAtZero: true
      }
    }],
    yAxes: [{
      stacked: true
    }]
  }
};

new Chart(horizontalBarChartCanvas, {
  type: 'horizontalBar',
  data: horizontalBarChartData,
  options: horizontalBarChartOptions
});


//pie chart
var pieChartCanvas = $('#pieChart').get(0).getContext('2d');

var expenseData = @json($expenseData);

var pieChartOptions = @json($pieChartOptions);

new Chart(pieChartCanvas, {
    type: 'pie',
    data: expenseData,
    options: pieChartOptions
});
//sales
var salesChartCanvas = $('#salesorderChart').get(0).getContext('2d');

var salesData = {
  labels: ['January', 'February', 'March', 'April', 'May', 'June'],
  datasets: [
    {
      label: '2021',
      data: [70000, 60000, 80000, 75000, 90000, 100000],
      borderColor: 'rgba(255, 99, 132, 1)',
      backgroundColor: 'rgba(255, 99, 132, 0.2)',
      borderWidth: 2
    },
    {
      label: '2022',
      data: [40000, 55000, 70000, 60050, 80000, 95000],
      borderColor: 'rgba(255, 206, 86, 1)',
      backgroundColor: 'rgba(255, 206, 86, 0.2)',
      borderWidth: 2
    },
    {
      label: '2023',
      data: [60000, 70050, 90000, 85000, 100590, 110000],
      borderColor: 'rgba(75, 192, 192, 1)',
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
      borderWidth: 2
    }
  ]
};

var salesOptions = {
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    y: {
      beginAtZero: true
    }
  }
};

new Chart(salesChartCanvas, {
  type: 'line',
  data: salesData,
  options: salesOptions
});


//-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //

    //-------------
    //- SALES BAR CHART -
    //-------------

    var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
    }

    var mode = 'index'
    var intersect = true
    var $salesChart = $('#sales-chart')
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart($salesChart, {
      type: 'bar',
      data: {
        labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
          },
          {
            backgroundColor: '#ced4da',
            borderColor: '#ced4da',
            data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function (value) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'k'
                }

                return '$' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })


    //-------------
    //- GRADIENT BAR CHART -
    //-------------
    var root = am5.Root.new("chartdiv");
    root.setThemes([
      am5themes_Animated.new(root)
    ]);

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(am5xy.XYChart.new(root, {
      panX: false,
      panY: false,
      wheelX: "panX",
      wheelY: "zoomX",
      layout: root.verticalLayout
    }));

    // Data
    var colors = chart.get("colors");

    var data = [
      {
      country: "US",
      visits: 725,
      icon: "",
      columnSettings: { fill: colors.next() }
    }, {
      country: "UK",
      visits: 625,
      icon: "",
      columnSettings: { fill: colors.next() }
    }, {
      country: "China",
      visits: 602,
      icon: "",
      columnSettings: { fill: colors.next() }
    }, {
      country: "Japan",
      visits: 509,
      icon: "",
      columnSettings: { fill: colors.next() }
    }, {
      country: "Germany",
      visits: 322,
      icon: "",
      columnSettings: { fill: colors.next() }
    }, {
      country: "France",
      visits: 214,
      icon: "",
      columnSettings: { fill: colors.next() }
    }, {
      country: "India",
      visits: 204,
      icon: "",
      columnSettings: { fill: colors.next() }
    }, {
      country: "Spain",
      visits: 198,
      icon: "",
      columnSettings: { fill: colors.next() }
    }, {
      country: "Netherlands",
      visits: 165,
      icon: "",
      columnSettings: { fill: colors.next() }
    }, {
      country: "South Korea",
      visits: 93,
      icon: "",
      columnSettings: { fill: colors.next() }
    }, {
      country: "Canada",
      visits: 41,
      icon: "",
      columnSettings: { fill: colors.next() }
    }];

    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xRenderer = am5xy.AxisRendererX.new(root, {
      minGridDistance: 30
    })

    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
      categoryField: "country",
      renderer: xRenderer,
      bullet: function(root, axis, dataItem) {
        return am5xy.AxisBullet.new(root, {
          location: 0.5,
          sprite: am5.Picture.new(root, {
            width: 24,
            height: 24,
            centerY: am5.p50,
            centerX: am5.p50,
            src: dataItem.dataContext.icon
          })
        });
      }
    }));

    xRenderer.grid.template.setAll({
      location: 1
    })

    xRenderer.labels.template.setAll({
      paddingTop: 20
    });

    xAxis.data.setAll(data);

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
      renderer: am5xy.AxisRendererY.new(root, {
        strokeOpacity: 0.1
      })
    }));

    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
      xAxis: xAxis,
      yAxis: yAxis,
      valueYField: "visits",
      categoryXField: "country"
    }));

    series.columns.template.setAll({
      tooltipText: "{categoryX}: {valueY}",
      tooltipY: 0,
      strokeOpacity: 0,
      templateField: "columnSettings"
    });

    series.data.setAll(data);

    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear();
    chart.appear(1000, 100);
  })


  //-------------
  //- CIRCLE LINE CHART -
  //-------------

  var root = am5.Root.new("circle-chartdiv");

  // Set themes
  // https://www.amcharts.com/docs/v5/concepts/themes/
  root.setThemes([
    am5themes_Animated.new(root)
  ]);

  // Create chart
  // https://www.amcharts.com/docs/v5/charts/radar-chart/
  var chart = root.container.children.push(am5radar.RadarChart.new(root, {
    panX: false,
    panY: false,
    wheelX: "panX",
    wheelY: "zoomX",
    innerRadius: am5.percent(20),
    startAngle: -90,
    endAngle: 180
  }));


  // Data
  var data = [{
    category: "Research",
    value: 80,
    full: 100,
    columnSettings: {
      fill: chart.get("colors").getIndex(0)
    }
  }, {
    category: "Marketing",
    value: 35,
    full: 100,
    columnSettings: {
      fill: chart.get("colors").getIndex(1)
    }
  }, {
    category: "Distribution",
    value: 92,
    full: 100,
    columnSettings: {
      fill: chart.get("colors").getIndex(2)
    }
  }, {
    category: "Human Resources",
    value: 68,
    full: 100,
    columnSettings: {
      fill: chart.get("colors").getIndex(3)
    }
  }];

  // Add cursor
  // https://www.amcharts.com/docs/v5/charts/radar-chart/#Cursor
  var cursor = chart.set("cursor", am5radar.RadarCursor.new(root, {
    behavior: "zoomX"
  }));

  cursor.lineY.set("visible", false);

  // Create axes and their renderers
  // https://www.amcharts.com/docs/v5/charts/radar-chart/#Adding_axes
  var xRenderer = am5radar.AxisRendererCircular.new(root, {
    //minGridDistance: 50
  });

  xRenderer.labels.template.setAll({
    radius: 10
  });

  xRenderer.grid.template.setAll({
    forceHidden: true
  });

  var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
    renderer: xRenderer,
    min: 0,
    max: 100,
    strictMinMax: true,
    numberFormat: "#'%'",
    tooltip: am5.Tooltip.new(root, {})
  }));


  var yRenderer = am5radar.AxisRendererRadial.new(root, {
    minGridDistance: 20
  });

  yRenderer.labels.template.setAll({
    centerX: am5.p100,
    fontWeight: "500",
    fontSize: 18,
    templateField: "columnSettings"
  });

  yRenderer.grid.template.setAll({
    forceHidden: true
  });

  var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
    categoryField: "category",
    renderer: yRenderer
  }));

  yAxis.data.setAll(data);


  // Create series
  // https://www.amcharts.com/docs/v5/charts/radar-chart/#Adding_series
  var series1 = chart.series.push(am5radar.RadarColumnSeries.new(root, {
    xAxis: xAxis,
    yAxis: yAxis,
    clustered: false,
    valueXField: "full",
    categoryYField: "category",
    fill: root.interfaceColors.get("alternativeBackground")
  }));

  series1.columns.template.setAll({
    width: am5.p100,
    fillOpacity: 0.08,
    strokeOpacity: 0,
    cornerRadius: 20
  });

  series1.data.setAll(data);


  var series2 = chart.series.push(am5radar.RadarColumnSeries.new(root, {
    xAxis: xAxis,
    yAxis: yAxis,
    clustered: false,
    valueXField: "value",
    categoryYField: "category"
  }));

  series2.columns.template.setAll({
    width: am5.p100,
    strokeOpacity: 0,
    tooltipText: "{category}: {valueX}%",
    cornerRadius: 20,
    templateField: "columnSettings"
  });

  series2.data.setAll(data);

  // Animate chart and series in
  // https://www.amcharts.com/docs/v5/concepts/animations/#Initial_animation
  series1.appear(1000);
  series2.appear(1000);
  chart.appear(1000, 100);
</script>
<style>
  #chartdiv{
        width: 100%;
        height: 500px;
    }
  #circle-chartdiv {
  width: 100%;
  height: 500px;
}
.card-body{
    padding: 0.25rem;

}

</style>
@stop