export const barChartData = {
    labels: [],
    datasets: [
        {
            borderColor: "rgba(255,255,255,1)",
            borderWidth: 0,
            backgroundColor: "rgba(54,164,235,0.5)",
            data: []
        }
    ]
};

export const barChartSaleProductData = {
    labels: [],
    datasets: [
        {
            currency: true,
            label: '売上額',
            borderColor: 'rgba(255,255,255,1)',
            borderWidth: 0,
            backgroundColor: 'rgba(0,71,230,0.5)',
            data: [],
            yAxisID: 'y-axis-1'
        },
        {
            currency: false,
            label: '商品数',
            borderColor: 'rgba(255,255,255,1)',
            borderWidth: 0,
            backgroundColor: 'rgba(38,153,251,0.5)',
            data: [],
            yAxisID: 'y-axis-2'
        }
    ]
}
