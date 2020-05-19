<template>
  <div class="chart-page">
    <POSDataAnalysisBreadcrumb/>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <POSDataAnalysisFilterShelfForm :form-name="`shelf-by-shelf`"/>
            </div>
          </div>

          <!-- Chart -->
          <div class="chart-boxes-row">
            <div class="box box-lg-12 box-md-12" v-if="isShowChart(salesProductShelfChart)">
              <div class="box-header">
                <ChartHeader
                    :name="`sales_amount`"
                    :title="`月の店舗別売上総額`"/>
              </div>

              <div class="box-body">
                <BarChartVertical
                    :currency="true"
                    :chart-data="salesProductShelfChart"
                    :options="barChartOptionVertical"/>
              </div>
            </div>
          </div>

          <div class="box">
            <POSDataAnalysisTable :list="filteredShelfByShelf" :form-name="`shelf-by-shelf`"/>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  import store from '../../store'
  import POSDataAnalysisBreadcrumb from '../../components/posDataAnalysis/POSDataAnalysisBreadcrumb'
  import POSDataAnalysisFilterShelfForm from '../../components/posDataAnalysis/POSDataAnalysisFilterShelfForm'
  import POSDataAnalysisTable from '../../components/posDataAnalysis/POSDataAnalysisTable'
  import { mapGetters } from 'vuex'

  // chartJS
  import ChartHeader from '../../components/chart/ChartHeader'
  import { barChartOptionVertical } from '../../components/chart/shared/bar-chart.option'
  import BarChartVertical from '../../components/chart/BarChartVertical'

  export default {
    name: 'POSDataAnalysisShelfByShelf',

    data () {
      return {
        barChartOptionVertical
      }
    },

    components: {
      POSDataAnalysisBreadcrumb,
      POSDataAnalysisFilterShelfForm,
      POSDataAnalysisTable,

      // chartJS
      ChartHeader,
      BarChartVertical
    },

    computed: {
      ...mapGetters('posDataAnalysis', [
        'filteredShelfByShelf',
        'salesProductShelfChart'
      ])
    },

    created() {
      return Promise.all([
        store.dispatch('posDataAnalysis/resetState'),
        store.dispatch('posDataAnalysis/getList', { source: 'shop' }),
        store.dispatch('posDataAnalysis/getList', { source: 'shelf_no' }),
        store.dispatch('posDataAnalysis/postFilterShelfByShelf', { params: this.$route.query, body: {} })
      ])
    },

    methods: {
      /**
       * check is data in chart
       * @param data
       * @returns {boolean}
       */
      isShowChart (data) {
        return _.size(data) > 0
      }
    }
  }
</script>

<style scoped>

</style>
