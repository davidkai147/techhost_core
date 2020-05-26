// import components
import Category from '../../pages/category/Category'
import Register from '../../pages/category/Register'
import Edit from '../../pages/category/Edit'

export default [
    {
        path: 'category',
        name: 'Category',
        component: Category,
        meta: {
            requiredAuth: true,
            title: 'Category list',
            permission: ['SUPER_ADMIN', 'ADMIN'],
            breadcrumb: [
                {name: 'Category list', nameRoute: 'Category', active: 1},
            ],
        },
    },
    {
        path: 'category/register',
        name: 'CategoryRegister',
        component: Register,
        meta: {
            requiredAuth: true,
            title: 'Register category',
            permission: ['SUPER_ADMIN', 'ADMIN'],
            breadcrumb: [
                {name: 'Category list', nameRoute: 'Category', active: 0},
                {name: 'Register category', nameRoute: 'CategoryRegister', active: 1},
            ],
        },
    },
    {
        path: 'category/edit/:id',
        name: 'CategoryEdit',
        component: Edit,
        meta: {
            requiredAuth: true,
            title: 'Edit category',
            permission: ['SUPER_ADMIN', 'ADMIN'],
            breadcrumb: [
                {name: 'Category list', nameRoute: 'Category', active: 0},
                {name: 'Edit category', nameRoute: 'CategoryEdit', active: 1},
            ],
        },
    }
]
