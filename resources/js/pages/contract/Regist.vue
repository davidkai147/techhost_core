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
    name: 'Regist',
    components: { ContractBreadcrumb, ContractForm },

    beforeRouteLeave (from, to, next) {
      store.dispatch('contract/resetState').then(_ => next())
    },
  }
</script>
