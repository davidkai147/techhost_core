// import components
import Account from '../../pages/account/Account'
import Regist from '../../pages/account/Regist'
import Edit from '../../pages/account/Edit'

export default [
    {
        path: 'account',
        name: 'Account',
        component: Account,
        meta: {
            requiredAuth: true,
            title: 'アカウント一覧',
            permission: ['admin'],
            breadcrumb: [
                {name: 'アカウント一覧', nameRoute: 'Account', active: 1},
            ],
        },
    },
    {
        path: 'account/regist',
        name: 'AccountRegist',
        component: Regist,
        meta: {
            requiredAuth: true,
            title: 'アカウント登録',
            permission: ['admin'],
            breadcrumb: [
                {name: 'アカウント一覧', nameRoute: 'Account', active: 0},
                {name: 'アカウント登録', nameRoute: 'AccountRegist', active: 1},
            ],
        },
    },
    {
        path: 'account/edit/:id',
        name: 'AccountEdit',
        component: Edit,
        meta: {
            requiredAuth: true,
            title: 'アカウント編集',
            permission: ['admin'],
            breadcrumb: [
                {name: 'アカウント一覧', nameRoute: 'Account', active: 0},
                {name: 'アカウント編集', nameRoute: 'AccountEdit', active: 1},
            ],
        },
    }
]
