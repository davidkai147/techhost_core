<template>
  <div>
    <ShopBreadcrumb/>
    <section class="content">
      <ShopForm/>
    </section>
  </div>
</template>

<script>
  import ShopForm from '../../components/shop/ShopForm'
  import store from '../../store'
  import ShopBreadcrumb from '../../components/shop/ShopBreadcrumb'

  export default {
    name: 'Edit',
    components: { ShopForm, ShopBreadcrumb },

    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('shops/getItem', to.params.id),
      ]).then(() => next())
    },

    beforeRouteLeave (from, to, next) {
      store.dispatch('shops/resetState').then(_ => next())
    },
  }
</script>
