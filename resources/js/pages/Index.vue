<template>
  <div>
    <!--Header-->
    <Header/>

    <!--Sidebar-->
    <Sidebar/>

    <!--Page-->
    <section class="content-wrapper">
      <router-view />
    </section>

    <!--Footer-->
    <Footer/>

    <!--Loading-->
    <Loader :is-show="loading" />
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import Header from '../layouts/Header'
  import Sidebar from '../layouts/Sidebar'
  import Footer from '../layouts/Footer'
  import Loader from "../components/shared/Loader"

  export default {
    name: 'Index',
    components: {
      Sidebar,
      Header,
      Footer,
      Loader
    },
    computed: {
      ...mapState("loader", ["loading"])
    }
  }
</script>
