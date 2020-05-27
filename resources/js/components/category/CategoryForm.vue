<template>
    <div class="row">
        <div class="col-xs-12 col-sm-9">

            <!-- Information -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Form</h3>
                </div>

                <div class="box-body">
                    <form class="form-horizontal">
                        <div class="form-group" >
                            <label for="device_name" class="col-xs-12 col-sm-3 control-label">Name <span
                                class="required">*</span></label>
                            <div class="col-xs-12 col-sm-8">
                                <input v-validate="'required|max:128'" type="text" class="form-control" id="device_code" name="シリアル番号"
                                       v-model="inputData.device_code" placeholder="Input name"
                                       :disabled="$route.meta.method === 'update'">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shop" class="col-xs-12 col-sm-3 control-label">Parent category</label>
                            <div class="shop-section col-xs-12 col-sm-8">
                                <el-select
                                    name="店舗名"
                                    id="shop"
                                    v-model="inputData.shop_id"
                                    remote
                                    placeholder="Please select category">
                                    <el-option :label="'店舗が存在しません'"
                                               :value="''">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="is_key" class="col-xs-12 col-sm-3 control-label">Status </label>
                            <div class="col-xs-12 col-sm-8">
                                <div class="checkbox">
                                    <el-switch
                                        id="is_key"
                                        name="登録キー発行"
                                        v-model="inputData.is_key"
                                        active-color="#13ce66"
                                        inactive-color="#ff4949">
                                    </el-switch>
                                </div>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div class="form-group" >
                            <label for="comment" class="col-xs-12 col-sm-3 control-label">Description</label>
                            <div class="col-xs-12 col-sm-8">
                <textarea id="comment"
                          name="コメント"
                          type="text"
                          class="form-control"
                          placeholder="Please input description"
                          v-validate="'max:5000'"
                          v-model="inputData.comment">
                </textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-sm-3 col-xs-12">
            <!-- Action Box -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Action</h3>
                </div>

                <div class="box-body">
                    <button @click="submit" type="button" class="btn btn-block btn-success" :disabled="!canSubmit">
                        <i class="fa fa-save"></i>
                        {{ formAction === 'edit' ? 'Update' : 'Register' }}
                    </button>

                    <button @click="handleCancel" type="button" class="btn btn-block btn-default">
                        <i class="fa fa-caret-left"></i>
                        Back
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex'

    export default {
        name: 'CategoryForm',

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
            ...mapGetters('category', {
                item: 'item',
            }),
        },

        methods: {
            ...mapActions('category', ['getItem', 'putItem', 'createItem']),

            handleSubmit() {
                this.canSubmit = false
                let data = {...this.inputData}
                if (this.$route.name === 'CategoryEdit') {
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
                        this.$router.push({name: 'Category'})
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
