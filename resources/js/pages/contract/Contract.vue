<template>
  <div>
    <ContractBreadcrumb/>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- Contract Search -->
          <ContractSearch/>
          <div class="box">
            <!-- Contract Regist -->
            <div class="box-header">
              <h3 class="box-title">
                <router-link class="btn btn-success" :to="{name: 'ContractRegist'}">
                  <i class="fa fa-plus mr-5"></i> 新規登録
                </router-link>
              </h3>
            </div>
            <!-- Contract Table -->
            <ContractTable/>
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
  import ContractTable from '../../components/contract/ContractTable'
  import ContractSearch from '../../components/contract/ContractSearch'

  import store from '../../store'
  import ContractBreadcrumb from '../../components/contract/ContractBreadcrumb'

  export default {
    name: 'Contract',

    components: {
      ContractBreadcrumb,
      ContractSearch,
      ContractTable,
    },

    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('contract/resetState'),
        store.dispatch('contract/getLists', to.query),
      ]).then(() => next())
    },
  }
</script>
