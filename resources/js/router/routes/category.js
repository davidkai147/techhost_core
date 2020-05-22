// import components
import Category from '../../pages/category/Category'
import Regist from '../../pages/category/Regist'
import Edit from '../../pages/category/Edit'

export default [
    {
        path: 'category',
        name: 'Category',
        component: Category,
        meta: {
            requiredAuth: true,
            title: '契約一覧',
            permission: ['SUPER_ADMIN', 'ADMIN'],
            breadcrumb: [
                {name: '契約一覧', nameRoute: 'Category', active: 1},
            ],
        },
    },
    {
        path: 'category/regist',
        name: 'CategoryRegist',
        component: Regist,
        meta: {
            requiredAuth: true,
            title: '契約登録',
            permission: ['SUPER_ADMIN', 'ADMIN'],
            breadcrumb: [
                {name: '契約一覧', nameRoute: 'Category', active: 0},
                {name: '契約登録', nameRoute: 'CategoryRegist', active: 1},
            ],
        },
    },
    {
        path: 'category/edit/:id',
        name: 'CategoryEdit',
        component: Edit,
        meta: {
            requiredAuth: true,
            title: '契約編集',
            permission: ['SUPER_ADMIN', 'ADMIN'],
            breadcrumb: [
                {name: '契約一覧', nameRoute: 'Category', active: 0},
                {name: '契約編集', nameRoute: 'CategoryEdit', active: 1},
            ],
        },
    }
]
