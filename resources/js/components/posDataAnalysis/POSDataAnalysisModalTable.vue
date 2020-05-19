<template>
    <section class="box-table">
        <div class="box-body">
            <table id="posDataAnalysisTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>店舗</th>
                    <th class="text-center">カテゴリ</th>
                    <th class="text-center">棚番号</th>
                    <th class="text-center">売上金額</th>
                    <th class="text-center">販売個数</th>
                </tr>
                </thead>
                <tbody v-if="list.length > 0">
                <tr v-for="(item, index) in list" :key="index">
                    <td>{{ item.shop_name ? item.shop_name : ' ' }}</td>
                    <td class="text-center">{{ item.jicfs_name }}</td>
                    <td class="text-center">{{ item.shelf_no }}</td>
                    <td class="text-center">{{ item.sales_amount | formatPrice }}</td>
                    <td class="text-center">{{ item.sales_quantity | formatPrice }}</td>
                </tr>
                </tbody>
                <tbody v-else align="center">
                <tr>
                    <td colspan="5" class="text-center col-xs-12">
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
        name: 'POSDataAnalysisModalTable',
        props: ['list'],
        components: {
            vPagination,
        },

        data() {
            return {
                page: 1,
            }
        },

        watch: {
            'dialogTableVisible'(val) {
                if (!val) this.page = 1
            },
        },

        computed: {
            ...mapGetters('posDataAnalysis', {
                pagination: 'pagination',
                defaultQueries: 'getQueryCategoryParams',
                dialogTableVisible: 'dialogTableVisible'
            }),
        },

        methods: {
            ...mapActions('posDataAnalysis', ['postFilterCategoryTable']),

            handlePage(pageNumb) {
                const params = {...this.defaultQueries};
                params.page = pageNumb;

                this.postFilterCategoryTable(params)
            }
        },
    }
</script>

<style scoped>
    .m-0 {
        margin: 0
    }
</style>
