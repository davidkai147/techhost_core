<script>
    // import { HorizontalBar, mixins } from "vue-chartjs";
    import * as VueChartJs from 'vue-chartjs';
    import Chart from "chart.js";
    import chartNoDataMixin from '../../mixins/chart-no-data';

    const {reactiveProp} = VueChartJs.mixins;

    export default {
        extends: VueChartJs.HorizontalBar,
        mixins: [reactiveProp],
        props: ["chartData", "options", 'gradientColor', 'drawAverage', 'averageVal', 'currency', 'data'],
        data: () => ({
            gradient: null
        }),
        mounted() {
            this.setChartPlugin();
            this.renderMixedChart();
        },
        methods: {
            setChartPlugin() {
                this.addPlugin({
                    beforeDatasetsUpdate: function (chart) {
                        if (chart.config.options.linearGradientLine) {
                            var xScale = chart.scales["x-axis-0"];
                            const ctx = chart.ctx;
                            chart.config.data.datasets.forEach((dataset) => {
                                var gradients = [];
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var pxValue = xScale.getPixelForValue(dataset.data[i])

                                    var gradient = ctx.createLinearGradient(0, 0, pxValue, 0);
                                    gradient.addColorStop(0, 'rgba(38,153,251,0.25)');
                                    gradient.addColorStop(1, '#2699FB');

                                    gradients.push(gradient);
                                }
                                dataset.backgroundColor = gradients;
                            });
                        }
                    },
                    afterDraw: (chart, easing) => {
                        if (chart.config.options.showAllValue) {
                            const ctx = chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';


                            chart.config.data.datasets.forEach((dataset) => {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    if (dataset.hidden === true && dataset._meta[Object.keys(dataset._meta)[0]].hidden !== false) {
                                        continue;
                                    }
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                        scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._xScale.maxWidth;
                                    var x_pos = model.x + 30;
                                    ctx.fillStyle = "#5F6368";
                                    // Make sure data value does not get overflown and hidden
                                    // when the bar's value is too close to max value of scale
                                    // Note: The y value is reverse, it counts from top down
                                    if ((scale_max - model.x) / scale_max <= 0.50 && model.x > 150) {
                                        x_pos = model.x - 30;
                                        ctx.fillStyle = "#ffffff";
                                    }

                                    // Check if different the line to render the value
                                    if (!(typeof dataset.data[i] === 'object')) {
                                        let val = this.currency ? '‎¥' + dataset.data[i] : dataset.data[i];
                                        ctx.fillText(val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','), x_pos, model.y + 7);
                                    }

                                }
                            });
                        }

                        // No data is present
                        chartNoDataMixin.method.showNoData(chart)
                    },
                    beforeUpdate: function (chart) {
                    }
                })
            },
            renderMixedChart() {
                this.options.scales.xAxes[0].ticks.callback = (label, index, labels) => {
                    const labelTmp = label || label === 0 ? label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') : '';
                    const currency = this.currency ? '‎¥' : '';
                    return currency + labelTmp;
                };
                this.options.tooltips.callbacks.label = (tooltipItems, data) => {
                    const currency = this.currency ? '‎¥' : '';
                    return currency + data.labels[tooltipItems.index] + ' ' + data.datasets[0].data[tooltipItems.index].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                };
                // Draw average line
                this.options.annotation = {};
                if (this.drawAverage && this.options) {
                    this.options.annotation = {
                        annotations: [
                            {
                                type: 'line',
                                mode: 'vertical',
                                scaleID: 'x-axis-0',
                                value: this.averageVal,
                                borderColor: 'orange',
                                borderWidth: 2
                            },
                        ],
                    }
                }

                this.renderChart(this.chartData, this.options);
            }
        },
        watch: {
            chartData: function () {
                //this._data._chart.destroy();
                //this.renderChart(this.data, this.options);
                this.renderMixedChart();
            }
        }
    };
</script>
