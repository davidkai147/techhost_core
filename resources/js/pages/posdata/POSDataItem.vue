<template>
  <div>
    <POSDataBreadcrumb/>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- POS Item Search -->
          <POSDataItemSearch/>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
                <router-link class="btn btn-success" :to="{name: 'POSDataCSVImport'}">
                  <i class="fa fa-file-text-o mr-5"></i> CSV取込
                </router-link>
              </h3>
            </div>

            <!-- POS Item Table -->
            <POSDataItemTable/>
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
  import POSDataItemSearch from '../../components/posdata/POSDataItemSearch'
  import POSDataItemTable from '../../components/posdata/POSDataItemTable'

  import store from '../../store'
  import POSDataBreadcrumb from '../../components/posdata/POSDataBreadcrumb'

  export default {
    name: 'POSDataItem',
    components: { POSDataBreadcrumb, POSDataItemTable, POSDataItemSearch },

    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('shops/resetState'),
        store.dispatch('shops/getLists', { perPage: 0 }),

        store.dispatch('posdataitem/resetState'),
        store.dispatch('posdataitem/getLists', to.query),
      ]).then(() => next())
    },
  }
</script>
