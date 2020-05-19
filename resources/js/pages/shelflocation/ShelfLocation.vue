<template>
  <div>
    <ShelfLocationBreadcrumb/>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- Shelf Search -->
          <ShelfLocationSearch/>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
                <router-link class="btn btn-success" :to="{name: 'ShelfLocationImport'}">
                  <i class="fa fa-file-text-o mr-5"></i> CSV取込
                </router-link>
              </h3>
            </div>

            <!-- Shelf Table -->
            <ShelfLocationTable/>
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
  import ShelfLocationSearch from '../../components/shelflocation/ShelfLocationSearch'
  import ShelfLocationTable from '../../components/shelflocation/ShelfLocationTable'
  import store from '../../store'
  import ShelfLocationBreadcrumb from '../../components/shelflocation/ShelfLocationBreadcrumb'

  export default {
    name: 'ShelfLocation',
    components: { ShelfLocationBreadcrumb, ShelfLocationTable, ShelfLocationSearch },

    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('shops/getLists', { perPage: 0 }),

        store.dispatch('shelf/resetState'),
        store.dispatch('shelf/getLists', to.query),
      ]).then(() => next())
    },
  }
</script>
