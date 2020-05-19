<template>
    <div class="overlay" :class="{show: isShow}">
        <img src="../../assets/loading.gif" alt="loading">
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
