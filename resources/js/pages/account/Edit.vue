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
    name: 'Edit',

    components: { AccountBreadcrumb, AccountForm },

    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('accounts/getItem', to.params.id),
        store.dispatch('contract/getLists', {perPage: 0}),
      ]).then(() => next())
    },

    beforeRouteLeave (from, to, next) {
      return Promise.all([
        store.dispatch('contract/resetState'),
        store.dispatch('accounts/resetState'),
      ]).then(() => next())
    },
  }
</script>
