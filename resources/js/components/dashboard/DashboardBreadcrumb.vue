<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="font-bold">
            <i class="fa fa-dashboard"></i> {{ $route.meta.title || 'Dashboard' }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <router-link
                tag="li"
                v-if="breadcrumbs"
                v-for="(item, index) in breadcrumbs"
                :key="index"
                :to="{name: item.nameRoute}"
                :class="item.active === 1 ? 'active disabled' : ''">
                <template v-if="item.active === 1">{{ item.name }}</template>
                <template v-else>
                    <a>{{item.name}}</a>
                </template>
            </router-link>

        </ol>
    </section>
</template>

<script>
    export default {
        name: 'DashboardBreadcrumb',

        data() {
            return {
                breadcrumbs: this.$route.meta.breadcrumb || null,
            }
        },
    }
</script>
