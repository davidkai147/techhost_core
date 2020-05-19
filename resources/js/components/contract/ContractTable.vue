<template>
    <div>
        <div class="box-body">
            <table id="contractTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>契約名</th>
                    <th class="text-center">最終更新日時</th>
                    <th class="text-center">操作</th>
                </tr>
                </thead>
                <tbody v-if="list.length > 0">
                <tr v-for="(item, index) in list" :key="index">
                    <td><p>{{item.contract_name}}</p></td>
                    <td class="text-center">{{item.latest_at}}</td>
                    <td class="text-center col-xs-2">
                        <router-link class="btn btn-xs btn-primary" tag="li"
                                     :to="{ name: 'ContractEdit', params: { id: item.id }}">
                            <i class="fa fa-edit mr-5"></i> 編集
                        </router-link>
                        <button @click="handleDelete(item.id)" class="btn btn-xs btn-danger">
                            <i class="fa fa-trash-o mr-5"></i> 削除
                        </button>
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
                class="pull-right"
                :page-count="paginator.totalPages"
                :page-range="5"
                :margin-pages="2"
                :click-handler="handlePage"
                :prev-text="'前へ'"
                :next-text="'次へ'"
                :container-class="'pagination'"
                :page-class="'page-item'">
            </vPagination>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex'
    import vPagination from 'vuejs-paginate'

    export default {
        name: 'ContractTable',
        components: {
            vPagination,
        },

        data() {
            return {
                page: parseInt(this.$router.currentRoute.query.page) || 1,
            }
        },

        created() {
            let queries = this.getUrlSetQuery()

            if (_.keys(queries).length === 0) {
                queries = {...this.defaultQueries}
            }

            this.handleReplaceUrl(queries)
        },

        computed: {
            ...mapGetters('contract', {
                list: 'list',
                paginator: 'paginator',
                defaultQueries: 'getQueryParams',
            }),
        },

        watch: {
            '$route.query.page'(val) {
                this.page = +val
            },
        },

        methods: {
            ...mapActions('contract', [
                'getLists',
                'resetState',
                'deleteItem',
            ]),

            handleDelete(contractId) {
                this.$confirm('削除しますか？', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'キャンセル',
                    type: 'warning',
                }).then(() => {
                    // do action call api
                    return this.deleteItem(contractId)
                }).then(() => {
                    // alert message
                    this.$message.success('削除しました')

                    // reload
                    this.handlePage(1)
                }).catch((err) => {
                    console.log(err)
                })
            },

            handlePage(pageNumb) {
                const queries = {...this.getUrlSetQuery()}

                queries.page = pageNumb.toString()

                this.handleReplaceUrl(queries)

                this.getLists(queries)
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
