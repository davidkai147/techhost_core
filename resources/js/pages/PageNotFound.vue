<template>
  <!-- Main content -->
  <section class="content">
    <div class="error-page">
      <h2 class="headline text-yellow"> 404</h2>

      <div class="error-content text-center">
        <h3><i class="fa fa-warning text-yellow"></i> Oops!</h3>

        <p class="text-center">
          アクセスしようとしているサイトを見つけられません。
        </p>

      </div>
      <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
  </section>
  <!-- /.content -->
</template>

<script>
  export default {
    name: 'PageNotFound',
  }
</script>

<style scoped lang="scss">
  .error-content {
    margin-left: 0;
  }

  .headline {
    text-align: center;
    width: 100%;
  }

</style>
