<script>
    import * as VueChartJs from 'vue-chartjs';
    import chartNoDataMixin from '../../mixins/chart-no-data';
    import Chart from "chart.js";

    const {reactiveProp} = VueChartJs.mixins;

    export default {
        name: 'LineChart',
        extends: VueChartJs.Bar,
        mixins: [reactiveProp],
        props: ['chartData', 'options', 'gradientColor', 'currency'],
        data: () => ({
            gradient: null
        }),
        mounted() {
            this.setChartPlugin();
            this.renderLineChart();
        },
        methods: {
            setChartPlugin() {
                this.addPlugin({
                    afterDraw: function (chart, easing) {
                        // No data is present
                        chartNoDataMixin.method.showNoData(chart)
                    }
                })
            },
            renderLineChart() {
                this.options.tooltips.callbacks.label = (tooltipItems, data) => {
                    let label = data.datasets[tooltipItems.datasetIndex].label ? data.datasets[tooltipItems.datasetIndex].label : '';
                    let value = data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] ? data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] : 0;
                    const currency = this.currency ? ' ‎¥' : ' ';
                    return label + currency + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                };
                // Set Gradient background color anf border for datasets
                if (this.gradientColor) {
                    this.gradient = this.$refs.canvas
                        .getContext("2d")
                        .createLinearGradient(0, 0, 0, 450);

                    this.gradient.addColorStop(1, this.gradientColor[0]);
                    this.gradient.addColorStop(1, this.gradientColor[1]);
                    this.gradient.addColorStop(0, this.gradientColor[2]);

                    if (this.data && this.data.datasets && this.data.datasets[0].backgroundColor) {
                        this.data.datasets[0].backgroundColor = this.gradient;
                        this.data.datasets[0].borderColor = this.gradient;
                    }
                }
                this.renderChart(this.chartData, this.options || {})
            }
        }
    }
</script>

<style scoped>

</style>
