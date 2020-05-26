<template>
    <div>
        <CategoryBreadcrumb/>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Category Search -->
                    <CategorySearch/>
                    <div class="box">
                        <!-- Category Regist -->
                        <div class="box-header">
                            <h3 class="box-title">
                                <router-link class="btn btn-success" :to="{name: 'CategoryRegister'}">
                                    <i class="fa fa-plus mr-5"></i>&nbsp;&nbsp;Register
                                </router-link>
                            </h3>
                        </div>
                        <!-- Category Table -->
                        <CategoryTable/>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>
</template>

<script>
    import CategoryTable from '../../components/category/CategoryTable'
    import CategorySearch from '../../components/category/CategorySearch'

    import store from '../../store'
    import CategoryBreadcrumb from '../../components/category/CategoryBreadcrumb'

    export default {
        name: 'Category',

        components: {
            CategoryBreadcrumb,
            CategorySearch,
            CategoryTable,
        },

        beforeRouteEnter(to, from, next) {
            console.log(to.query)
            return Promise.all([
                store.dispatch('category/resetState'),
                // Ko goi truoc khi vao route neu dieu kien qua phuc tap
                store.dispatch('category/getLists', to.query),
            ]).then(() => next())
        },
    }
</script>
