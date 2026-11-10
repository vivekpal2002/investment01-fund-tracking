
// Small sparkline chart data (per fund)
let smallChartOptions = {
    chart: {
        type: 'line',
        height: 40,
        sparkline: { enabled: true }
    },
    stroke: { curve: 'smooth', width: 2 },
    series: [{
        name: 'Price',
        data: [123.24, 124.45, 125.83, 148.23, 113.73, 191.33, 110.76] // sample
    }],
    colors: ['#28a745'],
    tooltip: { enabled: false }
};

document.querySelectorAll('.sparkline-chart').forEach((el, idx) => {
    new ApexCharts(el, smallChartOptions).render();
});


// Large Chart
// let largeChartOptions = {
//     chart: {
//         type: 'line',
//         height: 335,
//         toolbar: { show: false }
//     },
//     series: [{
//         name: 'NAV',
//         data: [252.90, 274.44, 256.72, 270.12, 225.18, 249.72, 274.67]
//     }],
//     xaxis: {
//         categories: ["Jul 10", "Jul 11", "Jul 12", "Jul 13", "Jul 14", "Jul 15", "Jul 16"]
//     },
//     stroke: { curve: 'smooth', width: 3 },
//     colors: ['#007bff'],
//     markers: { size: 4 }
// };

// new ApexCharts(document.querySelector("#main-performance-graph"), largeChartOptions).render();

