<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid h3">
        <a class="navbar-brand" href="/" target="_blank">Packt</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav me-auto">
            <li v-if="authenticated" class="nav-item">
              <router-link :to="{name:'dashboard'}" class="nav-link"
                >Home <span class="sr-only">(current)</span></router-link
              >
            </li>
            <li v-if="!authenticated" class="nav-item">
              <router-link :to="{name:'home'}" class="nav-link"
                >Home <span class="sr-only">(current)</span></router-link
              >
            </li>
            <li v-if="!authenticated" class="nav-item">
              <router-link :to="{name:'book-store'}" class="nav-link"
                >Books <span class="sr-only">(current)</span></router-link
              >
            </li>
            <li v-if="authenticated" class="nav-item">
              <router-link :to="{name:'books'}" class="nav-link"
                >Books <span class="sr-only">(current)</span></router-link
              >
            </li>
          </ul>
          <div class="d-flex">
            <ul class="navbar-nav">
              <li v-if="authenticated" class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="navbarDropdownMenuLink"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  {{ user.name }}
                </a>
                <div
                  class="dropdown-menu dropdown-menu-end"
                  aria-labelledby="navbarDropdownMenuLink"
                >
                  <a
                    class="dropdown-item h4"
                    href="javascript:void(0)"
                    @click="logout"
                    >Logout</a
                  >
                </div>
              </li>
              <li v-if="!authenticated" class="nav-item">
                <router-link :to="{name:'login'}" class="nav-link"
                  >Login <span class="sr-only">(current)</span></router-link
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <main class="mt-3">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
import {mapActions} from 'vuex'
export default {
    name:"default-layout",
    data(){
        return {
            user:this.$store.state.auth.user,
            authenticated:this.$store.state.auth.authenticated
        }
    },
    methods:{
        ...mapActions({
            signOut:"auth/logout"
        }),
        async logout(){
            await axios.post('/logout').then(({data})=>{
                this.signOut()
                this.$router.push({name:"login"})
            })
        }
    }
}
</script>
<style setup>
.navbar {
  background: #2f3242;
  height: 80px;
}
</style>
