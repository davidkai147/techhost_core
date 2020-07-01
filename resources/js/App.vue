<template>
  <div id="app">
    <ConfigProvider :locale="locale">
      <router-view/>
    </ConfigProvider>
  </div>
</template>

<script>
  import { ConfigProvider } from 'ant-design-vue'
  import viVN from 'ant-design-vue/lib/locale-provider/vi_VN'

  export default {
    name: 'App',
    components: {
        ConfigProvider,
    },
    data () {
      return {
        locale: viVN,
      }
    },
  }
</script>

<style>
</style>
