import axios from 'axios/index'
import {AuthService} from '../api/service/auth.service'
import {Cookie} from '../util/cookie'
import store from "../store"
import { Message } from 'element-ui'

const axiosInstance = axios.create({
    baseURL: '/api',
    // In case that in need token
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
})

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
    axiosInstance.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

// Add a request interceptor for authorization
axiosInstance.interceptors.request.use(
    (config) => {
        // Do something before request is sent
        config.headers['Authorization'] = `Bearer ${Cookie.findByName('access_token')}`
        store.dispatch('loader/showLoading');
        return config
    }, error => {
        store.dispatch('loader/hideLoading');
        return Promise.reject(error)
    }
)

axiosInstance.interceptors.response.use(
    resp => {
        store.dispatch('loader/hideLoading');
        return resp
    },
    error => {
        store.dispatch('loader/hideLoading');
        const {config, response: {status}} = error

        if (status === 401) {
            return window.location.href = window.location.origin + '/cms/signin'
        }

        if (status === 500) {
            Message.error('処理に失敗しました。管理者にお問い合わせください。')
            return AuthService.logout().then(() => window.location.href = window.location.origin + '/cms/signin')
        }

        return Promise.reject(error)
    },
)

export const ApiService = {

    get(url, params = {}) {
        return axiosInstance.get(`${url}`, {params})
    },

    post(url, body, config = {}) {
        return axiosInstance.post(`${url}`, body, config)
    },

    put(url, body, params = {}) {
        return axiosInstance.put(`${url}`, body, {params})
    },

    delete(url, params = {}) {
        return axiosInstance.delete(url, params)
    },
}
