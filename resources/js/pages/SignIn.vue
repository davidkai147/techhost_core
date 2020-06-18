<template>
    <div class="login-box">
        <div class="login-logo">
            <a><b>TechHost</b> CMS</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ $t('login.login_box') }}</p>
            <ValidationObserver ref="observer" v-slot="{ passes }">
                <a-form id="components-form-demo-normal-login" class="login-form">
                    <InputWithValidation
                        v-model="inputData.email"
                        rules="required|email"
                        v-bind:name="$t('login.email')"
                        icon="user"
                        :placeholder="$t('login.email_placeholder')"
                    />
                    <InputWithValidation
                        v-model="inputData.password"
                        type="password"
                        rules="required"
                        v-bind:name="$t('login.password')"
                        icon="lock"
                        :placeholder="$t('login.password_placeholder')"
                        vid="password"
                    />

                    <a-form-item>
                        <a-checkbox>
                            Remember me
                        </a-checkbox>
                        <a class="login-form-forgot" href="">
                            Forgot password
                        </a>
                        <a-button type="primary" @click="passes(submit)" html-type="submit" class="login-form-button">
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
            <Loader/>
    </div>
</template>

<script>
    import {mapActions} from 'vuex'
    import InputWithValidation from '../components/shared/InputWithValidation'
    import Loader from '../components/shared/Loader'

    export default {
        name: 'SignIn',
        components: {
            InputWithValidation,
            Loader
        },
        beforeCreate() {
            this.form = this.$form.createForm(this, { name: 'normal_login' });
        },
        data() {
            return {
                inputData: {
                    email: null,
                    password: null,
                },
                isShow: true,
            }
        },
        methods: {
            ...mapActions('auth', ['login']),

            async submit() {
                let data = {...this.inputData}
                this.isShow = true

                try {
                    await this.login(data).then((res) => {
                        //this.isShow = false
                        const name = res.typeAuth === 'SUPER_ADMIN' ? 'AdminDashboard' : 'AccountDashboard'
                        this.$router.push({name: name})
                    })
                } catch (e) {
                    //this.isShow = false
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
    .has-feedback {
        margin-bottom: 0px!important;
    }
</style>
