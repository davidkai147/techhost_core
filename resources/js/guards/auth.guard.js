import store from '../store'
import {Cookie} from '../util/cookie'

export const AuthGuard = (to, from, next) => {
    let currentUser = store.getters['auth/currentUser']
    if (Cookie.findByName('access_token')) {
        // Exist cookie
        if (!(currentUser.email || currentUser.name)) {
            store.dispatch('auth/checkAuth').then(() => {
                if (_.indexOf(to.meta.permission, Cookie.findByName('type')) !== -1) {
                    next()
                } else {
                    next({name: 'SignIn'})
                }
            })
        } else if (_.indexOf(to.meta.permission, Cookie.findByName('type')) !== -1) {
            next()
        } else {
            next({name: 'PageNotFound'})
        }
    } else {
        // Not exist cookie access_token
        window.location.href = window.location.origin + '/cms/signin'
    }
}
