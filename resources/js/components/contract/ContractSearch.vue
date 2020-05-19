<template>
    <div>
        <div class="box box-primary">
            <div class="box-body">
                <form role="search" method="get" @submit.prevent="handleSearch" @reset.prevent="handleReset">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="search_contract_name">契約名</label>
                            <input type="text" name="search_contract_name" class="form-control"
                                   id="search_contract_name"
                                   placeholder="契約名を入力してください" v-model="inputData.search_contract_name">
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
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: 'ContractSearch',

        data() {
            return {
                inputData: {
                    search_contract_name: this.$router.currentRoute.query.search_contract_name || '',
                },
            }
        },

        computed: {
            ...mapGetters('contract', {
                defaultQueries: 'getQueryParams',
            }),
        },

        methods: {
            ...mapActions('contract', ['getLists']),

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
