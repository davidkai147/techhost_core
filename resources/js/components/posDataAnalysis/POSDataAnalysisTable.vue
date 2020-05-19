<template>
    <section class="box-table">
        <div class="box-body">
            <table id="posDataAnalysisTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>店舗</th>
                    <th v-if="formName === 'shelf-by-shelf'" class="text-center">棚番号</th>
                    <th class="text-center">カテゴリ</th>
                    <th v-if="formName === 'condition-designation'" class="text-center">棚番号</th>
                    <th class="text-center">売上金額</th>
                    <th class="text-center">販売個数</th>
                </tr>
                </thead>
                <tbody v-if="list.length > 0">
                <tr v-for="(item, index) in list" :key="index">
                    <td>{{ item.shop_name ? item.shop_name : ' ' }}</td>
                    <td v-if="formName === 'shelf-by-shelf'" class="text-center">{{ item.shelf_no }}</td>
                    <td class="text-center">{{ item.jicfs_name }}</td>
                    <td v-if="formName !== 'condition-designation'" class="text-center">
                        {{ item.total_sales_amount | formatPrice}}
                    </td>
                    <td v-if="formName !== 'condition-designation'" class="text-center">
                        {{ item.total_sales_quantity | formatPrice}}
                    </td>
                    <td v-if="formName === 'condition-designation'" class="text-center">
                        {{ item.shelf_no }}
                    </td>
                    <td v-if="formName === 'condition-designation'" class="text-center">
                        {{ item.sales_amount | formatPrice }}
                    </td>
                    <td v-if="formName === 'condition-designation'" class="text-center">
                        {{ item.sales_quantity | formatPrice }}
                    </td>
                </tr>
                </tbody>
                <tbody v-else align="center">
                <tr>
                    <td colspan="6" class="text-center col-xs-12">
                        <div class="no-result">検索結果はありません</div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <vPagination
                v-model="page"
                class="pull-right m-0"
                :page-count="pagination.totalPages || 0"
                :page-range="5"
                :margin-pages="2"
                :click-handler="handlePage"
                :prev-text="'前へ'"
                :next-text="'次へ'"
                :container-class="'pagination'"
                :page-class="'page-item'">
            </vPagination>
        </div>
    </section>
</template>

<script>
    import vPagination from 'vuejs-paginate'
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: 'POSDataAnalysisTable',
        props: ['list', 'formName'],
        components: {
            vPagination,
        },
        created() {
            let queries = this.getUrlSetQuery()

            if (_.keys(queries).length === 0) {
                queries = {...this.defaultQueries}
            }

            this.handleReplaceUrl(queries)
        },

        data() {
            return {
                page: parseInt(this.$router.currentRoute.query.page) || 1,
            }
        },

        computed: {
            ...mapGetters('posDataAnalysis', {
                filteredData: 'filteredData',
                pagination: 'pagination',
                defaultQueries: 'getQueryParams',
            }),
        },

        watch: {
            '$route.query.page'(val) {
                this.page = +val
            },
        },

        methods: {
            ...mapActions('posDataAnalysis', ['postFilterConditionDesignation', 'postFilterShelfByShelf']),

            handlePage(pageNumb) {
                const queries = {...this.getUrlSetQuery()}
                queries.page = pageNumb.toString()
                this.handleReplaceUrl(queries)

                if (this.formName === 'condition-designation') this.postFilterConditionDesignation(
                    {params: queries, body: this.filteredData})
                if (this.formName === 'shelf-by-shelf') this.postFilterShelfByShelf(
                    {params: queries, body: this.filteredData})
            },

            getUrlSetQuery() {
                return this.$router.currentRoute.query
            },

            handleReplaceUrl(query) {
                if (!_.isEqual(this.$route.query, query)) {
                    this.$router.replace({query: query})
                }
            },
        },
    }
</script>

<style scoped>
    .m-0 {
        margin: 0
    }
</style>
