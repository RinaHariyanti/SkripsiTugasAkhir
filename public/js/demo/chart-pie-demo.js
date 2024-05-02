// Data dalam satuan
var dataSatuan = [64463, 59208, 67441, 64400, 63840, 64400, 66640, 63840, 64400, 64400, 64400, 68880];

// Menghitung total
var total = dataSatuan.reduce(function (previousValue, currentValue) {
  return previousValue + currentValue;
}, 0);

// Mengonversi data menjadi persentase
var dataPersentase = dataSatuan.map(function (value) {
  return ((value / total) * 100).toFixed(1);
});

// Nama bulan
var namaBulan = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sept", "Okt", "Nov", "Des"];

// Warna yang berbeda untuk setiap bulan
var warnaBulan = ['#002eb9', '#006842', '#36b9cc', '#ff6b6b', '#ffd166', '#6ab04c', '#ff9f40', '#5e60ce', '#b56576', '#c3423f', '#f10337', '#48cae4'];

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: namaBulan,
    datasets: [{
      data: dataPersentase,
      backgroundColor: warnaBulan,
      hoverBackgroundColor: warnaBulan.map(function (color) {
        return color.replace(")", ", 0.8)").replace("rgb", "rgba");
      }),
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
      callbacks: {
        label: function (tooltipItem, data) {
          var dataset = data.datasets[tooltipItem.datasetIndex];
          var currentValue = dataset.data[tooltipItem.index];
          var label = data.labels[tooltipItem.index];
          return label + ": " + currentValue + "%";
        }
      }
    },
    legend: {
      display: false
    },
    cutoutPercentage: 0,
  },
});
