<template>
    <ul v-if="items"
        :class="{'navbar-nav pt-lg-3': root, 'dropdown-menu dropdown-menu-columns': !root}"
    >
        <template v-for="(item,i) of items">
            <li v-if="!item.meta.hidden"
                :key="i"
                :class="{'dropdown': activeIndex === i, 'nav-item': root}"
            >
                <!-- Link for single menu -->
                <router-link v-if="!item.children && (item.path || item.path === '') && hasPermission(item)"
                             :to="{name: item.name}"
                             class="nav-link"
                             :class="{'active': activeIndex === i || item.name === $route.name , 'dropdown-item': !root}"
                             @click.native="onMenuItemClick($event, item, i)"
                             exact>
          <span v-if="item.meta.icon" class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="icon" :class="item.meta.icon"/>
          </span>

                    <span class="nav-link-title">{{$t(`${item.meta.label}`)}}</span>

                    <i v-if="item.children" class="right fe fe-arrow-down menuitem-toggle-icon"/>
                </router-link>

                <!-- Link for parent menu -->
                <a v-if="item.children && item.path && hasPermission(item)"
                   href="#"
                   class="nav-link dropdown-item"
                   :class="{'active': activeIndex === i}"
                   @click="onMenuItemClick($event,item,i)">
          <span v-if="item.meta.icon" class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="icon" :class="item.meta.icon"/>
          </span>

                    <span class="nav-link-title">{{$t(`${item.meta.label}`)}}</span>

                    <i v-if="item.children" class="right fe fe-angle-left menuitem-toggle-icon"/>
                </a>

                <transition>
                    <AppSubMenu v-show="activeIndex === i"
                                :items="item.children"
                                :root="false"
                                :root-key="i"
                                :class="{'show': activeIndex === i && root}"/>
                </transition>
            </li>
        </template>
    </ul>
</template>
<script lang="js">
    import AppSubMenu from './AppSubMenu.vue'
    import {isEmpty} from 'lodash'
    //
    // import {PERMISSIONS} from '@/enum/permissions.enum'
    // import {AuthService} from '@/api'

    export default {
        name: 'AppSubMenu',

        components: {
            AppSubMenu
        },

        props: {
            items: Array,
            root: Boolean
        },

        data() {
            return {
                activeIndex: null,
                parentIndex: null
            }
        },

        computed: {
            // permissions() {
            //     return AuthService.current_permission() || []
            // }
        },

        methods: {
            // hasPermission(item) {
            //     if (item.name === 'Dashboard' || item.meta.permissions === PERMISSIONS.ALL) {
            //         return true
            //     }
            //
            //     if (!isEmpty(item.meta.permissions)) {
            //         return !!this.permissions.find(permission => item.meta.permissions.includes(permission.name))
            //     }
            //
            //     return false
            // },
            /**
             * action click on menu
             * @param event
             * @param item
             * @param index
             */
            onMenuItemClick(event, item, index) {
                if (!item.to && !item.url) {
                    event.preventDefault()
                }

                if (index !== this.activeIndex) {
                    this.activeIndex = index
                }
            }
        }
    }
</script>
