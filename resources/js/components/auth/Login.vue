<template>
  <div class="container auth-screen">
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="card login-content shadow-lg border-0">
          <div class="card-body">
            <div class="text-center">
              <router-link :to="{name:'home'}" class="nav-link">
                <img
                  class="logo"
                  src="https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678071-address-book-alt-512.png"
                />
              </router-link>
            </div>
            <h3 class="text-logo">Sign In</h3>
            <br />
            <form action="javascript:void(0)" class="text-center" method="post">
              <div
                class="col-12"
                v-if="Object.keys(validationErrors).length > 0"
              >
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    <li v-for="(value, key) in validationErrors" :key="key">
                      {{ value[0] }}
                    </li>
                  </ul>
                </div>
              </div>
              <input
                type="text"
                v-model="auth.email"
                name="email"
                id="email"
                class="form-control border-0"
                placeholder="Type Your Email"
              />
              <br />
              <input
                type="password"
                v-model="auth.password"
                name="password"
                id="password"
                class="form-control border-0"
                placeholder="Type Your Password"
              />
              <br />
              <button
                type="submit"
                :disabled="processing"
                @click="login"
                class="btn btn-primary btn-sm border-0"
              >
                {{ processing ? "Please wait" : "Login" }}
              </button>
            </form>
          </div>
          <!-- <div class="auth-member">
            <p class="text-center">
              Not a member?
              <router-link :to="{name:'register'}">Register Now!</router-link>
            </p>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name:"login",
    data(){
        return {
            auth:{
                email:"",
                password:""
            },
            validationErrors:{},
            processing:false
        }
    },
    methods:{
        ...mapActions({
            signIn:'auth/login'
        }),
        async login(){
            this.processing = true
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/login',this.auth).then(({data})=>{
                this.signIn()
            }).catch(({response})=>{
                if(response.status===422){
                    this.validationErrors = response.data.errors
                }else{
                    this.validationErrors = {}
                    alert(response.data.message)
                }
            }).finally(()=>{
                this.processing = false
            })
        },
    }
}
</script>