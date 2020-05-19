<template>
    <form @submit.prevent="validateBeforeSubmit">
        <div class="row">
            <div class="col-sm-9 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group" :class="{'has-error': errors.has('店舗コード')}">
                            <label for="shop_code">店舗コード <span class="required">*</span></label>
                            <input
                                id="shop_code"
                                name="店舗コード"
                                type="text"
                                class="form-control"
                                placeholder="店舗コードを入力してください"
                                v-validate="{required: true,min:1,max:100,regex: /^([A-Za-z0-9 ]+)$/}"
                                v-model="inputData.shop_code">
                            <span v-show="errors.has('店舗コード')" :class="{'help-block': errors.has('店舗コード')}">
                {{ errors.first('店舗コード') }}
              </span>
                        </div>
                        <div class="form-group" :class="{'has-error': errors.has('店舗名')}">
                            <label for="shop_name">店舗名 <span class="required">*</span></label>
                            <input
                                id="shop_name"
                                name="店舗名"
                                type="text"
                                class="form-control"
                                placeholder="店舗名を入力してください"
                                v-validate="{required: true,min:1,max:100 }"
                                v-model="inputData.shop_name">
                            <span v-show="errors.has('店舗名')" :class="{'help-block': errors.has('店舗名')}">
                {{ errors.first('店舗名') }}
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
                            {{ $route.name === 'ShopRegist' ? '登録する' : '編集する'}}
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
        name: 'ShopForm',

        data() {
            return {
                canSubmit: true,
                inputData: {
                    shop_code: null,
                    shop_name: null,
                },
            }
        },

        created() {
            if (this.$route.name === 'ShopRegist') {
                this.inputData = {...this.inputData}
            }
            if (this.$route.name === 'ShopEdit') {
                this.inputData = this.detail
            }
        },

        computed: {
            ...mapGetters('shops', {
                detail: 'item',
            }),
        },

        methods: {
            ...mapActions('shops', ['putItem', 'createItem']),

            handleSubmit() {
                let shopData = {...this.inputData}

                const id = shopData.id

                if (this.$route.name === 'ShopEdit') {
                    this.putItem({shopData, id}).then((res) => {
                        this.$message.success('更新されました。')
                        this.$router.push({name: 'Shop'})
                    }).catch(e => {
                        this.canSubmit = true
                        this.$message.error(e.response.data.errors[0])
                    })
                } else {
                    this.createItem(shopData).then((res) => {
                        this.$message.success('登録しました。')
                        this.$router.push({name: 'Shop'})
                    }).catch((e) => {
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
