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
    import {mapGetters} from "vuex";

    export default {
        name: 'Edit',
        components: {CategoryBreadcrumb, CategoryForm},

        computed: {
            ...mapGetters('category', ['item'])
        },

        beforeRouteEnter(to, from, next) {
            return Promise.all([
                store.dispatch('category/getItem', { id: to.params.id }),
            ]).then(() => next())
        },

        beforeRouteLeave(from, to, next) {
            store.dispatch('category/resetState').then(_ => next())
        },
    }
</script>
