import POSDataAnalysisCategory from '../../pages/posDataAnalysis/POSDataAnalysisCategory'
import POSDataAnalysisConditionDesignation from '../../pages/posDataAnalysis/POSDataAnalysisConditionDesignation'
import POSDataAnalysisShelfByShelf from '../../pages/posDataAnalysis/POSDataAnalysisShelfByShelf'

export default [
    {
        path: 'pos-analysis/category',
        name: 'AccountPOSDataAnalysisCategory',
        component: POSDataAnalysisCategory,
        meta: {
            requiredAuth: true,
            title: 'POSデータ管理 - カテゴリ別分析',
            permission: ['account'],
            breadcrumb: [
                {name: 'カテゴリ別分析', nameRoute: 'AccountPOSDataAnalysisCategory', active: 1},
            ],
        },
    },
    {
        path: 'pos-analysis/condition-designation',
        name: 'AccountPOSDataAnalysisConditionDesignation',
        component: POSDataAnalysisConditionDesignation,
        meta: {
            requiredAuth: true,
            title: 'POSデータ管理 - 店舗別条件指定分析',
            permission: ['account'],
            breadcrumb: [
                {name: '店舗別条件指定分析', nameRoute: 'AccountPOSDataAnalysisConditionDesignation', active: 1},
            ],
        },
    },
    {
        path: 'pos-analysis/shelf-by-shelf',
        name: 'AccountPOSDataAnalysisShelfByShelf',
        component: POSDataAnalysisShelfByShelf,
        meta: {
            requiredAuth: true,
            title: 'POSデータ管理 - 棚別分析',
            permission: ['account'],
            breadcrumb: [
                {name: '棚別分析', nameRoute: 'AccountPOSDataAnalysisShelfByShelf', active: 1},
            ],
        },
    }
]
