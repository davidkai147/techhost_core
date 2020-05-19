<template>
  <div>
    <POSDataBreadcrumb/>
    <section class="content">
      <POSDataForm/>
    </section>
  </div>
</template>

<script>
  import POSDataForm from '../../components/posdata/POSDataForm'
  import POSDataBreadcrumb from '../../components/posdata/POSDataBreadcrumb'
  import store from '../../store'

  export default {
    name: 'POSDataCSVImport',
    components: { POSDataForm, POSDataBreadcrumb },
    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('shops/resetState'),
        store.dispatch('shops/getLists', { perPage: 0 }),
      ]).then(() => next())
    },
  }
</script>
