<template>
    <div>
        <div class="box-body">
            <table id="contractTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th class="text-center"><input type="checkbox" name="selectedItems" /></th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Is featured</th>
                    <th class="text-center">Ordering</th>
                    <th class="text-center">Is default</th>
                    <th class="text-center">Latest at</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody v-if="list.length > 0">
                <template v-for="item in list">
                    <tr>
                        <td class="text-center"><input type="checkbox" name="selectedItems" /></td>
                        <td><p>{{ item.name }}</p></td>
                        <td><p>{{ item.description }}</p></td>
                        <td><p class="btn btn-block btn-success">{{ item.status }}</p></td>
                        <td><p>{{ item.is_featured }}</p></td>
                        <td><p>{{ item.ordering }}</p></td>
                        <td><p>{{ item.is_default }}</p></td>
                        <td class="text-center">{{item.latest_at}}</td>
                        <td class="text-center col-xs-2">
                            <router-link class="btn btn-block btn-primary" tag="li"
                                         :to="{ name: 'CategoryEdit', params: { id: item.id }}">
                                <i class="fa fa-edit mr-5"></i> Edit
                            </router-link>
                            <button @click="handleDelete(item.id)" class="btn btn-block btn-danger">
                                <i class="fa fa-trash-o mr-5"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr v-for="child in item.children">
                        <td class="text-center"><input type="checkbox" name="selectedItems" /></td>
                        <td><p>---- {{ child.name }}</p></td>
                        <td><p>{{ child.description }}</p></td>
                        <td><p class="btn btn-block btn-success">{{ item.status }}</p></td>
                        <td><p>{{ child.is_featured }}</p></td>
                        <td><p>{{ child.ordering }}</p></td>
                        <td><p>{{ child.is_default }}</p></td>
                        <td class="text-center">{{child.latest_at}}</td>
                        <td class="text-center col-xs-2">
                            <router-link class="btn btn-block btn-primary" tag="li"
                                         :to="{ name: 'CategoryEdit', params: { id: child.id }}">
                                <i class="fa fa-edit mr-5"></i> Edit
                            </router-link>
                            <button @click="handleDelete(child.id)" class="btn btn-block btn-danger">
                                <i class="fa fa-trash-o mr-5"></i> Delete
                            </button>
                        </td>
                    </tr>
                </template>
                </tbody>
                <tbody v-else align="center">
                <tr>
                    <td colspan="9" class="text-center col-xs-12">
                        <div class="no-result"><h2>There is no data.</h2></div>
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
        name: 'CategoryTable',
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
            ...mapGetters('category', {
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
            ...mapActions('category', [
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
                    return this.deleteItem(category)
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
