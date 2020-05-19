<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h3 class="font-bold">
            <i class="fa fa-database"></i> {{ $route.meta.title || 'POSデータ分析' }}
        </h3>
        <ol class="breadcrumb">
            <li><i class="fa fa-dashboard"></i> ホーム</li>

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
        name: 'POSDataBreadcrumb',

        data() {
            return {
                breadcrumbs: this.$route.meta.breadcrumb || null,
            }
        },
    }
</script>
