<template>
    <div class="login-box">
        <div class="login-logo">
            <a><b>TechHost</b> CMS</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Please input your email and password</p>

            <ValidationObserver v-slot="{ handleSubmit }">
                <form @submit.prevent="handleSubmit(submit)">
                    <ValidationProvider name="ログインID" rules="required|min:3|max:100" v-slot="{ errors }">
                        <div class="form-group has-feedback" :class="{'has-error': errors[0]}">
                            <input
                                type="text"
                                class="form-control"
                                id="email"
                                placeholder="example@gmail.com"
                                name="ログインID"
                                v-model="inputData.email">
                            <span class="fa fa-user form-control-feedback"></span>
                            <span v-show="errors[0]" :class="{'help-block': errors[0] }">
                                {{ errors[0] }}
                            </span>
                        </div>
                    </ValidationProvider>

                    <ValidationProvider name="ログインパスワード" rules="required|min:3|max:100" v-slot="{ errors }">
                        <div class="form-group has-feedback" :class="{'has-error': errors[0]}">
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                placeholder="Please input password"
                                name="ログインパスワード"
                                v-model="inputData.password">
                            <span class="fa fa-user form-control-feedback"></span>
                            <span v-show="errors[0]" :class="{'help-block': errors[0] }">
                                {{ errors[0] }}
                            </span>
                        </div>
                    </ValidationProvider>

                    <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                    <div class="row">
                        <div class="col-xs-12">
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </ValidationObserver>
        </div>
        <!-- /.login-box-body -->
        <div class="overlay" :class="{show: isShow}">
            <img src="../assets/loading.gif" alt="loading">
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex'

    export default {
        name: 'SignIn',

        data() {
            return {
                inputData: {
                    email: null,
                    password: null,
                },
                isShow: false,
            }
        },
        methods: {
            ...mapActions('auth', ['login']),

            async submit() {
                let data = {...this.inputData}
                this.isShow = true

                try {
                    await this.login(data).then((res) => {
                        this.isShow = false
                        const name = res.typeAuth === 'SUPER_ADMIN' ? 'AdminDashboard' : 'AccountDashboard'
                        this.$router.push({name: name})
                    })
                } catch (e) {
                    this.isShow = false
                    this.$message.error(e.response.data.message)
                }
            }
        },
    }
</script>
