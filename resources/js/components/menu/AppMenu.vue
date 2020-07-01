<template>
  <div class="collapse navbar-collapse" id="navbar-menu"
       :class="{'show': isOpen}"
  >
    <AppSubmenu :items="model" :root="true"/>
  </div>
</template>

<script lang="js">
  import AppSubmenu from './AppSubMenu.vue'

  export default {
    name: 'AppMenu',

    components: {
      AppSubmenu
    },

    props: {
      model: Array,
      isOpen: {
        type: Boolean,
        default: false
      }
    }
  }
</script>

<style scoped>

</style>
