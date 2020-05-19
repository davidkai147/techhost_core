import store from '../store'

export const LoginGuard = (to, from, next) => {
    let currentUser = store.getters['auth/currentUser']
    if (_.keys(currentUser).length > 0) {
        next('cms/admin/dashboard')
    } else {
        next()
    }
}
