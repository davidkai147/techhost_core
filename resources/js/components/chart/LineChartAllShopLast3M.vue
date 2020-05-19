<script>
    import * as VueChartJs from 'vue-chartjs';
    import Chart from "chart.js";
    import chartNoDataMixin from "../../mixins/chart-no-data";

    const {reactiveProp} = VueChartJs.mixins;

    export default {
        name: 'LineChart',
        extends: VueChartJs.Bar,
        mixins: [reactiveProp],
        props: ['chartData', 'options', 'gradientColor', 'name'],
        data: () => ({
            gradient: []
        }),
        mounted: function () {
            // add config Show All tooltips
            this.setChartPlugin();
            this.renderLineChart();
        },
        methods: {
            setChartPlugin() {
                this.addPlugin({
                    beforeRender: function (chart) {
                        if (chart.config.options.showAllTooltips) {
                            // create an array of tooltips
                            // we can't use the chart tooltip because there is only one tooltip per chart
                            chart.pluginTooltips = []
                            chart.config.data.datasets.forEach(function (dataset, i) {
                                // Check if user click on label to hide a line of the chart
                                // If the line is hidden, don't render the tooltip
                                if (!chart.getDatasetMeta(i).hidden) {
                                    chart.getDatasetMeta(i).data.forEach(function (sector, j) {
                                        chart.pluginTooltips.push(new Chart.Tooltip({
                                            _chart: chart.chart,
                                            _chartInstance: chart,
                                            _data: chart.data,
                                            _options: chart.options.tooltips,
                                            _active: [sector],
                                        }, chart))
                                    })
                                }
                            })

                            // turn off normal tooltips
                            chart.options.tooltips.enabled = false
                        }
                    },
                    beforeUpdate: function (chart) {
                        // if (chart.config.options.showAllTooltips && window.innerWidth <= 1000) {
                        //   chart.config.options.showAllTooltips = false
                        //   chart.options.tooltips.enabled = true
                        // }
                        //
                        // if (!chart.config.options.showAllTooltips && window.innerWidth >= 1000) {
                        //   chart.config.options.showAllTooltips = true
                        //   chart.options.tooltips.enabled = false
                        // }
                    },
                    afterDraw: function (chart, easing) {
                        if (chart.config.options.showAllTooltips) {
                            // we don't want the permanent tooltips to animate, so don't do anything till the animation runs at least once
                            if (!chart.allTooltipsOnce) {
                                if (easing !== 1)
                                    return
                                chart.allTooltipsOnce = true
                            }

                            // turn on tooltips
                            chart.options.tooltips.enabled = true
                            Chart.helpers.each(chart.pluginTooltips, function (tooltip) {

                                // Render tooltip left or right
                                if (tooltip._active[0]._datasetIndex === 0) tooltip._options.xAlign = 'right'
                                if (tooltip._active[0]._datasetIndex === 1) tooltip._options.xAlign = 'left'

                                tooltip.initialize()
                                tooltip.update()

                                // we don't actually need this since we are not animating tooltips
                                tooltip.pivot()
                                tooltip.transition(easing).draw()
                            })
                            chart.options.tooltips.enabled = false
                        }

                        // No data is present
                        chartNoDataMixin.method.showNoData(chart)
                    },
                    afterLayout: function (chart) {
                        // turn off auto show tooltips
                        if (chart.config.data.isGradient) {
                            chart.config.options.showAllTooltips = false
                            chart.options.tooltips.enabled = true

                            // fill color for legend
                            chart.config.data.datasets.forEach((dataset, i) => {
                                chart.legend.legendItems[i].fillStyle = dataset.labelColor
                                chart.legend.legendItems[i].strokeStyle = dataset.labelColor
                            })
                        }
                    }
                })
            },
            setChartClickHandler(point, event) {
                const activePoints = event;
                if (activePoints[0]) {
                    const chartData = activePoints[0]['_chart'].config.data;
                    const idx = activePoints[0]['_index'];
                    const label = chartData.labels[idx];
                    this.$emit('is-show-dialog', label, this.chartData);
                }
            },
            renderLineChart() {
                if (this.gradientColor) {
                    if (this.chartData && this.chartData.datasets && this.chartData.datasets[0].backgroundColor) {
                        for (let i = 0; i < this.chartData.datasets.length; i++) {
                            this.gradient[i] = this.$refs.canvas.getContext("2d").createLinearGradient(0, 0, 0, 300);
                            for (let j = 0; j < this.gradientColor[i].length; j++) {
                                this.gradient[i].addColorStop(this.gradientColor[i][j].opacity, this.gradientColor[i][j].color);
                            }
                            this.chartData.datasets[i].backgroundColor = this.gradient[i];
                            this.chartData.datasets[i].borderColor = this.gradient[i];
                            this.chartData.datasets[i].pointBackgroundColor = this.gradient[i];
                        }
                    }
                }

                this.options['onClick'] = this.setChartClickHandler;

                this.renderChart(this.chartData, this.options || {})
            }
        },
    }
</script>

<style scoped>

</style>
