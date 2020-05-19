// import components
import Dashboard from '../../pages/dashboard/Dashboard'

export default [
    {
        path: 'dashboard',
        name: 'AccountDashboard',
        component: Dashboard,
        meta: {
            requiredAuth: true,
            title: 'ダッシュボード',
            permission: ['account'],
            breadcrumb: [
                {name: 'ダッシュボード', nameRoute: 'AccountDashboard', active: 1},
            ],
        },
    }
]

