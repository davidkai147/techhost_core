export const barChartOption = {
    linearGradientLine: true,
    showAllValue: true,
    scales: {
        xAxes: [{
            id: "x-axis-0",
            type: "linear",
            position: "right",
            ticks: {
                beginAtZero: true
            },
            gridLines: {
                display: false
            }
        }],
        yAxes: [{
            id: 'y-axis-0',
            barPercentage: 1,
            gridLines: {
                display: false
            }
        }]
    },
    tooltips: {
        enabled: false,
        callbacks: {
            label: (tooltipItems, data) => {
                let label = data.datasets[tooltipItems.datasetIndex].label ? data.datasets[tooltipItems.datasetIndex].label : '';
                let value = data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] ? data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] : 0;
                const currency = data.datasets[tooltipItems.datasetIndex].currency ? ' ‎¥' : ' ';
                return label + currency + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
        },
    },
    legend: {
        display: false
    },
    responsive: true,
    maintainAspectRatio: false,
    annotation: {},
    hover: {
        animationDuration: 1000, // duration of animations when hovering an item
    }
}

/**
 * Define vertical chart for sales & product
 * @type {{annotation: {}, hover: {animationDuration: number}, legend: {display: boolean, position: string}, scales: {yAxes: [{ticks: {callback: function(*, *, *): string, beginAtZero: boolean}, gridLines: {display: boolean}, id: string, position: string}, {ticks: {callback: function(*, *, *): *, beginAtZero: boolean}, gridLines: {display: boolean}, id: string, position: string}], xAxes: [{gridLines: {display: boolean}}, {display: boolean, gridLines: {display: boolean}}]}, responsive: boolean, tooltips: {callbacks: {label: (function(*, *): string)}, enabled: boolean}, maintainAspectRatio: boolean}}
 */
export const barChartOptionVertical = {
    scales: {
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
            }
        ],
        yAxes: [
            {
                id: 'y-axis-1',
                position: 'left',
                ticks: {
                    beginAtZero: true,
                    callback: function (label, index, labels) {
                        return '‎¥' + label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                    }
                },
                gridLines: {
                    display: false
                }
            },
            {
                id: 'y-axis-2',
                position: 'right',
                gridLines: {
                    display: false
                },
                ticks: {
                    beginAtZero: true,
                    callback: function (label, index, labels) {
                        return label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                    }
                }
            }
        ]
    },
    tooltips: {
        enabled: true,
        intersect: false,
        callbacks: {
            label: (tooltipItems, data) => {
                let label = data.datasets[tooltipItems.datasetIndex].label ? data.datasets[tooltipItems.datasetIndex].label : '';
                let value = data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] ? data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] : '';

                const currency = data.datasets[tooltipItems.datasetIndex].currency ? ' ‎¥' : ' ';
                return label + currency + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
        }
    },
    legend: {
        display: true,
        position: 'bottom'
    },
    responsive: true,
    maintainAspectRatio: false,
    annotation: {},
    hover: {
        animationDuration: 1000 // duration of animations when hovering an item
    }
}
