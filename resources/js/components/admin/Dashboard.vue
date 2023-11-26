<template>
    <div class="container dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h2>Dashboard</h2>
                    </div>
                    <div class="card-body">
                        <span class="mb-0 fs-4">You are logged in as <b>{{user.email}}</b></span>
                    </div>
                </div>
            </div>
            <div class="col-12">
              <div class="card bg-light-subtle mt-4">
                <div class="card-header">
                    <h3>Sync Books Data from Faker API</h3>
                </div>
                <div class="card-body d-grid gap-3">
                  <div class="text-section">
                    <span class="card-text fs-4">Click below button to sync books data from faker api.</span>
                  </div>
                  <div class="cta-section">
                    <button class="btn btn-dark fs-4" @click="sync_books">Sync Now</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    name:"dashboard",
    data(){
        return {
            user:this.$store.state.auth.user
        }
    },
    methods: {
      ...mapActions({
        syncBooks: 'books/sync_books'
      }),
      async sync_books() {
        this.syncBooks()
      }
    }
}
</script>