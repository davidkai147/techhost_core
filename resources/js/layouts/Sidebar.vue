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
          <p class="long-and-truncated">{{currentUser.admin_name || currentUser.account_name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- /.search form -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <router-link v-if="isAdmin" tag="li" active-class="active disabled" :to="{name: 'AdminDashboard'}" class="treeview">
          <a>
            <i class="fa fa-dashboard"></i>
            <span>ダッシュボード</span>
          </a>
        </router-link>
        <li v-if="isAdmin" class="treeview"
            :class="{ 'active': $route.name === 'AdminPOSDataAnalysisCategory' || $route.name === 'AdminPOSDataAnalysisConditionDesignation' || $route.name === 'AdminPOSDataAnalysisShelfByShelf'}">
          <a>
            <i class="fa fa-database"></i>
            <span>POSデータ管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <router-link tag="li" active-class="active" :to="{name: 'AdminPOSDataAnalysisCategory'}"><a><i class="fa"></i> カテゴリ別分析</a></router-link>
            <router-link tag="li" active-class="active" :to="{name: 'AdminPOSDataAnalysisConditionDesignation'}"><a><i class="fa"></i> 店舗別条件指定分析</a></router-link>
            <router-link tag="li" active-class="active" :to="{name: 'AdminPOSDataAnalysisShelfByShelf'}"><a><i class="fa"></i> 棚別分析</a></router-link>
          </ul>
        </li>
        <router-link v-if="!isAdmin" tag="li" active-class="active disabled" :to="{name: 'AccountDashboard'}" class="treeview">
          <a>
            <i class="fa fa-dashboard"></i>
            <span>ダッシュボード</span>
          </a>
        </router-link>
        <li v-if="!isAdmin" class="treeview"
            :class="{ 'active': $route.name === 'AccountPOSDataAnalysisCategory' || $route.name === 'AccountPOSDataAnalysisConditionDesignation' || $route.name === 'AccountPOSDataAnalysisShelfByShelf'}">
          <a>
            <i class="fa fa-database"></i>
            <span>POSデータ管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <router-link tag="li" active-class="active" :to="{name: 'AccountPOSDataAnalysisCategory'}"><a><i class="fa"></i> カテゴリ別分析</a></router-link>
            <router-link tag="li" active-class="active" :to="{name: 'AccountPOSDataAnalysisConditionDesignation'}"><a><i class="fa"></i> 店舗別条件指定分析</a></router-link>
            <router-link tag="li" active-class="active" :to="{name: 'AccountPOSDataAnalysisShelfByShelf'}"><a><i class="fa"></i> 棚別分析</a></router-link>
          </ul>
        </li>
        <router-link v-if="isAdmin" tag="li" active-class="active disabled" :to="{name: 'Contract'}" class="treeview">
          <a>
            <i class="fa fa-files-o"></i>
            <span>契約管理</span>
          </a>
        </router-link>
        <router-link v-if="isAdmin" tag="li" active-class="active disabled" :to="{name: 'Account'}" class="treeview">
          <a>
            <i class="fa fa-user-o"></i>
            <span>アカウント管理</span>
          </a>
        </router-link>
        <router-link v-if="!isAdmin" tag="li" active-class="active disabled" :to="{name: 'Shop'}" class="treeview">
          <a>
            <i class="fa fa-building-o"></i>
            <span>店舗管理</span>
          </a>
        </router-link>
        <router-link v-if="!isAdmin" tag="li" active-class="active disabled" :to="{name: 'ShelfLocation'}"
                     class="treeview">
          <a>
            <i class="fa fa-barcode"></i>
            <span>棚位置管理</span>
          </a>
        </router-link>
        <router-link v-if="!isAdmin" tag="li" active-class="active disabled" :to="{name: 'POSDataItem'}">
          <a>
            <i class="fa fa-database"></i>
            <span>POSデータ管理</span>
          </a>
        </router-link>
        <router-link v-if="!isAdmin" tag="li" active-class="active disabled" :to="{name: 'POSDataAggregation'}"
                     class="treeview">
          <a>
            <i class="fa fa-database"></i>
            <span>POSデータ集計</span>
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

      isAdmin() {
        return Cookie.findByName('type') === 'admin'
      },
    },
    mounted() {
      // Fixed: Sidebar menu broken (Submenu cannot expand to access sub-menus)
      $('.sidebar-menu').tree();
    }
  }
</script>
