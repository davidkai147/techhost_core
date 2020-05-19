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
  import ShopBreadcrumb from '../../components/shop/ShopBreadcrumb'

  export default {
    name: 'Regist',
    components: { ShopForm, ShopBreadcrumb },
  }
</script>
