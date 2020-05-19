// import components
import ShelfLocation from '../../pages/shelflocation/ShelfLocation'
import ShelfLocationImport from '../../pages/shelflocation/ShelfLocationImport'

export default [
    {
        path: 'shelf/item',
        name: 'ShelfLocation',
        component: ShelfLocation,
        meta: {
            requiredAuth: true,
            permission: ['account'],
            title: '棚位置一覧',
            breadcrumb: [
                {name: '棚位置一覧', nameRoute: 'ShelfLocation', active: 1},
            ],
        },
    },
    {
        path: 'shelf/item/import',
        name: 'ShelfLocationImport',
        component: ShelfLocationImport,
        meta: {
            requiredAuth: true,
            permission: ['account'],
            title: '棚位置CSV取込',
            breadcrumb: [
                {name: '棚位置一覧', nameRoute: 'ShelfLocation', active: 0},
                {name: '棚位置CSV取込', nameRoute: 'ShelfLocationImport', active: 1},
            ],
        },
    },
]
