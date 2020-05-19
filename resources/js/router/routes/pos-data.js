// import components


import POSDataAggregation from '../../pages/posdata/POSDataAggregation'
import POSDataItem from '../../pages/posdata/POSDataItem'
import POSDataCSVImport from '../../pages/posdata/POSDataCSVImport'

export default [
    {
        path: 'pos/analytics',
        name: 'POSDataAggregation',
        component: POSDataAggregation,
        meta: {
            requiredAuth: true,
            title: 'POSデータ集計',
            permission: ['account'],
            breadcrumb: [
                {name: 'POSデータ集計', nameRoute: 'POSDataAggregation', active: 1},
            ],
        },
    },
    {
        path: 'pos/item',
        name: 'POSDataItem',
        component: POSDataItem,
        meta: {
            requiredAuth: true,
            title: 'POSデータ一覧',
            permission: ['account'],
            breadcrumb: [
                {name: 'POSデータ一覧', nameRoute: 'POSDataItem', active: 1},
            ],
        },
    },
    {
        path: 'pos/import',
        name: 'POSDataCSVImport',
        component: POSDataCSVImport,
        meta: {
            requiredAuth: true,
            title: 'POSデータCSV取込',
            permission: ['account'],
            breadcrumb: [
                {name: 'POSデータCSV取込', nameRoute: 'POSDataCSVImport', active: 1},
            ],
        },
    },
]
