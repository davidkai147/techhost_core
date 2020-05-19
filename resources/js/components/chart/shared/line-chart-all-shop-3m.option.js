export const optionLineChartAllShopLast3M = {
    linearGradientLine: true,
    showAllTooltips: false,
    responsive: true,
    maintainAspectRatio: false,
    title: {
        display: true,
        text: '売上額と売上商品数の推移',
    },
    legend: {
        position: 'bottom',
        labels: {
            padding: 10
        }
    },
    events: ['mousemove', 'mouseout', 'click', 'touchstart', 'touchmove'],
    tooltips: {
        backgroundColor: '#5F6368',
        callbacks: {
            label: (tooltipItems, data) => {
                let label = data.datasets[tooltipItems.datasetIndex].label ? data.datasets[tooltipItems.datasetIndex].label : '';
                let value = data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] ? data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] : 0;
                const currency = data.datasets[tooltipItems.datasetIndex].currency ? ' ‎¥' : ' ';
                return label + currency + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
        },
        xPadding: 10
    },
    scales: {
        yAxes: [
            {
                id: "y-axis-1",
                type: 'linear',
                position: 'left',
                ticks: {
                    beginAtZero: true,
                    callback: function (label, index, labels) {
                        return '‎¥' + label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                    },
                },
                gridLines: {
                    display: false
                }
            }, {
                id: "y-axis-2",
                type: 'linear',
                position: 'right',
                ticks: {
                    beginAtZero: true,
                    callback: function (label, index, labels) {
                        return label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                    },
                },
                gridLines: {
                    display: false
                }
            }],
        xAxes: [
            {
                gridLines: {
                    display: false
                }
            },
            {
                display: false,
                gridLines: {
                    display: false
                }
            }]
    },
}
