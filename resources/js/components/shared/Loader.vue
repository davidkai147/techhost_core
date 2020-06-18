<template>
    <div class="overlay" :class="{show: isShow}">
<!--        <img src="../../assets/loading.gif" alt="loading">-->
        <a-spin tip="Loading..." size="large"/>
    </div>
</template>

<script>
    export default {
        name: "Loader",
        props: ["isShow"]
    }
</script>

<style scoped>

</style>
