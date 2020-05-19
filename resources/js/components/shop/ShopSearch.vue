<template>
    <div class="box box-primary">
        <div class="box-body">
            <form role="search" method="get" @submit.prevent="handleSearch" @reset.prevent="handleReset">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="shop_code">店舗コード</label>
                        <input type="text"
                               name="shop_code"
                               class="form-control"
                               id="shop_code"
                               placeholder="店舗コードを入力してください"
                               v-model="inputData.search_shop_code">
                    </div>
                    <div class="col-sm-4">
                        <label for="shop_name">店舗名</label>
                        <input type="text"
                               name="shop_name"
                               class="form-control"
                               id="shop_name"
                               placeholder="店舗名を入力してください"
                               v-model="inputData.search_shop_name">
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
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: 'ShopSearch',

        data() {
            return {
                inputData: {
                    search_shop_code: this.$router.currentRoute.query.search_shop_code || '',
                    search_shop_name: this.$router.currentRoute.query.search_shop_name || '',
                },
            }
        },

        computed: {
            ...mapGetters('shops', {
                defaultQueries: 'getQueryParams',
            }),
        },

        methods: {
            ...mapActions('shops', ['getLists']),

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
                    search_shop_code: '',
                    search_shop_name: '',
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
        }
    }
</script>
