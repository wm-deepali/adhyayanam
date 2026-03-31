//[Dashboard Javascript]

//Project:	edulearn - Responsive Admin Template
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

  'use strict';

  $('.countnm').each(function () {
    $(this).prop('Counter', 0).animate({
      Counter: $(this).text()
    }, {
      duration: 5000,
      easing: 'swing',
      step: function (now) {
        $(this).text(Math.ceil(now));
      }
    });
  });

  //Date range as a button
  $('#daterange-btn').daterangepicker(
    {
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate: moment()
    },
    function (start, end) {
      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    }
  );


  var options = {
    series: [{
      name: "Progress",
      data: monthlyProgress
    }],
    chart: {
      height: 157,
      type: 'area',
      toolbar: { show: false },
      zoom: { enabled: false }
    },
    colors: ['#019ff8'],
    stroke: {
      curve: 'smooth',
      width: 3
    },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yaxis: {
      labels: {
        formatter: function (val) {
          return val + "%";
        }
      }
    }
  };

  new ApexCharts(document.querySelector("#charts_widget_2_chart"), options).render();


  var colors = [
    '#019ff8',
    '#733aeb',
    '#58baab',
    '#f2426d',
    '#fec801'
  ]

  var options = {
    series: [{
      name: "Performance",
      data: testScores
    }],
    chart: {
      height: 244,
      type: 'bar',
      toolbar: { show: false }
    },
    plotOptions: {
      bar: {
        columnWidth: '35%',
        distributed: true,
      }
    },
    xaxis: {
      categories: testNames
    }
  };

  new ApexCharts(document.querySelector("#performance_chart"), options).render();
  var options = {
    series: passData,
    chart: {
      type: 'donut',
    },
    labels: ["Passed", "Failed"],
    dataLabels: {
      enabled: false
    },
    legend: {
      position: 'bottom',
      horizontalAlign: 'center',
    },
    colors: ['#28a745', '#dc3545'], // green & red
    responsive: [{
      breakpoint: 1500,
      options: {
        chart: {
          width: 250,
        },
      }
    }]
  };

  new ApexCharts(document.querySelector("#pass_chart"), options).render();
  


  var options = {
    series: [{
      name: "Tests Given",
      data: usageData
    }],
    chart: {
      height: 168,
      type: 'line',
      toolbar: { show: false }
    },
    stroke: { width: 3 },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    }
  };

  new ApexCharts(document.querySelector("#usage_chart"), options).render();

  $('.act-div').slimScroll({
    height: '337px'
  });


}); // End of use strict
