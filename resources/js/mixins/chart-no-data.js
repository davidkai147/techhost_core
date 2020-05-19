import Chart from "chart.js";

const chartNoDataMixin = {
  method: {
    showNoData(chart) {
      let data = []
      chart.chart.data.datasets.forEach((item) => {
        data = _.concat(data, item.data)
      });
      const hasData = _.findIndex(data, (item) => {return item !== 0})
      if (hasData === -1) {
        const ctx = chart.chart.ctx;
        const width = chart.chart.width;
        const height = chart.chart.height;

        //chart.clear();

        ctx.save();
        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillStyle = "#5F6368";
        ctx.fillText('データがありません。', width / 2, height / 2);
        ctx.restore();
      }
    }
  }
}

export default chartNoDataMixin;
