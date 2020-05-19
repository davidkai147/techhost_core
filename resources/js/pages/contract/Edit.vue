<template>
 <div>
   <ContractBreadcrumb/>
   <section class="content">
     <ContractForm/>
   </section>
 </div>
</template>

<script>
  import ContractForm from '../../components/contract/ContractForm'
  import store from '../../store'
  import ContractBreadcrumb from '../../components/contract/ContractBreadcrumb'

  export default {
    name: 'Edit',
    components: { ContractBreadcrumb, ContractForm },

    beforeRouteEnter (to, from, next) {
      return Promise.all([
        store.dispatch('contract/getItem', to.params.id),
      ]).then(() => next())
    },

    beforeRouteLeave (from, to, next) {
      store.dispatch('contract/resetState').then(_ => next())
    },
  }
</script>
