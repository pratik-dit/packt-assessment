import { createWebHistory, createRouter } from 'vue-router'
import store from '@/store'

/* Login/Register Component */
const Login = () => import('@/components/auth/Login.vue')
const Register = () => import('@/components/auth/Register.vue')

/* Layouts */
const DahboardLayout = () => import('@/components/layouts/Default.vue')

/* Authenticated Component */
const Dashboard = () => import('@/components/admin/Dashboard.vue')
const Book = () => import('@/components/admin/Book/List.vue')

/* Guest Component */
const Home = () => import('@/components/customer/Home.vue')
const BookStore = () => import('@/components/customer/BookStore.vue')

const routes = [
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        name: "register",
        path: "/register",
        component: Register,
        meta: {
            middleware: "guest",
            title: `Register`
        }
    },
    {
        path: "/dashboard",
        component: DahboardLayout,
        meta: {
            middleware: "auth"
        },
        children: [
            {
                name: "dashboard",
                path: '/dashboard',
                component: Dashboard,
                meta: {
                    title: `Dashboard`
                }
            },
            {
              name: "books",
              path: '/book',
              component: Book,
              meta: {
                  title: `Books`
              }
          }
        ]
    },
    {
      path: "/",
      component: DahboardLayout,
      meta: {
          middleware: "guest"
      },
      children: [
          {
              name: "home",
              path: '/',
              component: Home,
              meta: {
                  title: `Home`
              }
          },
          {
            name: "book-store",
            path: '/book-store',
            component: BookStore,
            meta: {
                title: `Book Store`
            }
          }
      ]
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes, // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "dashboard" })
        }
        next()
    } else {
        if (store.state.auth.authenticated) {
            next()
        } else {
            next({ name: "login" })
        }
    }
})

export default router