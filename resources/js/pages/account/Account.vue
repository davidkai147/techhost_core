<template>
  <div>
    <AccountBreadcrumb/>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- Contract Search -->
          <AccountSearch/>
          <div class="box">
            <!-- Contract Regist -->
            <div class="box-header">
              <h3 class="box-title">
                <router-link class="btn btn-success" :to="{name: 'AccountRegist'}">
                  <i class="fa fa-plus mr-5"></i> 新規登録
                </router-link>
              </h3>
            </div>
            <!-- Contract Table -->
            <AccountTable/>
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
  import AccountTable from '../../components/account/AccountTable'
  import AccountSearch from '../../components/account/AccountSearch'

  import store from '../../store'
  import AccountBreadcrumb from '../../components/account/AccountBreadcrumb'

  export default {
    name: 'Account',

    components: { AccountBreadcrumb, AccountSearch, AccountTable },

    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('accounts/resetState'),
        store.dispatch('accounts/getLists', to.query),
      ]).then(() => next())
    },
  }
</script>
