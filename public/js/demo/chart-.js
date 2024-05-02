var chartType = 'bar';
var chart;

// Data bulan
var namaBulan = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGU", "SEP", "OKT", "NOV", "DES"];

// Data jumlah pembelian
var jumlahPembelian = [64400, 59360, 66640, 64400, 62720, 64400, 64400, 66640, 64400, 64400, 64400, 71120];

// Data stok total
var stokTotal = [64400, 59360, 66640, 64400, 62720, 64400, 65800, 68040, 65800, 65800, 65800, 72520];

// Function to create the chart
function createChart() {
  var ctx = document.getElementById("myChart1").getContext("2d");

  chart = new Chart(ctx, {
    type: chartType,
    data: {
      labels: namaBulan,
      datasets: [{
        label: 'Jumlah Pembelian',
        backgroundColor: '#4e73df',
        hoverBackgroundColor: '#2e59d9',
        borderColor: '#4e73df',
        data: jumlahPembelian
      },
      {
        label: 'Stok Total',
        backgroundColor: '#1cc88a',
        hoverBackgroundColor: '#17a673',
        borderColor: '#1cc88a',
        data: stokTotal
      }
      ],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        x: {
          grid: {
            display: false,
            drawBorder: false
          }
        },
        y: {
          ticks: {
            beginAtZero: false,
            padding: 10,
            stepSize: 2000,
            callback: function (value, index, values) {
              return value.toLocaleString('en-US');
            }
          },
          grid: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          },
          min: 58000,
          max: 70000
        }
      },
      legend: {
        display: true
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: 'index',
        caretPadding: 10,
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            var dataValue = tooltipItem.yLabel;
            if (datasetLabel) {
              return datasetLabel + ': ' + dataValue;
            } else {
              return dataValue;
            }
          }
        }
      }
    }
  });
}

// Function to toggle chart type
function toggleChartTypeee1() {
  if (chartType === 'bar') {
    chartType = 'line';
  } else {
    chartType = 'bar';
  }

  if (chart) {
    chart.destroy();
  }

  createChart();
}

// Create initial chart
createChart();
