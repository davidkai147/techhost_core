import {ApiService} from '../api.service.js'

import {Cookie} from '../../util/cookie'

export const AuthService = {

    fetchUser() {
        return ApiService.post('users/me?with=contract').then(
            (resp) => {
                const {data} = resp.data
                return data;
            }
        );
    },

    logout () {
      let token = document.head.querySelector('meta[name="csrf-token"]')
      const body = new FormData()
      body.append('_token', token.content)
      let config = {}
      config.baseURL = '/'
      config.headers = {}
      // if (Cookie.findByName('aidma_shelf_analytics_session')) {
      //   config.headers['Authorization'] = `${ Cookie.findByName('aidma_shelf_analytics_session') }`
      // }
      if (localStorage.getItem('current-route')) {
        localStorage.removeItem('current-route')
      }
      return ApiService.post('cms/signout', body, config)
    },

}
