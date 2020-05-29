<template>
    <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
    <form @submit.prevent="handleSubmit(submit)" class="form-horizontal">
        <div class="row">
            <div class="col-xs-12 col-sm-9">

                <!-- Information -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form</h3>
                    </div>

                    <div class="box-body">
                            <div class="form-group">
                                <label for="device_name" class="col-xs-12 col-sm-3 control-label">Name <span
                                    class="required">*</span></label>
                                <ValidationProvider name="name" rules="required|min:3|max:100" v-slot="{ errors }">
                                    <div class="col-xs-12 col-sm-8 has-feedback" :class="{'has-error' : errors[0]}">
                                        <input type="text" class="form-control" id="name" name="name"
                                               v-model="inputData.name" placeholder="Input name"
                                               :disabled="$route.meta.method === 'update'">
                                        <span v-show="errors[0]" :class="{'help-block': errors[0] }">
                                                {{ errors[0] }}
                                </span>
                                    </div>

                                </ValidationProvider>
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
                                            v-model="inputData.status"
                                            :active-value="'active'"
                                            :inactive-value="'deactive'">
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
                                            v-model="inputData.is_featured"
                                            :active-value="1"
                                            :inactive-value="0">
                                        </el-switch>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment -->
                            <div class="form-group">
                                <label for="description" class="col-xs-12 col-sm-3 control-label">Description</label>
                                <ValidationProvider name="description" rules="required|min:3|max:5000"
                                                    v-slot="{ errors }">
                                    <div class="col-xs-12 col-sm-8 has-feedback" :class="{'has-error': errors[0]}">
                                        <textarea id="description"
                                                  name="description"
                                                  type="description"
                                                  class="form-control"
                                                  placeholder="Please input description"
                                                  v-model="inputData.description">
                                        </textarea>
                                        <span v-show="errors[0]" :class="{'help-block': errors[0] }">
                                                {{ errors[0] }}
                                            </span>
                                    </div>
                                </ValidationProvider>
                            </div>
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
                        <button type="submit" class="btn btn-block btn-success" :disabled="!canSubmit">
                            <i class="fa fa-save"></i>
                            {{ $route.name === 'CategoryEdit' ? 'Update' : 'Register' }}
                        </button>

                        <button @click="$router.go(-1)" type="button" id="reset" name="reset"
                                class="btn btn-block btn-default">
                            <i class="fa fa-caret-left"></i>
                            Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </ValidationObserver>
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
                    status: false,
                    is_featured: false,
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

            async submit() {
                this.canSubmit = false
                let data = {...this.inputData}
                try {
                    if (this.$route.name === 'CategoryEdit') {
                        await this.putItem(data).then((res) => {
                            this.$message.success(res.data.message)
                            this.$router.push({name: 'Category'})
                        })
                    } else {
                        await this.createItem(data).then((res) => {
                            this.$message.success(res.data.message)
                            this.$router.push({name: 'Category'})
                        })
                    }
                } catch(err) {
                    if (err.response.data && err.response.data.errors) {
                        _.forEach(err.response.data.errors, (item, field) => {
                            this.canSubmit = true
                            _.pickBy(this.$refs.observer.errors, (value, key) => {
                                if (field === key) value.push(item[0])
                            })

                        })
                    }
                }
            }
        },
    }
</script>
