$(function () {


  // =====================================
  // Profit
  // =====================================
  var chart = {
    series: [
      { name: "Earnings this month:", data: [355, 390, 300, 350, 390, 180, 355, 390] },
      { name: "Expense this month:", data: [280, 250, 325, 215, 250, 310, 280, 250] },
    ],

    chart: {
      type: "bar",
      height: 350,
      offsetX: -15,
      toolbar: { show: false },
      foreColor: "#adb0bb",
      fontFamily: 'inherit',
      sparkline: { enabled: false },
    },


    colors: ["#5D87FF", "#49BEFF"],


    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "35%",
        borderRadius: [6],
        borderRadiusApplication: 'end',
        borderRadiusWhenStacked: 'all'
      },
    },
    markers: { size: 0 },

    dataLabels: {
      enabled: false,
    },


    legend: {
      show: false,
    },


    grid: {
      borderColor: "rgba(0,0,0,0.1)",
      strokeDashArray: 3,
      xaxis: {
        lines: {
          show: false,
        },
      },
    },

    xaxis: {
      type: "category",
      categories: ["16/08", "17/08", "18/08", "19/08", "20/08", "21/08", "22/08", "23/08"],
      labels: {
        style: { cssClass: "grey--text lighten-2--text fill-color" },
      },
    },


    yaxis: {
      show: true,
      min: 0,
      max: 400,
      tickAmount: 4,
      labels: {
        style: {
          cssClass: "grey--text lighten-2--text fill-color",
        },
      },
    },
    stroke: {
      show: true,
      width: 3,
      lineCap: "butt",
      colors: ["transparent"],
    },


    tooltip: { theme: "light" },

    responsive: [
      {
        breakpoint: 600,
        options: {
          plotOptions: {
            bar: {
              borderRadius: 3,
            }
          },
        }
      }
    ]


  };

  var chart = new ApexCharts(document.querySelector("#chart"), chart);
  chart.render();


  // =====================================
  // Breakup
  // =====================================
  var breakup = {
    color: "#adb5bd",
    series: [38, 40, 25],
    labels: ["2022", "2021", "2020"],
    chart: {
      height: 300,
      width:250,
      type: "donut",
      fontFamily: "Plus Jakarta Sans', sans-serif",
      foreColor: "#adb0bb",
    },
    plotOptions: {
      pie: {
        startAngle: 0,
        endAngle: 360,
        donut: {
          size: '75%',
        },
      },
    },
    stroke: {
      show: false,
    },

    dataLabels: {
      enabled: false,
    },

    legend: {
      show: false,
    },
    colors: ["#5D87FF", "#ecf2ff", "#F9F9FD"],

    responsive: [
      {
        breakpoint: 991,
        options: {
          chart: {
            width: 150,
          },
        },
      },
    ],
    tooltip: {
      theme: "dark",
      fillSeriesColor: false,
    },
  };

  var chart = new ApexCharts(document.querySelector("#breakup"), breakup);
  chart.render();



  // =====================================
  // Earning
  // =====================================
  var earning = {

    chart: {
      id: "sparkline3",
      type: "area",
      height: 0,
      sparkline: {
        enabled: true,
      },
      group: "sparklines",
      fontFamily: "Plus Jakarta Sans', sans-serif",
      foreColor: "#adb0bb",
    },
    series: [
      {
        name: "Earnings",
        color: "#49BEFF",
        data: [25, 66, 20, 40, 12, 58, 20],
      },
    ],
    stroke: {
      curve: "smooth",
      width: 2,
    },
    fill: {
      colors: ["#f3feff"],
      type: "solid",
      opacity: 0.05,
    },

    markers: {
      size: 0,
    },
    tooltip: {
      theme: "dark",
      fixed: {
        enabled: true,
        position: "right",
      },
      x: {
        show: false,
      },
    },
  };
  new ApexCharts(document.querySelector("#earning"), earning).render();
  function renderMiniBarChart(selector, data, color = "#49BEFF") {
    let options = {
        chart: {
            type: "bar",
            height: 80,
            toolbar: { show: false },
            sparkline: { enabled: true },
            fontFamily: "Plus Jakarta Sans, sans-serif",
            foreColor: "#adb0bb",
        },
        series: [{
            name: "Earnings",
            color: color,
            data: data
        }],
        stroke: { curve: "smooth", width: 2 },
        fill: {
            colors: ["#f3feff"],
            type: "solid",
            opacity: 0.8,
        },
        markers: { size: 0 },
        tooltip: {
            theme: "dark",
            fixed: { enabled: true, position: "right" },
            x: { show: false }
        },
    };

    let chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
}
let balanceData   = [25, 66, 20, 40, 12, 58, 20];
let monthlyData   = [15, 45, 35, 50, 22, 38, 60];
let savingData    = [10, 20, 30, 25, 35, 40, 45];
let incomeData    = [40, 55, 65, 70, 50, 80, 90];

// ✅ Render charts into widgets
renderMiniBarChart("#bar_column", balanceData, "#49BEFF");
renderMiniBarChart("#bar_column_1", monthlyData, "#FF6B6B");
renderMiniBarChart("#bar_column_2", savingData, "#4CAF50");
renderMiniBarChart("#bar_column_3", incomeData, "#FF9800");



})
document.addEventListener('DOMContentLoaded', function () {

  // ==============================
  // 📅 FullCalendar
  // ==============================
  var calendarEl = document.getElementById('calendar');

  if (calendarEl) { // ✅ Prevent error if #calendar is not on page
      if (typeof isAuthenticated !== "undefined" && !isAuthenticated) {
          // User is not authenticated
          var calendar = new FullCalendar.Calendar(calendarEl, {
              initialView: 'dayGridMonth'
          });
          calendar.render();
      } else {
          // User is authenticated
          var calendar = new FullCalendar.Calendar(calendarEl, {
              initialView: 'dayGridMonth',
              events: '/api/expenses/by-date', // JSON route
              eventClick: function (info) {
                  alert('You spent on ' + info.event.startStr + ': ' + info.event.title);
              }
          });
          calendar.render();
      }
  }

  // ==============================
  // 📊 Budget Chart (Chart.js)
  // ==============================
  const canvas = document.getElementById('overallBudgetChart');


  if (canvas) { // ✅ Prevent error if #overallBudgetChart is missing
      const budgets = JSON.parse(canvas.dataset.budgets);

      const labels = budgets.map(b => b.name);
      const spentData = budgets.map(b => b.spent);
      const remainingData = budgets.map(b => b.budget);

      new Chart(canvas, {
          type: 'bar',
          data: {
              labels: labels,
              datasets: [
                  { label: 'Spent', data: spentData, backgroundColor: '#f87171' },
                  { label: 'Remaining', data: remainingData, backgroundColor: '#34d399' }
              ]
          },
          options: {
              responsive: true,
              scales: {
                  y: { beginAtZero: true }
              }
          }
      });
  }
});



