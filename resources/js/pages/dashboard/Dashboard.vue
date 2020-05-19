<template>
  <div class="chart-page">
    <DashboardBreadcrumb />
    <section class="content">
      <div class="chart-boxes-row">

        <div class="box box-lg-8 box-md-12">
          <div class="box-header">
            <ChartHeader :title="`直近3ヶ月の売上額と商品販売数の全店舗合計の推移`" :show-date="false"/>
          </div>
          <div class="box-body">
            <div class="chart-style">
              <LineChartAllShopLast3M
                :chart-data="lineChartAllShopLast3M"
                :options="optionLineChartAllShopLast3M"
                :styles="myStyle"/>
            </div>
          </div>
        </div>

        <div class="box box-lg-4 box-md-6 box-sm-12">
          <div class="box-header">
            <ChartHeader :title="`今月の売上額と商品販売数`" :show-date="false"/>
          </div>
          <div class="box-body box-body--total">
            <div class="inner">
              <p>売上額</p>
              <h2>{{trendSaleAllShopThisM.sales_amount | formatPrice}}¥</h2>
            </div>
            <div class="inner">
              <p>商品数</p>
              <h2>{{trendSaleAllShopThisM.sales_quantity | formatPrice}}</h2>
            </div>
          </div>
        </div>

        <div class="box box-lg-4 box-md-6 box-sm-12">
          <div class="box-header">
            <ChartHeader :title="`当月のカテゴリトップ10`" :show-date="false"/>
          </div>
          <div class="box-body box-body--total" :class="[top10Categories.length === 0 ? 'box-body--total-no-data' : '']">
            <ul class="categories-of-week">
              <li v-for="item in top10Categories" :key="item.name">
                <span class="category__title">{{item.jicfs_name}}</span>
                <span class="category__num">‎¥{{item.sales_amount | formatPrice}}</span>
              </li>
            </ul>
            <p v-if="top10Categories.length === 0">検索結果はありません。</p>
          </div>
        </div>

        <div class="box box-lg-8 box-md-12">
          <div class="box-header">
            <ChartHeader :title="`直近3ヵ月のカテゴリトップ10（全店舗集計）の推移`" :show-date="false"/>
          </div>
          <div class="box-body">
            <BarChart
              :currency="true"
              :chart-data="barChartCategory" :options="barChartOption"
              :gradient-color="['#303A99', '#5E2390', '#8B0D88', '#C00388']"
              :styles="myStyle"
            />
          </div>
        </div>

        <div class="box box-lg-6">
          <div class="box-header">
            <ChartHeader
              :name="`sales_amount`"
              :title="`月の店舗別売上総額`"
              :show-date="true"
              :show-prev-and-next-btn="true"
              @get-data="getMonthlyShopSales"/>
          </div>
          <div class="box-body">
            <BarChart
              :currency="true"
              :data="monthlyShopSalesAmount"
              :chart-data="barChartShopAmount" :options="barChartOption"
              :gradient-color="['#7C4DFF', '#448AFF', '#00BCD4', '#1DE9B6']"
              :draw-average="true" :average-val="barChartShopAmountAverage" :styles="myStyle"
            />
          </div>
        </div>

        <div class="box box-lg-6">
          <div class="box-header">
            <ChartHeader
              :name="`sales_quantity`"
              :title="`月の店舗別商品販売数`"
              :show-date="true"
              :show-prev-and-next-btn="true"
              @get-data="getMonthlyShopSales"/>
          </div>
          <div class="box-body">
            <BarChart
              :chart-data="barChartShopQty" :options="barChartOption"
              :gradient-color="['#581845', '#900C3F', '#C70039', '#FF5733']"
              :styles="myStyle"
            />
          </div>
        </div>

      </div>
    </section>
  </div>
</template>

<script>
  import { mapGetters } from "vuex"
  import moment from 'moment'
  import store from "../../store"
  import DashboardBreadcrumb from '../../components/dashboard/DashboardBreadcrumb'

  import ChartHeader from '../../components/chart/ChartHeader'
  import BarChart from '../../components/chart/BarChart'
  import LineChartAllShopLast3M from '../../components/chart/LineChartAllShopLast3M'

  import { dataLineChartAllShopLast3M, chartInterface3MGradient } from '../../components/chart/shared/line-chart-all-shop-3m.data'
  import { optionLineChartAllShopLast3M } from '../../components/chart/shared/line-chart-all-shop-3m.option'

  import { barChartData } from '../../components/chart/shared/bar-chart.data'
  import { barChartOption } from '../../components/chart/shared/bar-chart.option'

    export default {
      name: "Dashboard",
      components: {
        DashboardBreadcrumb,
        LineChartAllShopLast3M,
        ChartHeader,
        BarChart
      },
      data () {
        return {
          currentMonth: null,
          optionLineChartAllShopLast3M,
          barChartOption,
        }
      },
      computed: {
        ...mapGetters('dashboard', [
          'trendSaleAllShopLast3M', 'trendSaleAllShopThisM', 'top10Categories',
          'top10CategoriesThisM', 'monthlyShopSalesAmount', 'monthlyShopSalesQty'
        ]),
        // Chart: 直近3ヶ月の売上額と商品販売数の全店舗合計の推移
        lineChartAllShopLast3M() {
          let lineChartAllShopLast3M = _.cloneDeep(chartInterface3MGradient());
          lineChartAllShopLast3M.labels = _.map(this.trendSaleAllShopLast3M, function (item) {
            item.month = moment(item.month, 'YYYY/MM').format('YYYY年MM月');
            return item.month;
          });
          lineChartAllShopLast3M.datasets[0].data = this.getValuesInArrByKey(this.trendSaleAllShopLast3M, 'sales_amount', 'number') || [];
          lineChartAllShopLast3M.datasets[1].data = this.getValuesInArrByKey(this.trendSaleAllShopLast3M, 'sales_quantity', 'number') || [];
          return lineChartAllShopLast3M;
        },
        // Chart: 直近3ヵ月のカテゴリトップ10（全店舗集計）の推移
        barChartCategory() {
          let barChartCategory = _.cloneDeep(barChartData);
          barChartCategory.labels = this.getValuesInArrByKey(this.top10CategoriesThisM, 'jicfs_name') || [];
          barChartCategory.datasets[0].data = this.getValuesInArrByKey(this.top10CategoriesThisM, 'sales_amount', 'number') || [];
          return barChartCategory;
        },
        // Chart: 月の店舗別売上総額
        barChartShopAmountAverage() {
          const arr = this.getValuesInArrByKey(this.monthlyShopSalesAmount, 'sales_amount', 'number') || [];
          const sumArr= _.sum(arr) || 0;
          let averAmount = 0;
          if(arr.length > 0) averAmount = sumArr / arr.length;
          return averAmount;
        },
        barChartShopAmount() {
          let barChartShopAmount = _.cloneDeep(barChartData);
          barChartShopAmount.labels = this.getValuesInArrByKey(this.monthlyShopSalesAmount, 'shop_name') || [];
          barChartShopAmount.datasets[0].data = this.getValuesInArrByKey(this.monthlyShopSalesAmount, 'sales_amount', 'number') || [];
          return barChartShopAmount;
        },
        // Chart: 月の店舗別商品販売数
        barChartShopQty() {
          let barChartShopQty = _.cloneDeep(barChartData);
          barChartShopQty.labels = this.getValuesInArrByKey(this.monthlyShopSalesQty, 'shop_name') || [];
          barChartShopQty.datasets[0].data = this.getValuesInArrByKey(this.monthlyShopSalesQty, 'sales_quantity', 'number') || [];
          return barChartShopQty;
        },
        myStyle () {
          return {
            minHeight: '330px',
            height: '35vh',
            position: 'relative',
          }
        },
      },
      created(){
        //https://router.vuejs.org/guide/advanced/data-fetching.html#fetching-after-navigation
        const currentMonth = moment(new Date(), 'YYYY/MM/DD').format('YYYY-MM');
        return Promise.all([
          store.dispatch('dashboard/getTrendSaleAllShop'),
          store.dispatch('dashboard/getTrendSaleAllShop', {this_month: true}),
          store.dispatch('dashboard/getTop10Categories'),
          store.dispatch('dashboard/getTop10Categories', {this_month: true}),
          store.dispatch('dashboard/getMonthlyShopSales', {month: currentMonth, sales_amount: true}),
          store.dispatch('dashboard/getMonthlyShopSales', {month: currentMonth, sales_quantity: true})
        ]);
      },
      methods: {
        // ...mapActions({
        //   getMonthlyShopSales: 'dashboard/getMonthlyShopSales'
        // }),
        getValuesInArrByKey(arr, key, type) {
          // TYPE: type of value will be return
          return _.map(arr, function(item) {
            const val = type === 'number' ? Number(item[key]) : item[key];
            return val;
          })
        },
        getMonthlyShopSales(currentMonth, cmpName) {
          currentMonth = moment(currentMonth).format('YYYY-MM');
          let params;
          params = cmpName === 'sales_amount' ? {month: currentMonth, sales_amount: true} : {month: currentMonth, sales_quantity: true};
          store.dispatch('dashboard/getMonthlyShopSales', params);
        }
      },
    }
</script>
