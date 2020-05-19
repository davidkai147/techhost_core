<template>
  <div>
    <ShelfLocationBreadcrumb/>
    <section class="content">
      <ShelfLocationForm/>
    </section>
  </div>
</template>

<script>
  import ShelfLocationForm from '../../components/shelflocation/ShelfLocationForm'
  import store from '../../store'
  import ShelfLocationBreadcrumb from '../../components/shelflocation/ShelfLocationBreadcrumb'

  export default {
    name: 'ShelfLocationImport',
    components: { ShelfLocationBreadcrumb, ShelfLocationForm },
    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('shops/resetState'),
        store.dispatch('shops/getLists', { perPage: 0 }),
      ]).then(() => next())
    },
  }
</script>

<style scoped>

</style>
