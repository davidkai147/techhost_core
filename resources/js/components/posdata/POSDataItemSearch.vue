<template>
    <div class="box box-primary">
        <div class="box-body">
            <form role="search" method="get" @submit.prevent="handleSearch" @reset.prevent="handleReset">
                <div class="row">
                    <div class="col-sm-2">
                        <label for="店舗">店舗</label>
                        <select name="search_shop_id" id="店舗" class="form-control"
                                v-model="inputData.search_shop_id">
                            <option value="">選択してください</option>
                            <option
                                v-for="(item, index) in list"
                                :key="item.id"
                                :value="item.id">
                                {{ item.shop_name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="販売日">販売日</label>
                        <el-date-picker
                            v-model="inputData.search_sales_date"
                            type="date"
                            placeholder="販売日を選択してください"
                            style="width:100%"
                            size="small"
                            value-format="yyyy-MM-dd">
                        </el-date-picker>
                    </div>
                    <div class="col-sm-3">
                        <label for="JANコード">JANコード</label>
                        <input
                            type="text"
                            name="search_jan_code"
                            class="form-control"
                            id="JANコード"
                            placeholder="JANコードを入力してください"
                            v-model="inputData.search_jan_code">
                    </div>
                    <div class="col-sm-2">
                        <label for="submit">&nbsp;</label>
                        <button type="submit" id="submit" name="search" class="btn btn-block btn-primary">
                            <i class="fa fa-search"></i>
                            検索する
                        </button>
                    </div>
                    <div class="col-sm-2">
                        <label for="reset">&nbsp;</label>
                        <button type="reset" id="reset" name="reset" class="btn btn-block btn-default">
                            <i class="fa fa-refresh"></i>
                            リセット
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>


<script>
    import {mapGetters, mapActions} from 'vuex'

    export default {
        name: 'POSDataItemSearch',

        data() {
            return {
                inputData: {
                    search_shop_id: this.$router.currentRoute.query.search_shop_id || '',
                    search_sales_date: this.$router.currentRoute.query.search_sales_date || '',
                    search_jan_code: this.$router.currentRoute.query.search_jan_code || '',
                    with: 'shop',
                },
            }
        },

        computed: {
            ...mapGetters('shops', {
                list: 'list',
                defaultQueries: 'getQueryParams',
            }),
        },

        methods: {
            ...mapActions('posdataitem', ['getLists']),

            handleSearch() {
                // get new list
                const queries = this.getUpdateQuery()
                queries.page = 1
                this.getLists(this.getUpdateQuery())
            },

            handleReset() {
                this.resetInputData()

                // get new list
                this.handleSearch()
            },

            resetInputData() {
                this.inputData = {
                    search_shop_id: '',
                    search_sales_date: '',
                    search_jan_code: '',
                    with: 'shop',
                }
            },

            getUpdateQuery() {
                const params = this.inputData
                this.handleReplaceUrl(params)

                return params
            },

            handleReplaceUrl(query) {
                if (!_.isEqual(this.$route.query, query)) {
                    this.$router.replace({query: query})
                }
            },
        },
    }
</script>
