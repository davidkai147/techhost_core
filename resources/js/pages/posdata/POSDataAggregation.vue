<template>
  <div>
    <POSDataBreadcrumb/>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- POS Aggregation Search -->
          <POSDataAggregationSearch/>

          <!-- POS Aggregation Table Data -->
          <div class="box">
            <POSDataAggregationTable/>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  </div>
</template>

<script>
  import POSDataAggregationSearch from '../../components/posdata/POSDataAggregationSearch'
  import POSDataAggregationTable from '../../components/posdata/POSDataAggregationTable'

  import store from '../../store'
  import POSDataBreadcrumb from '../../components/posdata/POSDataBreadcrumb'

  export default {
    name: 'POSDataAggregation',
    components: { POSDataBreadcrumb, POSDataAggregationTable, POSDataAggregationSearch },

    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('shops/resetState'),
        store.dispatch('shops/getLists', { perPage: 0 }),

        store.dispatch('posdata/resetState'),
        store.dispatch('posdata/getLists', to.query),
      ]).then(() => next())
    },
  }
</script>
