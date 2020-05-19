<template>
    <form @submit.prevent="validateBeforeSubmit">
        <div class="row">
            <div class="col-sm-9 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group" :class="{'has-error': errors.has('契約')}">
                            <label class="control-label">契約 <span class="required">*</span></label>
                            <select class="form-control"
                                    name="契約"
                                    v-model="inputData.contract_id"
                                    v-validate="'required'">
                                <option disabled value="">選択してください</option>
                                <option
                                    v-for="(item, index) in list"
                                    :key="item.id"
                                    :value="item.id">
                                    {{ item.contract_name }}
                                </option>
                            </select>
                            <span v-show="errors.has('契約')" :class="{'help-block': errors.has('契約')}">
                {{ errors.first('契約') }}
              </span>
                        </div>
                        <div class="form-group" :class="{'has-error': errors.has('アカウント名')}">
                            <label>アカウント名 <span class="required">*</span></label>
                            <input
                                name="アカウント名"
                                type="text"
                                class="form-control"
                                placeholder="アカウント名を入力してください"
                                v-validate="'required|min:1|max:100'"
                                v-model="inputData.account_name">
                            <span v-show="errors.has('アカウント名')" :class="{'help-block': errors.has('アカウント名')}">
                {{ errors.first('アカウント名') }}
              </span>
                        </div>
                        <div class="form-group" :class="{'has-error': errors.has('ログインID')}">
                            <label>ログインID <span class="required">*</span></label>
                            <input
                                name="ログインID"
                                type="text"
                                class="form-control"
                                autocomplete="username"
                                placeholder="ログインIDを入力してください"
                                v-validate="'required|min:3|max:100|alpha_num'"
                                v-model="inputData.login_id">
                            <span v-show="errors.has('ログインID')" :class="{'help-block': errors.has('ログインID') }">
                  {{ errors.first('ログインID') }}
              </span>
                        </div>
                        <div class="form-group" :class="{'has-error': errors.has('ログインパスワード')}">
                            <label>ログインパスワード <span v-if="formAction === 'create'" class="required">*</span></label>
                            <input
                                name="ログインパスワード"
                                type="password"
                                class="form-control"
                                autocomplete="current-password"
                                placeholder="ログインパスワードを入力してください"
                                v-validate=" formAction === 'create' ? 'required|min:6|max:100' : 'min:6|max:100'"
                                v-model="inputData.login_pw"
                                ref="login_pw">
                            <span v-show="errors.has('ログインパスワード')" :class="{'help-block': errors.has('ログインパスワード') }">
                {{ errors.first('ログインパスワード') }}
              </span>
                        </div>
                        <div class="form-group" :class="{'has-error': errors.has('ログインパスワード確認')}">
                            <label>ログインパスワード確認 <span v-if="formAction === 'create'" class="required">*</span></label>
                            <input
                                name="ログインパスワード確認"
                                type="password"
                                autocomplete="new-password"
                                class="form-control"
                                placeholder="ログインパスワード確認を入力してください"
                                v-validate="formAction === 'create' || inputData.login_pw ? 'required|confirmed:login_pw' : 'confirmed:login_pw'"
                                v-model="inputData.confirm_login_pw">
                            <span v-show="errors.has('ログインパスワード確認')"
                                  :class="{'help-block': errors.has('ログインパスワード確認') }">
                {{ errors.first('ログインパスワード確認') }}
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
                            {{ $route.name === 'AccountRegist' ? '登録する' : '編集する'}}
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
        name: 'AccountForm',

        data() {
            return {
                method: this.$route.meta.method,
                canSubmit: true,
                inputData: {
                    account_name: null,
                    contract_id: '',
                    login_id: null,
                    login_pw: null,
                    confirm_login_pw: null,
                },
                formAction: null,
            }
        },

        created() {
            if (!_.isEmpty(this.detail)) {
                this.formAction = 'edit'
                this.inputData = {...this.detail}
            } else {
                this.formAction = 'create'
            }
        },

        computed: {
            ...mapGetters('accounts', {
                detail: 'item',
            }),
            ...mapGetters('contract', {
                list: 'list',
            }),
        },

        methods: {
            ...mapActions('accounts', ['getItem', 'putItem', 'createItem']),

            handleSubmit() {
                this.canSubmit = false

                let data = {...this.inputData}

                const id = data.id

                if (this.$route.name === 'AccountEdit') {
                    this.putItem({data, id}).then((res) => {
                        this.$message.success('更新されました。')
                        this.$router.push({name: 'Account'})
                    }).catch(e => {
                        this.canSubmit = true
                        this.$message.error(e.response.data.errors[0])
                    })
                } else {
                    this.createItem(data).then((res) => {
                        this.$message.success('登録しました。')
                        this.$router.push({name: 'Account'})
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
