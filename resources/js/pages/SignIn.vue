<template>
    <div class="login-box">
        <div class="login-logo">
            <a><b>TechHost</b> CMS</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ $t('login.login_box') }}</p>
            <ValidationObserver v-slot="{ handleSubmit }">
                <a-form
                    id="components-form-demo-normal-login"
                    class="login-form"
                    @submit.prevent="handleSubmit(submit)"
                >
                    <a-form-item has-feedback validate-status="error" help="Ko dau">
                        <ValidationProvider name="ログインID" rules="required|email" v-slot="{ errors }">
                            <a-input :placeholder="$t('login.email_placeholder')" v-model="inputData.email">
                                <a-icon slot="prefix" type="user" style="color: rgba(0,0,0,.25)" />
                            </a-input>
                            <span v-show="errors[0]" :class="{'help-block': errors[0] }">
                                                                {{ errors[0] }}
                            </span>
                        </ValidationProvider>
                    </a-form-item>
                    <a-form-item>
                        <ValidationProvider name="ログインパスワード" rules="required|min:3|max:100" v-slot="{ errors }">
                            <a-input type="password" :placeholder="$t('login.password_placeholder')" v-model="inputData.password">
                                <a-icon slot="prefix" type="lock" style="color: rgba(0,0,0,.25)" />
                            </a-input>
                            <span v-show="errors[0]" :class="{'help-block': errors[0] }">
                                                                {{ errors[0] }}
                            </span>
                        </ValidationProvider>
                    </a-form-item>
                    <a-form-item>
                        <a-checkbox>
                            Remember me
                        </a-checkbox>
                        <a class="login-form-forgot" href="">
                            Forgot password
                        </a>
                        <a-button type="primary" html-type="submit" class="login-form-button">
                            {{ $t('login.login_button') }}
                        </a-button>
                        Or
                        <a href="">
                            register now!
                        </a>
                    </a-form-item>
                </a-form>

<!--                <form @submit.prevent="handleSubmit(submit)">-->
<!--                    <ValidationProvider name="ログインID" rules="required|min:3|max:100" v-slot="{ errors }">-->
<!--                        <div class="form-group has-feedback" :class="{'has-error': errors[0]}">-->
<!--                            <input-->
<!--                                type="text"-->
<!--                                class="form-control"-->
<!--                                id="email"-->
<!--                                :placeholder="$t('login.email_placeholder')"-->
<!--                                name="ログインID"-->
<!--                                v-model="inputData.email">-->
<!--                            <span class="fa fa-user form-control-feedback"></span>-->
<!--                            <span v-show="errors[0]" :class="{'help-block': errors[0] }">-->
<!--                                {{ errors[0] }}-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </ValidationProvider>-->

<!--                    <ValidationProvider name="ログインパスワード" rules="required|min:3|max:100" v-slot="{ errors }">-->
<!--                        <div class="form-group has-feedback" :class="{'has-error': errors[0]}">-->
<!--                            <input-->
<!--                                type="password"-->
<!--                                class="form-control"-->
<!--                                id="password"-->
<!--                                :placeholder="$t('login.password_placeholder')"-->
<!--                                name="ログインパスワード"-->
<!--                                v-model="inputData.password">-->
<!--                            <span class="fa fa-user form-control-feedback"></span>-->
<!--                            <span v-show="errors[0]" :class="{'help-block': errors[0] }">-->
<!--                                {{ errors[0] }}-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </ValidationProvider>-->

<!--                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ $t('login.login_button') }}</button>-->
<!--                    <div class="row">-->
<!--                        <div class="col-xs-12">-->
<!--                        </div>-->
<!--                        &lt;!&ndash; /.col &ndash;&gt;-->
<!--                    </div>-->
<!--                </form>-->
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
        beforeCreate() {
            this.form = this.$form.createForm(this, { name: 'normal_login' });
        },
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
<style>
    #components-form-demo-normal-login .login-form {
        max-width: 300px;
    }
    #components-form-demo-normal-login .login-form-forgot {
        float: right;
    }
    #components-form-demo-normal-login .login-form-button {
        width: 100%;
    }
</style>
