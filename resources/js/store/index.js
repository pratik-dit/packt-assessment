import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from '@/store/auth'
import books from '@/store/books'

const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        books
    }
})

export default store