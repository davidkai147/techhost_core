// import components
import Dashboard from '../../pages/dashboard/Dashboard'

export default [
    {
        path: 'dashboard',
        name: 'AdminDashboard',
        component: Dashboard,
        meta: {
            requiredAuth: true,
            title: 'Dashboard',
            permission: ['SUPER_ADMIN', 'ADMIN'],
            breadcrumb: [
                {name: 'Dashboard', nameRoute: 'AdminDashboard', active: 1},
            ],
        },
    }
]

