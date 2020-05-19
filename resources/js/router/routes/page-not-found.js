// import components
import PageNotFound from '../../pages/PageNotFound'

export default {
    path: '/cms/page-not-found',
    name: 'PageNotFound',
    component: PageNotFound,
    meta: {
        title: 'ページが見つかりません',
        description: '',
        requireAuth: true,
        permission: ['account', 'admin'],
    },
}
