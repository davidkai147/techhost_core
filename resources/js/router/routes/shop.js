// import components
import Shop from '../../pages/shop/Shop'
import Regist from '../../pages/shop/Regist'
import Edit from '../../pages/shop/Edit'

export default [
    {
        path: 'shop',
        name: 'Shop',
        component: Shop,
        meta: {
            requiredAuth: true,
            title: '店舗一覧',
            permission: ['account'],
            breadcrumb: [
                {name: '店舗一覧', nameRoute: 'Shop', active: 1},
            ],
        },
    },
    {
        path: 'shop/regist',
        name: 'ShopRegist',
        component: Regist,
        meta: {
            requiredAuth: true,
            title: '店舗登録',
            permission: ['account'],
            breadcrumb: [
                {name: '店舗一覧', nameRoute: 'Shop', active: 0},
                {name: '店舗登録', nameRoute: 'ShopRegist', active: 1},
            ],
        },
    },
    {
        path: 'shop/edit/:id',
        name: 'ShopEdit',
        component: Edit,
        meta: {
            requiredAuth: true,
            title: '店舗編集',
            permission: ['account'],
            breadcrumb: [
                {name: '店舗一覧', nameRoute: 'Shop', active: 0},
                {name: '店舗編集', nameRoute: 'ShopEdit', active: 1},
            ],
        },
    }
]
