<template>
    <div class="box box-primary box-search">
        <div class="box-body">
            <form role="search" method="get" @submit.prevent="handleSearch" @reset.prevent="handleReset">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="shop_id">店舗</label>
                                <select name="shop_id" id="shop_id" class="form-control"
                                        v-model="inputData.search_shop_id">
                                    <option value="" disabled>店舗を選択してください</option>
                                    <option v-for="item in list" :value="item.id">{{ item.shop_name }}</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="shelf_no">棚番号</label>
                                <input
                                    type="text"
                                    name="shelf_no"
                                    class="form-control"
                                    id="shelf_no"
                                    placeholder="棚番号を入力してください"
                                    v-model="inputData.search_shelf_no">
                            </div>
                            <div class="col-sm-6">
                                <label for="jan_code">JANコード</label>
                                <input
                                    type="text"
                                    name="jan_code"
                                    class="form-control"
                                    id="jan_code"
                                    placeholder="JANコードを入力してください"
                                    v-model="inputData.search_jan_code">
                            </div>
                            <div class="col-sm-6">
                                <label for="login_name">商品名</label>
                                <input
                                    type="text"
                                    name="login_name"
                                    class="form-control"
                                    id="login_name"
                                    placeholder="商品名を入力してください"
                                    v-model="inputData.search_item_name">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="submit">&nbsp;</label>
                                <button type="submit" id="submit" name="search" class="btn btn-block btn-primary">
                                    <i class="fa fa-search"></i>
                                    検索する
                                </button>
                            </div>

                            <div class="col-sm-6">
                                <label for="reset">&nbsp;</label>
                                <button type="reset" id="reset" name="reset" class="btn btn-block btn-default">
                                    <i class="fa fa-refresh"></i>
                                    リセット
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: 'ShelfLocationSearch',

        data() {
            return {
                inputData: {
                    search_shop_id: this.$router.currentRoute.query.search_shop_id || '',
                    search_shelf_no: this.$router.currentRoute.query.search_shelf_no || '',
                    search_jan_code: this.$router.currentRoute.query.search_jan_code || '',
                    search_item_name: this.$router.currentRoute.query.search_item_name || '',
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
            ...mapActions('shelf', ['resetState', 'getLists']),

            handleSearch() {
                // get new list
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
                    search_shelf_no: '',
                    search_jan_code: '',
                    search_item_name: '',
                }
            },

            getUpdateQuery() {
                const params = Object.assign(this.defaultQueries, this.inputData)

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
