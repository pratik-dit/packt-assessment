import axios from 'axios'
import router from '@/router'

export default {
    namespaced: true,
    state:{
        
    },
    getters:{
        
    },
    mutations:{
        
    },
    actions:{
        sync_books(){
            return axios.get('/api/books/sync').then(({data})=>{
            }).catch(({response:{data}})=>{
              router.push({name:'dashboard'})
            })
        },
    }
}