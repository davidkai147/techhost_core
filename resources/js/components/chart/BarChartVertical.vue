<script>
    import * as VueChartJs from 'vue-chartjs'

    const {reactiveProp} = VueChartJs.mixins

    export default {
        extends: VueChartJs.Bar,
        mixins: [reactiveProp],
        props: [
            'chartData',
            'options',
            'drawAverage',
            'averageVal',
            'currency',
            'data'
        ],
        data: () => ({
            gradient: null
        }),
        mounted() {
            this.renderMixedChart()
        },
        methods: {
            renderMixedChart() {
                this.renderChart(this.chartData, this.options)
            }
        },
    }
</script>
