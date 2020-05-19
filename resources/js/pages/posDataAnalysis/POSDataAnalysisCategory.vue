<template>
  <div class="chart-page">
    <POSDataAnalysisBreadcrumb />

    <section class="content">
      <div class="row">
        <!-- Filter Form -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <ChartHeader :title="`条件指定分析`" :show-date="false"/>
            </div>
            <div class="box-body">
              <POSDataAnalysisFilterForm :form-name="`category`"/>
            </div>
          </div>
        </div>
      </div>

      <div class="class">
        <div class="chart-boxes-row">
          <div class="box box-lg-6">
            <div class="box-header">
              <ChartHeader :title="`直近3ヶ月のカテゴリトップ3（全店舗集計）の推移`" :show-date="false"/>
            </div>
            <div class="box-body">
              <LineChart :chart-data="lineChartFilteredCategories" :options="lineChartOption" :currency="true"/>
            </div>
          </div>

          <div class="box box-lg-6">
            <div class="box-header">
              <ChartHeader
                :title="`月のカテゴリトップ10（全店舗集計)`"
                :show-date="true"
                :show-prev-and-next-btn="true"
                @get-data="getTop10Categories"
              />
            </div>
            <div class="box-body">
              <BarChart
                :currency="true"
                :chart-data="barChartTop10Categories" :options="barChartOption"
                :gradient-color="['#7C4DFF', '#448AFF', '#00BCD4', '#1DE9B6']"
                :styles="myStyle"
              />
            </div>
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
  import POSDataAnalysisBreadcrumb from '../../components/posDataAnalysis/POSDataAnalysisBreadcrumb'
  import ChartHeader from '../../components/chart/ChartHeader'
  import BarChart from '../../components/chart/BarChart'
  import LineChart from '../../components/chart/LineChart'
  import POSDataAnalysisFilterForm from '../../components/posDataAnalysis/POSDataAnalysisFilterForm'
  import { barChartData } from '../../components/chart/shared/bar-chart.data'
  import { barChartOption } from '../../components/chart/shared/bar-chart.option'
  import { lineChartData } from '../../components/chart/shared/line-chart.data'
  import { lineChartOption } from '../../components/chart/shared/line-chart.option'

  export default {
    name: "POSDataAnalysisCategory",
    components: {
      POSDataAnalysisBreadcrumb,
      BarChart,
      LineChart,
      POSDataAnalysisFilterForm,
      ChartHeader,
    },
    data () {
      return {
        barChartOption,
        lineChartOption,
      }
    },
    computed: {
      ...mapGetters('posDataAnalysis', ['top10Categories', 'filteredCategories']),
      lineChartFilteredCategories() {
        let lineChartFilteredCategories = _.cloneDeep(lineChartData);
        const resLen = this.filteredCategories.length;
        for(let i=0; i < resLen; i++) {
          const lineData = _.values(this.filteredCategories[i].total_sales_amount) || [];
          const labels = _.keys(_.mapKeys(this.filteredCategories[i].total_sales_amount, (value, key) => {
            const tmp = key.length > 7 ? moment(key).format('YYYY年MM月DD日') : moment(key).format('YYYY年MM月');
            return tmp;
          })) || [];
          const dataset = {
            type: "line",
            fill: false,
            lineTension: 0,
            borderWidth: 1,
            yAxisID: "y-axis-1"
          };
          dataset.label = this.filteredCategories[i].jicfs_name || '';
          dataset.data = lineData;
          dataset.borderColor = i === 0 ? "rgba(254,97,132,0.8)" : i === 1 ? "rgba(60, 160, 220, 0.8)" : "rgba(60, 190, 20, 0.8)";
          dataset.backgroundColor = i === 0 ? "rgba(254,97,132,0.1)" : i === 1 ? "rgba(60, 160, 220, 0.1)" : "rgba(60, 190, 20, 0.1)";

          lineChartFilteredCategories.labels = labels;
          lineChartFilteredCategories.datasets.push(dataset);
        }
        return lineChartFilteredCategories;
      },
      barChartTop10Categories() {
        let barChartTop10Categories = _.cloneDeep(barChartData);
        barChartTop10Categories.labels = this.getValuesInArrByKey(this.top10Categories, 'jicfs_name') || [];
        barChartTop10Categories.datasets[0].data = this.getValuesInArrByKey(this.top10Categories, 'total_sales_amount', 'number') || [];
        return barChartTop10Categories;
      },
      myStyle () {
        return {
          minHeight: '400px',
          height: '42vh',
          position: 'relative',
        }
      },
    },
    created() {
      const currentMonth = moment(new Date(), 'YYYY/MM/DD').format('YYYY-MM');
      return Promise.all([
        store.dispatch('posDataAnalysis/resetState'),
        store.dispatch('posDataAnalysis/getList', {source: 'shop'}),
        store.dispatch('posDataAnalysis/getList', {source: 'category'}),
        store.dispatch('posDataAnalysis/postFilterCategories', {}),
        store.dispatch('posDataAnalysis/getTop10Categories', {date: currentMonth}),
      ])
    },
    methods: {
      getValuesInArrByKey(arr, key, type) {
        // TYPE: type of value will be return
        return _.map(arr, function(item) {
          return type === 'number' ? Number(item[key]) : item[key];
        })
      },
      getTop10Categories(currentMonth, cmpName) {
        currentMonth = moment(currentMonth, 'YYYY/MM/DD').format('YYYY-MM');
        store.dispatch('posDataAnalysis/getTop10Categories', {date: currentMonth});
      }
    }
  }
</script>

<style scoped>

</style>
