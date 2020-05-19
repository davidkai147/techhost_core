export const lineChartOption = {
    title: {
        display: true,
        text: '売上カテゴリ トップ３ 推移'
    },
    legend: {
        position: 'bottom',
        labels: {
            padding: 25,
        },
    },
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        yAxes: [{
            id: "y-axis-1",
            type: "linear",
            position: "left",
            ticks: {
                beginAtZero: true,
                callback: function (label, index, labels) {
                    return '‎¥' + label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                }
            },
            gridLines: {
                display: false
            }
        }],
        xAxes: [{
            gridLines: {
                display: false
            }
        }]
    },
    tooltips: {
        backgroundColor: '#5F6368',
        callbacks: {
            label: (tooltipItems, data) => {
            }
        },
        xPadding: 10
    },
}
