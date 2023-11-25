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
            <h3 class="text-logo">Register</h3>
            <br />
            <form
              action="javascript:void(0)"
              @submit="register"
              class="text-center"
              method="post"
            >
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
                name="name"
                v-model="user.name"
                id="name"
                placeholder="Enter name"
                class="form-control border-0"
              />
              <br />
              <input
                type="text"
                name="email"
                v-model="user.email"
                id="email"
                placeholder="Enter email"
                class="form-control border-0"
              />
              <br />
              <input
                type="password"
                name="password"
                v-model="user.password"
                id="password"
                placeholder="Enter password"
                class="form-control border-0"
              />
              <br />
              <input
                type="password"
                name="password_confirmation"
                v-model="user.password_confirmation"
                id="password_confirmation"
                placeholder="Enter confirm password"
                class="form-control border-0"
              />
              <br />
              <button
                type="submit"
                :disabled="processing"
                class="btn btn-primary btn-sm border-0"
              >
                {{ processing ? "Please wait" : "Register" }}
              </button>
            </form>
          </div>
          <div class="auth-member">
            <p class="text-center">
              Already have an account?
              <router-link :to="{name:'login'}">Login Now!</router-link>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name:'register',
    data(){
        return {
            user:{
                name:"",
                email:"",
                password:"",
                password_confirmation:""
            },
            validationErrors:{},
            processing:false
        }
    },
    methods:{
        ...mapActions({
            signIn:'auth/login'
        }),
        async register(){
            this.processing = true
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/register',this.user).then(response=>{
                this.validationErrors = {}
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
        }
    }
}
</script>
