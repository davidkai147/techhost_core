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
                                <input type="text" class="form-control" id="name" name="name"
                                       v-model="inputData.name" placeholder="Input name"
                                       :disabled="$route.meta.method === 'update'">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="parent_id" class="col-xs-12 col-sm-3 control-label">Parent category</label>
                            <div class="shop-section col-xs-12 col-sm-8">
                                <el-select
                                    name="parent_id"
                                    id="parent_id"
                                    v-model="inputData.parent_id"
                                    remote
                                    placeholder="Please select category">
                                    <el-option :label="'No parent category'"
                                               :value="''">
                                    </el-option>
                                    <el-option v-for="item in categoryList"
                                               :key="item.id"
                                               :label="item.name"
                                               :value="item.id">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="icon" class="col-xs-12 col-sm-3 control-label">Icon</label>
                            <div class="shop-section col-xs-12 col-sm-8">
                                <el-select
                                    name="icon"
                                    id="icon"
                                    v-model="inputData.icon"
                                    remote
                                    placeholder="Please select icon">
                                    <el-option :label="'No icon'"
                                               :value="''">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-xs-12 col-sm-3 control-label">Status </label>
                            <div class="col-xs-12 col-sm-8">
                                <div class="checkbox">
                                    <el-switch
                                        id="status"
                                        name="status"
                                        v-model="inputData.is_key">
                                    </el-switch>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_feature" class="col-xs-12 col-sm-3 control-label">Is feature </label>
                            <div class="col-xs-12 col-sm-8">
                                <div class="checkbox">
                                    <el-switch
                                        id="is_feature"
                                        name="Is feature"
                                        v-model="inputData.is_feature">
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
                    <button type="button" class="btn btn-block btn-success" :disabled="!canSubmit">
                        <i class="fa fa-save"></i>
                        {{ this.$route.name === 'CategoryEdit' ? 'Update' : 'Register' }}
                    </button>

                    <button type="button" class="btn btn-block btn-default">
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
                    name: null,
                    description: null,
                    icon: null,
                    status: true,
                    is_feature: false,
                    parent_id: null
                },
            }
        },

        created() {
            if (!_.isEmpty(this.item)) {
                this.inputData = {...this.item}
            }

            this.getLists()
        },

        computed: {
            ...mapGetters('category', {
                item: 'item',
                categoryList: 'list'
            }),
        },

        methods: {
            ...mapActions('category', ['getItem', 'getLists', 'putItem', 'createItem']),

            handleSubmit() {
                this.canSubmit = false
                let data = {...this.inputData}
                if (this.$route.name === 'CategoryEdit') {
                    this.putItem(data).then((res) => {
                        this.$message.success('更新されました。')
                        this.$router.push({name: 'Category'})
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
