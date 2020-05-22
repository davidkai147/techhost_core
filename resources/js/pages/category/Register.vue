<template>
    <div>
        <CategoryBreadcrumb/>
        <section class="content">
            <CategoryForm/>
        </section>
    </div>
</template>

<script>
    import CategoryForm from '../../components/category/CategoryForm'
    import store from '../../store'
    import CategoryBreadcrumb from '../../components/category/CategoryBreadcrumb'

    export default {
        name: 'Register',
        components: {CategoryBreadcrumb, CategoryForm},

        beforeRouteLeave(from, to, next) {
            store.dispatch('category/resetState').then(_ => next())
        },
    }
</script>
