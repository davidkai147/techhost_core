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
            permission: ['SUPER_ADMIN', 'ADMIN', 'USER'],
            breadcrumb: [
                {name: 'ダッシュボード', nameRoute: 'AdminDashboard', active: 1},
            ],
        },
    }
]

