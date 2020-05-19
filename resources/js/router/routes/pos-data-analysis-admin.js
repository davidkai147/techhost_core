import POSDataAnalysisCategory from '../../pages/posDataAnalysis/POSDataAnalysisCategory'
import POSDataAnalysisConditionDesignation from '../../pages/posDataAnalysis/POSDataAnalysisConditionDesignation'
import POSDataAnalysisShelfByShelf from '../../pages/posDataAnalysis/POSDataAnalysisShelfByShelf'

export default [
    {
        path: 'pos-analysis/category',
        name: 'AdminPOSDataAnalysisCategory',
        component: POSDataAnalysisCategory,
        meta: {
            requiredAuth: true,
            title: 'POSデータ管理 - カテゴリ別分析',
            permission: ['admin'],
            breadcrumb: [
                {name: 'カテゴリ別分析', nameRoute: 'AdminPOSDataAnalysisCategory', active: 1},
            ],
        },
    },
    {
        path: 'pos-analysis/condition-designation',
        name: 'AdminPOSDataAnalysisConditionDesignation',
        component: POSDataAnalysisConditionDesignation,
        meta: {
            requiredAuth: true,
            title: 'POSデータ管理 - 店舗別条件指定分析',
            permission: ['admin'],
            breadcrumb: [
                {name: '店舗別条件指定分析', nameRoute: 'AdminPOSDataAnalysisConditionDesignation', active: 1},
            ],
        },
    },
    {
        path: 'pos-analysis/shelf-by-shelf',
        name: 'AdminPOSDataAnalysisShelfByShelf',
        component: POSDataAnalysisShelfByShelf,
        meta: {
            requiredAuth: true,
            title: 'POSデータ管理 - 棚別分析',
            permission: ['admin'],
            breadcrumb: [
                {name: '棚別分析', nameRoute: 'AdminPOSDataAnalysisShelfByShelf', active: 1},
            ],
        },
    }
]
