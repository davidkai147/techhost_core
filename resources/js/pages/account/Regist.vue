<template>
  <div>
    <AccountBreadcrumb/>
    <section class="content">
      <AccountForm/>
    </section>
  </div>
</template>

<script>
  import AccountForm from '../../components/account/AccountForm'
  import store from '../../store'
  import AccountBreadcrumb from '../../components/account/AccountBreadcrumb'

  export default {
    name: 'Regist',
    components: { AccountBreadcrumb, AccountForm },

    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('contract/getLists', { perPage: 0 }),
      ]).then(() => next())
    },

    beforeRouteLeave (from, to, next) {
      store.dispatch('accounts/resetState').then(_ => next())
    },
  }
</script>
