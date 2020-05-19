<template>
  <div>
    <ShopBreadcrumb/>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- Shop Search -->
          <ShopSearch/>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
                <router-link class="btn btn-success" :to="{name: 'ShopRegist'}">
                  <i class="fa fa-plus mr-5"></i> 新規登録
                </router-link>
              </h3>
            </div>

            <!-- Shop Table -->
            <ShopTable/>
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
  import ShopSearch from '../../components/shop/ShopSearch'
  import ShopTable from '../../components/shop/ShopTable'
  import ShopBreadcrumb from '../../components/shop/ShopBreadcrumb'

  import store from '../../store'

  export default {
    name: 'Shop',

    components: { ShopTable, ShopSearch, ShopBreadcrumb },

    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('shops/resetState'),
        store.dispatch('shops/getLists', to.query),
      ]).then(() => next())
    },
  }
</script>
