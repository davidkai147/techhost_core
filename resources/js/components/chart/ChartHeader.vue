<template>
    <div class="chart-title">
        <label class="box-title">{{title}} <span v-if="showDate">(対象期間：<span
            class="day-of-month">{{duration}}</span>)</span></label>

        <div class="box-tools pull-right" v-if="showPrevAndNextBtn">
            <button type="button" class="btn btn-box-tool" @click="prevMonth">＜＜前の月</button>
            <button type="button" class="btn btn-box-tool" @click="nextMonth">次の月＞＞</button>
        </div>
        <div class="clearfix"></div>
    </div>
</template>

<script>
    import moment from 'moment'

    export default {
        name: 'ChartHeader',
        props: ['name', 'title', 'showPrevAndNextBtn', 'showDate'],
        data() {
            return {
                duration: '',
                currentMonth: null
            }
        },
        created() {
            this.getCurrentMonth()
        },
        methods: {
            setStartAndEndDate(currentMonth) {
                const startOfMonth = moment(currentMonth, 'YYYY/MM/DD').startOf('month').format('MM月DD日');
                const endDayOfMonth = moment(currentMonth, 'YYYY/MM/DD').endOf('month').format('DD日');

                // Set date in header for chart
                this.duration = startOfMonth + `～` + endDayOfMonth;
            },
            getData(currentMonth) {
                this.$emit('get-data', currentMonth, this.name);
            },
            getCurrentMonth() {
                moment.locale('ja');
                this.currentMonth = moment(new Date(), 'YYYY/MM/DD').format('YYYY/MM/DD');
                this.setStartAndEndDate(this.currentMonth);
            },
            prevMonth() {
                const prevDate = moment(this.currentMonth, 'YYYY/MM/DD').subtract(1, 'months').startOf('month').format('YYYY/MM/DD');
                this.currentMonth = prevDate;
                this.setStartAndEndDate(this.currentMonth);
                this.getData(prevDate);
            },
            nextMonth() {
                const nextDate = moment(this.currentMonth, 'YYYY/MM/DD').add(1, 'months').endOf('month').format('YYYY/MM/DD');
                this.currentMonth = nextDate;
                this.setStartAndEndDate(this.currentMonth);
                this.getData(nextDate);
            }
        },
    }
</script>

<style lang="scss" scoped>
    .chart-title {
        .btn-box-tool {
            padding: 0 5px;
        }

        .box-title {
            font-size: 14px;
            color: #5F6368;
            line-height: 20px;
            font-weight: bold;
        }

        .day-of-month {
            color: #1A73E8;
        }
    }

</style>
