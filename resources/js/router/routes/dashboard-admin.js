// import components
import Dashboard from '../../pages/dashboard/Dashboard'

export default [
    {
        path: 'dashboard',
        name: 'AdminDashboard',
        component: Dashboard,
        meta: {
            requiredAuth: true,
            title: 'ダッシュボード',
            permission: ['admin'],
            breadcrumb: [
                {name: 'ダッシュボード', nameRoute: 'AdminDashboard', active: 1},
            ],
        },
    }
]

