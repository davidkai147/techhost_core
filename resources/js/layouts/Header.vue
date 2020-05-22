<template>
    <header class="main-header">

        <!-- Logo -->
        <router-link tag="a" :to="{name: 'Shop'}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>TH</b>C</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>TechHost </b>LTE</span>
        </router-link>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="../assets/noavatarn.png" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{currentUser.name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="../assets/noavatarn.png" class="img-circle" alt="User Image">

                                <p>
                                    {{currentUser.email}}
                                    <small>{{currentUser.created_at}}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right" @click.prevent="logout">
                                    <a class="btn btn-default btn-flat">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex'
    import {Cookie} from '../util/cookie'

    export default {
        name: 'Header',

        computed: {
            ...mapGetters('auth', {
                currentUser: 'currentUser',
            }),

            isAdmin() {
                return Cookie.findByName('type') === 'admin'
            },
        },

        methods: {
            ...mapActions('auth', {
                logoutUser: 'logout',
            }),

            logout() {
                this.logoutUser().then((e) => {
                    this.$message.success(e.message)
                    this.$router.push({name: 'SignIn'})
                })
            },
        },
    }
</script>
