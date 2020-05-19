<template>
    <div class="login-box">
        <div class="login-logo">
            <a><b>TechHost</b> CMS</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">ID及びパスワードを入力し、ログインを押してください</p>

            <ValidationObserver v-slot="{ handleSubmit }">
            <form @submit.prevent="handleSubmit(submit)">
                <ValidationProvider name="ログインID" rules="required|min:3|max:100" v-slot="{ errors }">
                    <input
                        type="text"
                        class="form-control"
                        id="login_id"
                        name="ログインID"
                        v-model="inputData.login_id">
                    <span>{{ errors[0] }}</span>
                </ValidationProvider>


                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">ログイン</button>
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
                    login_id: null,
                    login_pw: null,
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
                        const name = res.typeAuth === 'admin' ? 'AdminDashboard' : 'AccountDashboard'
                        this.$router.push({name: name})
                    })
                } catch (e) {
                    this.isShow = false
                    this.$message.error('cc')
                }
            }
        },
    }
</script>
