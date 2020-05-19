export const dataLineChartAllShopLast3M = {
    labels: [],
    datasets: [
        {
            currency: true,
            label: '売上額',
            type: 'line',
            fill: true,
            lineTension: 0.4,
            data: [],
            borderWidth: 0,
            backgroundColor: 'rgba(254,97,132,0.1)',
            labelColor: 'rgba(0,71,230,0.5)',
            yAxisID: 'y-axis-1'
        },
        {
            currency: false,
            label: '商品数',
            type: 'line',
            fill: true,
            lineTension: 0.4,
            data: [],
            borderWidth: 0,
            backgroundColor: 'rgba(54,164,235,0.1)',
            labelColor: 'rgba(38,153,251,0.5)',
            yAxisID: 'y-axis-2'
        }
    ]
}

export const gradientColor = [
    [
        {opacity: 0, color: 'rgba(0,71,230,0.5)'},
        {opacity: 0.6, color: 'rgba(15,80,227,0.5)'},
        {opacity: 1, color: 'rgba(15,80,227,0.2)'}
    ],
    [
        {opacity: 0, color: 'rgba(38,153,251,0.5)'},
        {opacity: 1, color: 'rgba(255,255,255,0.5)'},
    ]
]

export const chartInterface3MGradient = () => {
    let gradient = []

    // set is Gradient Chart
    dataLineChartAllShopLast3M.isGradient = true

    const dataSize = dataLineChartAllShopLast3M.datasets.length

    for (let i = 0; i < dataSize; i++) {
        gradient[i] = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 300)

        for (let j = 0; j < gradientColor[i].length; j++) {
            gradient[i].addColorStop(gradientColor[i][j].opacity, gradientColor[i][j].color)
        }

        dataLineChartAllShopLast3M.datasets[i].backgroundColor = gradient[i]
        dataLineChartAllShopLast3M.datasets[i].borderColor = gradient[i]
        dataLineChartAllShopLast3M.datasets[i].pointBackgroundColor = gradient[i]
    }

    gradient = null

    return dataLineChartAllShopLast3M
}
