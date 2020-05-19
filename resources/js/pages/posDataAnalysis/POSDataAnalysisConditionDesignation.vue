<template>
  <div class="chart-page">
    <POSDataAnalysisBreadcrumb/>

    <section class="content">
      <div class="row">
        <!-- Form Filter  -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <POSDataAnalysisSearchForm ref="formSearch"/>
            </div>
          </div>
        </div>
      </div>

      <!-- Chart 3M Sales & Products Section -->
      <div class="row">
        <div class="col-sm-6">
          <div class="box box-sm-12"
               v-if="isShowChart(shopDashBoard.labels)">
            <div class="box-header">
              直近3ヶ月の売上額と商品販売数の全店舗合計の推移
            </div>

            <div class="box-body">
              <LineChartAllShopLast3M
                :name="shopDashBoard"
                :chart-data="shopDashBoard"
                :options="optionLineChartAllShopLast3M"
                @is-show-dialog="isShowDialog"/>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="box box-sm-12"
               v-if="isShowChart(shopDashBoard2.labels)">
            <div class="box-header">
              直近3ヶ月の売上額と商品販売数の全店舗合計の推移
            </div>

            <div class="box-body">
              <LineChartAllShopLast3M
                :chart-data="shopDashBoard2"
                :options="optionLineChartAllShopLast3M"
                @is-show-dialog="isShowDialog"/>
            </div>
          </div>
        </div>
      </div>

      <!-- Chart current Sales & Products Section -->
      <div class="row">
        <div class="col-sm-6">
          <div class="box box-sm-12"
               v-if="isShowChart(shopSalesMonth)"
               v-for="(item, index) in shopSalesMonth"
               :key="index">
            <div class="box-header">
              <ChartHeader :title="`今月の売上額と商品販売数 - ` + item.shop_name" :show-date="false"/>
            </div>
            <div class="box-body box-body--total">
              <div class="inner">
                <p>売上額</p>
                <h2>{{item.sales_amount | formatPrice}}¥</h2>
              </div>
              <div class="inner">
                <p>商品数</p>
                <h2>{{item.sales_quantity | formatPrice}}</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="box box-sm-12"
               v-if="isShowChart(shopSalesMonth2)"
               v-for="(item, index) in shopSalesMonth2"
               :key="index">
            <div class="box-header">
              <ChartHeader :title="`今月の売上額と商品販売数 - ` + item.shop_name" :show-date="false"/>
            </div>
            <div class="box-body box-body--total">
              <div class="inner">
                <p>売上額</p>
                <h2>{{item.sales_amount | formatPrice}}¥</h2>
              </div>
              <div class="inner">
                <p>商品数</p>
                <h2>{{item.sales_quantity | formatPrice}}</h2>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Chart Top 10 Category Sales & Products of Shop -->
      <div class="row">
        <div class="col-sm-6">
          <div class="box box-sm-12" v-if="isShowChart(shopTop10CategoryMonth)">
            <div class="box-header">
              <ChartHeader
                :name="`sales_amount`"
                :title="`指定期間のカテゴリトップ10`"/>
            </div>

            <div class="box-body">
              <BarChartVertical
                :currency="true"
                :data="shopTop10CategoryMonth"
                :chart-data="shopTop10CategoryMonth"
                :options="barChartOptionVertical"/>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="box box-sm-12" v-if="isShowChart(shopTop10CategoryMonth2)">
            <div class="box-header">
              <ChartHeader
                :name="`sales_amount`"
                :title="`指定期間のカテゴリトップ10`"/>
            </div>

            <div class="box-body">
              <BarChartVertical
                :currency="true"
                :data="shopTop10CategoryMonth2"
                :chart-data="shopTop10CategoryMonth2"
                :options="barChartOptionVertical"/>
            </div>
          </div>
        </div>
      </div>
    </section>

    <el-dialog :visible.sync="dialogTableVisible" :before-close="handleClose">
      <POSDataAnalysisModalTable :list="filterCategoryTable" :form-name="`condition-designation`"/>
    </el-dialog>
  </div>
</template>

<script>
  import store from '../../store'
  import moment from 'moment'
  import POSDataAnalysisBreadcrumb from '../../components/posDataAnalysis/POSDataAnalysisBreadcrumb'
  import POSDataAnalysisFilterForm from '../../components/posDataAnalysis/POSDataAnalysisFilterForm'
  import POSDataAnalysisSearchForm from '../../components/posDataAnalysis/POSDataAnalysisSearchForm'
  import POSDataAnalysisModalTable from '../../components/posDataAnalysis/POSDataAnalysisModalTable'
  import ChartHeader from '../../components/chart/ChartHeader'
  import {mapActions, mapGetters} from 'vuex'

  // ChartJS
  import {optionLineChartAllShopLast3M} from '../../components/chart/shared/line-chart-all-shop-3m.option'
  import LineChartAllShopLast3M from '../../components/chart/LineChartAllShopLast3M'
  import {barChartOptionVertical} from '../../components/chart/shared/bar-chart.option'
  import BarChartVertical from '../../components/chart/BarChartVertical'

  export default {
    name: 'POSDataAnalysisConditionDesignation',
    components: {
      POSDataAnalysisBreadcrumb,
      POSDataAnalysisFilterForm,
      POSDataAnalysisSearchForm,
      ChartHeader,
      POSDataAnalysisModalTable,

      // import for chart
      LineChartAllShopLast3M,
      BarChartVertical
    },

    data() {
      return {
        optionLineChartAllShopLast3M,
        barChartOptionVertical
      }
    },

    computed: {
      ...mapGetters('posDataAnalysis', [
        'filterCategoryTable',
        'shopDashBoard',
        'shopSalesMonth',
        'shopTop10CategoryMonth',
        'shopDashBoard2',
        'shopSalesMonth2',
        'shopTop10CategoryMonth2',
        'getQueryCategoryParams',
        'dialogTableVisible'
      ])
    },

    created() {
      return Promise.all([
        store.dispatch('posDataAnalysis/resetState'),
        store.dispatch('posDataAnalysis/getList', {source: 'shop'}),
      ]);
    },

    methods: {
      ...mapActions('posDataAnalysis', [
        'postFilterCategoryTable',
        'showOrHideModal'
      ]),

      /**
       * check is data in chart
       * @param data
       * @returns {boolean}
       */
      isShowChart(data) {
        return _.size(data) > 0
      },

      /**
       * show table dialog
       * @param date
       * @param data
       */
      isShowDialog(date, data) {
        const monthFm = moment(date, 'YYYY/MM/DD').format('YYYY-MM') || "";
        const params = {...this.getQueryCategoryParams}
        params.page = 1;
        params.month = monthFm;
        params.shop_id = data.shop_id

        this.postFilterCategoryTable(params);
      },

      handleClose() {
        store.dispatch('posDataAnalysis/showOrHideModal', false)
      }
    }
  }
</script>

<style scoped lang="scss">
  .chart-boxes-row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .box {
      margin-bottom: 15px;
    }

    @media (min-width: 1200px) {
      .box-lg-4 {
        width: calc(33.33333333% - 7.5px);
      }
      .box-lg-6 {
        width: calc(50% - 7.5px);
      }
      .box-lg-8 {
        width: calc(66.66666667% - 7.5px);
      }
    }
    @media (max-width: 1200px) {
      .box-md-12 {
        width: 100%;
      }
      .box-md-6 {
        width: calc(50% - 7.5px);
      }
    }
    @media (max-width: 768px) {
      .box-sm-12 {
        width: 100%;
      }
      .box-sm-6 {
        width: calc(50% - 7.5px);
      }
    }
  }
</style>
