<template>
    <div>
        <section class="box-table">
            <div class="box-body">
                <table id="contractTable" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">店舗</th>
                        <th class="text-center">棚番号</th>
                        <th class="text-center">JANコード</th>
                        <th class="text-center">商品名</th>
                        <th class="text-center">JICFSコード</th>
                        <th class="text-center">JICFS名</th>
                        <th class="text-center">最終更新日時</th>
                    </tr>
                    </thead>
                    <tbody v-if="inputData.length > 0">
                    <tr v-for="(item, index) in inputData" :key="index + item.id">
                        <td class="text-center">{{ item.shop ? item.shop.shop_name : ' ' }}</td>
                        <td class="text-center">
                            <input :name="'棚番号' + item.id" type="text"
                                   class="form-control" v-model="inputData[index].shelf_no"
                                   v-validate="'required|max:100'"
                            />
                            <span v-show="errors.has('棚番号' + item.id)"
                                  :class="{'help-block': errors.has('棚番号' + item.id)}">
              {{ convertMessage(errors.first('棚番号' + item.id), item.id) }}
            </span>
                        </td>
                        <td class="text-center">
                            <input :name="'JANコード' + item.id" type="text"
                                   class="form-control" v-model="inputData[index].jan_code"
                                   v-validate="'required|max:100'"/>
                            <span v-show="errors.has('JANコード' + item.id)"
                                  :class="{'help-block': errors.has('JANコード' + item.id)}">
              {{ convertMessage(errors.first('JANコード' + item.id), item.id) }}
            </span>
                        </td>
                        <td class="text-center">
                            <input :name="'商品名' + item.id" type="text"
                                   class="form-control" v-model="inputData[index].item_name"
                                   v-validate="'required|max:100'"/>
                            <span v-show="errors.has('商品名' + item.id)"
                                  :class="{'help-block': errors.has('商品名' + item.id)}">
              {{ convertMessage(errors.first('商品名' + item.id), item.id) }}
            </span>
                        </td>
                        <td class="text-center">
                            <input :name="'JICFSコード' + item.id" type="text"
                                   class="form-control" v-model="inputData[index].jicfs_code"
                                   v-validate="'required|max:100'"/>
                            <span v-show="errors.has('JICFSコード' + item.id)"
                                  :class="{'help-block': errors.has('JICFSコード' + item.id)}">
              {{ convertMessage(errors.first('JICFSコード' + item.id), item.id) }}
            </span>
                        </td>
                        <td class="text-center">{{ inputData[index].jicfs_name }}</td>
                        <td class="text-center">{{ inputData[index].latest_at }}</td>
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
        </section>
        <div class="box-footer">
            <button class="btn btn-info" @click="downloadFile">
                <i class="fa fa-download mr-5"></i> CSVダウンロード
            </button>
            <button class="btn btn-primary" @click="update">
                <i class="fa fa-save mr-5"></i> 一括編集する
            </button>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'
    import {CSV} from '../../util/csv'

    export default {
        name: 'ShelfLocationTable',

        data() {
            return {
                canSubmit: true,
                page: parseInt(this.$router.currentRoute.query.page) || 1,
            }
        },

        watch: {
            list: {
                handler(newItem) {
                    this.inputData = [...newItem]
                },
            },
        },

        created() {

            let queries = this.getUrlSetQuery()

            if (_.keys(queries).length === 0) {
                queries = {...this.defaultQueries}
            }

            this.handleReplaceUrl(queries)
        },

        computed: {
            ...mapGetters('shelf', {
                inputData: 'list',
                defaultQueries: 'getQueryParams',
            }),
        },

        methods: {
            ...mapActions('shelf', [
                'getLists',
                'resetState',
                'downloadCSV',
                'batchUpdate',
            ]),

            getUrlSetQuery() {
                return this.$router.currentRoute.query
            },

            handleReplaceUrl(query) {
                if (!_.isEqual(this.$route.query, query)) {
                    this.$router.replace({query: query})
                }
            },

            // remove index in name of input
            convertMessage(message, id) {
                return message ? message.replace(id, '') : ''
            },

            update() {
                this.canSubmit = false
                let shelf_items = []

                this.$validator.validateAll().then((result) => {
                    if (result) {

                        _.forEach(this.inputData, shelf_item => {
                            shelf_item = _.omit(shelf_item, ['latest_at'])
                            shelf_items.push(shelf_item)
                        })

                        this.batchUpdate({shelf_items: shelf_items}).then((res) => {
                            this.getLists()
                            this.$message.success(res.data.message)
                            this.canSubmit = true
                        }).catch(err => {
                            const errors = err.response.data.errors
                            _.forEach(errors, error => {
                                this.errors.items.push({
                                    vmId: this.errors.vmId,
                                    field: this.inputName(error.field) + error.id,
                                    msg: error.message,
                                })
                            })
                            this.$message.error(err.response.data.message)
                            this.canSubmit = true
                        })
                    } else {
                        this.canSubmit = true
                    }
                })
            },

            inputName(field) {
                switch (field) {
                    case 'shelf_no':
                        return '棚番号'
                    case 'jan_code':
                        return 'JANコード'
                    case 'item_name':
                        return '商品名'
                }
            },

            downloadFile() {
                this.downloadCSV({...this.$router.currentRoute.query}).then((res) => {
                    CSV.convertToCSV(res.data)
                }).catch(err => {
                    this.$message.error(err.response.data.message)
                })
            },
        },

    }
</script>

<style scoped lang="scss">
    .help-block {
        color: #dd4b39;
    }

    .no-result {
        background: #fefefe;
        font-size: 30px;
        padding: 50px;
        color: #ccc;
    }

    .box-table {
        height: calc(100vh - 436px);
        overflow: scroll;
    }
</style>
