<template>
    <form action="post" @submit.prevent="validateBeforeSubmit">
        <div class="row">
            <div class="col-sm-9 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group" :class="{'has-error': errors.has('店舗')}">
                            <label class="control-label" for="shop_id">店舗<span class="required">*</span></label>
                            <select class="form-control" name="店舗" id="shop_id"
                                    v-model="inputData.shop_id"
                                    v-validate="'required'"
                                    @change="canSubmit = true">
                                <option value="">選択してください</option>
                                <option v-for="item in list" :value="item.id">{{ item.shop_name }}</option>
                            </select>
                            <span v-show="errors.has('店舗')" :class="{'help-block': errors.has('店舗')}">
                {{ errors.first('店舗') }}
              </span>
                        </div>
                        <div class="form-group" :class="{'has-error': errors.has('CSVファイル')}">
                            <label for="csv_file">CSVファイル<span class="required">*</span></label>
                            <input id="csv_file"
                                   name="CSVファイル"
                                   type="file"
                                   class="form-control"
                                   ref='upload'
                                   accept=".csv"
                                   v-validate="'required'"
                                   @click="$refs.upload.value = ''"
                                   @change="canSubmit = true">
                            <span v-show="errors.has('CSVファイル')" :class="{'help-block': errors.has('CSVファイル')}">
                {{ errors.first('CSVファイル') }}
              </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <!-- Action Box -->
                <div class="box box-warning">
                    <div class="box-body">
                        <button type="submit" class="btn btn-block btn-success mr-5" :disabled="!canSubmit">
                            <i class="fa fa-save mr-5"></i>
                            取込を実行する
                        </button>
                        <button type="button" id="cancel" name="cancel" class="btn btn-block btn-default"
                                @click="backToShelfList">
                            <i class="fa fa-caret-left"></i>
                            前の画面に戻る
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: 'ShelfLocationForm',

        data() {
            return {
                canSubmit: true,
                inputData: {
                    shop_id: '',
                },
            }
        },

        computed: {
            ...
                mapGetters('shops', ['list']),
        },

        methods: {
            ...mapActions('shelf', {
                uploadCSV: 'uploadCSV',
            }),

            handleSubmit() {
                let formData = new FormData()
                const listFiles = this.$refs.upload.files

                formData.append('csv_file', listFiles[0])
                formData.append('shop_id', this.inputData.shop_id)

                this.uploadCSV(formData).then(res => {
                    this.$message.success(res.data.message)
                    this.backToShelfList()
                }).catch(err => {
                    if (err.response.data && err.response.data.errors && err.response.data.errors.length > 0) {
                        _.forEach(err.response.data.errors, error => {
                            this.canSubmit = false
                            this.$message.error(error)
                        })
                    }
                })
            },

            validateBeforeSubmit() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.handleSubmit()
                    }
                })
            },

            backToShelfList() {
                this.$router.push({name: 'ShelfLocation'})
            },
        },
    }
</script>
