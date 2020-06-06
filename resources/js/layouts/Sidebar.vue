<template>
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="../assets/noavatarn.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info w-170">
                    <p class="long-and-truncated">{{currentUser.name}}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <router-link tag="li" active-class="active disabled" :to="{name: 'AdminDashboard'}" class="treeview">
                    <a>
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </router-link>
                <li class="treeview">
                    <a>
                        <i class="fa fa-database"></i>
                        <span>Users management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <router-link tag="li" active-class="active disabled" :to="{name: 'SignIn'}" class="treeview">
                            <a><i class="fa"></i> Users list</a>
                        </router-link>
                        <router-link tag="li" active-class="active" :to="{name: 'SignIn'}">
                            <a><i class="fa"></i> Permissions</a>
                        </router-link>
                        <router-link tag="li" active-class="active" :to="{name: 'SignIn'}">
                            <a><i class="fa"></i> Roles</a>
                        </router-link>
                    </ul>
                </li>
                <router-link tag="li" active-class="active disabled" :to="{name: 'Category'}" class="treeview">
                    <a>
                        <i class="fa fa-dashboard"></i>
                        <span>Categories</span>
                    </a>
                </router-link>
                <router-link tag="li" active-class="active disabled" :to="{name: 'SignIn'}" class="treeview">
                    <a>
                        <i class="fa fa-dashboard"></i>
                        <span>Posts</span>
                    </a>
                </router-link>
                <li class="treeview"
                    :class="{ 'active': $route.name === 'AdminPOSDataAnalysisCategory' || $route.name === 'AdminPOSDataAnalysisConditionDesignation' || $route.name === 'AdminPOSDataAnalysisShelfByShelf'}">
                    <a>
                        <i class="fa fa-database"></i>
                        <span>Tags menu</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <router-link tag="li" active-class="active disabled" :to="{name: 'SignIn'}" class="treeview">
                            <a><i class="fa"></i> Tags</a>
                        </router-link>
                        <router-link tag="li" active-class="active" :to="{name: 'AdminPOSDataAnalysisCategory'}">
                            <a><i class="fa"></i> Category tags</a>
                        </router-link>
                        <router-link tag="li" active-class="active" :to="{name: 'AdminPOSDataAnalysisConditionDesignation'}">
                            <a><i class="fa"></i> Post tags</a>
                        </router-link>
                    </ul>
                </li>
                <router-link tag="li" active-class="active disabled" :to="{name: 'SignIn'}" class="treeview">
                    <a>
                        <i class="fa fa-dashboard"></i>
                        <span>Pages</span>
                    </a>
                </router-link>
                <router-link tag="li" active-class="active disabled" :to="{name: 'SignIn'}" class="treeview">
                    <a>
                        <i class="fa fa-dashboard"></i>
                        <span>Blocks</span>
                    </a>
                </router-link>
                <router-link tag="li" active-class="active disabled" :to="{name: 'SignIn'}" class="treeview">
                    <a>
                        <i class="fa fa-dashboard"></i>
                        <span>Meta boxes</span>
                    </a>
                </router-link>
                <router-link tag="li" active-class="active disabled" :to="{name: 'SignIn'}" class="treeview">
                    <a>
                        <i class="fa fa-dashboard"></i>
                        <span>Settings</span>
                    </a>
                </router-link>
            </ul>
            <!-- /.sidebar -->
        </section>
    </aside>
</template>

<script>
    import {mapGetters} from 'vuex'
    import {Cookie} from '../util/cookie'

    export default {
        name: 'Sidebar',

        computed: {
            ...mapGetters('auth', {
                currentUser: 'currentUser',
            }),

            isSuperAdmin() {
                return Cookie.findByName('type') === 'SUPER_ADMIN'
            },
            isAdmin() {
                return Cookie.findByName('type') === 'ADMIN'
            }
        },
        mounted() {
            // Fixed: Sidebar menu broken (Submenu cannot expand to access sub-menus)
            $('.sidebar-menu').tree();
        }
    }
</script>
