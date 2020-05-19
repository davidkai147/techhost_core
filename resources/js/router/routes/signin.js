import SignIn from '../../pages/SignIn'
import multiguard from 'vue-router-multiguard';
import {LoginGuard} from '../../guards/login.guard'

export default {
    path: '/cms/signin',
    name: 'SignIn',
    component: SignIn,
    meta: {
        title: 'SignIn'
    },
    beforeEnter: multiguard([LoginGuard]),
}
