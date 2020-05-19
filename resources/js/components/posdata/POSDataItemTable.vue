<template>
    <section class="box-table">
        <div class="box-body">
            <table id="contractTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>店舗</th>
                    <th class="text-center">販売日</th>
                    <th class="text-center">JANコード</th>
                    <th class="text-center">売上金額</th>
                    <th class="text-center">販売個数</th>
                    <th class="text-center">最終更新日時</th>
                </tr>
                </thead>
                <tbody v-if="list.length > 0">
                <tr v-for="(item, index) in list" :key="index">
                    <td>{{ item.shop ? item.shop.shop_name : ' ' }}</td>
                    <td class="text-center">{{item.sales_date}}</td>
                    <td class="text-center">{{item.jan_code}}</td>
                    <td class="text-center">{{ item.sales_amount | formatPrice }}</td>
                    <td class="text-center">{{ item.sales_quantity | formatPrice }}</td>
                    <td class="text-center">{{item.latest_at}}</td>
                </tr>
                </tbody>
                <tbody v-else align="center">
                <tr>
                    <td colspan="6" class="text-center col-xs-12">
                        <div class="no-result">検索結果はありません</div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex'

    export default {
        name: 'POSDataItemTable',

        computed: {
            ...mapGetters('posdataitem', {
                list: 'list',
            }),
        },
    }
</script>

<style scoped lang="scss">
    .box-table {
        height: calc(100vh - 400px);
        overflow: scroll;
    }
</style>
