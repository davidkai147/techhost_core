<template>
    <div class="box box-primary">
        <div class="box-body">
            <form role="search" method="get" @submit.prevent="handleSearch" @reset.prevent="handleReset">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="name">契約名</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            id="name"
                            placeholder="契約名を入力してください"
                            v-model="inputData.search_contract_name">
                    </div>
                    <div class="col-sm-3">
                        <label for="name">アカウント名</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            id="nameAccount"
                            placeholder="アカウント名を入力してください"
                            v-model="inputData.search_account_name">
                    </div>
                    <div class="col-sm-2">
                        <label for="id">ログインID</label>
                        <input
                            type="text"
                            name="id"
                            class="form-control"
                            id="id"
                            placeholder="ログインIDを入力してください"
                            v-model="inputData.search_login_id">
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
        name: 'AccountSearch',

        data() {
            return {
                inputData: {
                    search_contract_name: this.$router.currentRoute.query.search_contract_name || '',
                    search_account_name: this.$router.currentRoute.query.search_account_name || '',
                    search_login_id: this.$router.currentRoute.query.search_login_id || '',
                },
            }
        },

        computed: {
            ...mapGetters('accounts', {
                defaultQueries: 'getQueryParams',
            }),
        },

        methods: {
            ...mapActions('accounts', ['getLists']),

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
                    search_contract_name: '',
                    search_account_name: '',
                    search_login_id: '',
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
