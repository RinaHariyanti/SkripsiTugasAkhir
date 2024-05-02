// Data stok awal bulan
var sisaBulanLalu = [0, 0, 0, 0, 0, 0, 1400, 1400, 1400, 1400, 1400, 1400];

// Data stok akhir bulan
var sisaBulanIni = [0, 0, 0, 0, 0, 0, 1400, 1400, 1400, 1400, 1400, 1400];

// Nama bulan
var namaBulan = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sept", "Okt", "Nov", "Des"];

// Bar Chart Example
var ctx = document.getElementById("myBarChartSisa2").getContext("2d");
var myBarChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: namaBulan,
    datasets: [{
      label: 'Sisa Bulan Lalu',
      backgroundColor: '#4e73df',
      data: sisaBulanLalu
    },
    {
      label: 'Sisa Bulan Ini',
      backgroundColor: '#1cc88a',
      data: sisaBulanIni
    }],
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
          beginAtZero: true,
          maxTicksLimit: 5,
          padding: 10
        },
        grid: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
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
      xPadding: 40,
      yPadding: 40,
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
