// import components
import Contract from '../../pages/contract/Contract'
import Regist from '../../pages/contract/Regist'
import Edit from '../../pages/contract/Edit'

export default [
    {
        path: 'contract',
        name: 'Contract',
        component: Contract,
        meta: {
            requiredAuth: true,
            title: '契約一覧',
            permission: ['admin'],
            breadcrumb: [
                {name: '契約一覧', nameRoute: 'Contract', active: 1},
            ],
        },
    },
    {
        path: 'contract/regist',
        name: 'ContractRegist',
        component: Regist,
        meta: {
            requiredAuth: true,
            title: '契約登録',
            permission: ['admin'],
            breadcrumb: [
                {name: '契約一覧', nameRoute: 'Contract', active: 0},
                {name: '契約登録', nameRoute: 'ContractRegist', active: 1},
            ],
        },
    },
    {
        path: 'contract/edit/:id',
        name: 'ContractEdit',
        component: Edit,
        meta: {
            requiredAuth: true,
            title: '契約編集',
            permission: ['admin'],
            breadcrumb: [
                {name: '契約一覧', nameRoute: 'Contract', active: 0},
                {name: '契約編集', nameRoute: 'ContractEdit', active: 1},
            ],
        },
    }
]
