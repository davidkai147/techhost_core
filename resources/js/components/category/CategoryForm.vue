<template>
    <form @submit.prevent="validateBeforeSubmit">
        <div class="row">
            <div class="col-sm-9 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group" :class="{'has-error': errors.has('契約名') }">
                            <label class="control-label">契約名<span class="required">*</span></label>
                            <input id="name"
                                   name="契約名"
                                   type="text"
                                   class="form-control"
                                   placeholder="契約名を入力してください"
                                   v-validate="'required|max:100'"
                                   v-model="inputData.contract_name">
                            <span v-show="errors.has('契約名')" :class="{'help-block': errors.has('契約名') }">
                                {{ errors.first('契約名') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <!-- Action Box -->
                <div class="box box-warning">
                    <div class="box-body">
                        <button type="submit" class="btn btn-block btn-success mr-5">
                            <i class="fa fa-save mr-5"></i>
                            {{ $route.name === 'ContractRegist' ? '登録する' : '編集する'}}
                        </button>
                        <button @click="$router.go(-1)" type="button" id="reset" name="reset"
                                class="btn btn-block btn-default">
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
    import {mapGetters, mapActions} from 'vuex'

    export default {
        name: 'ContractForm',

        data() {
            return {
                canSubmit: true,
                inputData: {
                    contract_name: null,
                },
            }
        },

        created() {
            if (!_.isEmpty(this.item)) {
                this.inputData = {...this.item}
            }
        },

        computed: {
            ...mapGetters('contract', {
                item: 'item',
            }),
        },

        methods: {
            ...mapActions('contract', ['getItem', 'putItem', 'createItem']),

            handleSubmit() {
                this.canSubmit = false
                let data = {...this.inputData}
                if (this.$route.name === 'ContractEdit') {
                    this.putItem(data).then((res) => {
                        this.$message.success('更新されました。')
                        this.$router.push({name: 'Contract'})
                    }).catch(e => {
                        this.canSubmit = true
                        this.$message.error(e.response.data.errors[0])
                    })
                } else {
                    this.createItem(data).then((res) => {
                        this.$message.success('登録しました。')
                        this.$router.push({name: 'Contract'})
                    }).catch(e => {
                        this.canSubmit = true
                        this.$message.error(e.response.data.errors[0])
                    })
                }
            },

            validateBeforeSubmit() {
                this.canSubmit = false
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.handleSubmit()
                    } else {
                        this.canSubmit = true
                    }
                })
            },
        },
    }
</script>
