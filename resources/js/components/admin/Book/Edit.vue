<template>
  <div class="container dashboard">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header">
            <h2>Edit Book Data</h2>
          </div>
          <div class="card-body d-grid gap-3">
            <form action="javascript:void(0)" method="post">
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
              <div class="form-outline mb-4">
                <input
                  type="text"
                  id="title"
                  class="form-control form-control-lg"
                  v-model="book.title"
                />
                <label class="form-label" for="title">Title</label>
              </div>

              <div class="form-outline mb-4">
                <input
                  type="text"
                  id="author"
                  class="form-control form-control-lg"
                  v-model="book.author"
                />
                <label class="form-label" for="author">Author</label>
              </div>

              <div class="form-outline mb-4">
                <input
                  type="text"
                  id="genre"
                  class="form-control form-control-lg"
                  v-model="book.genre"
                />
                <label class="form-label" for="genre">Genre</label>
              </div>

              <div class="form-outline mb-4">
                <input
                  type="text"
                  id="isbn"
                  class="form-control form-control-lg"
                  v-model="book.isbn"
                />
                <label class="form-label" for="isbn">ISBN</label>
              </div>

              <div class="form-outline mb-4">
                <input
                  type="date"
                  id="form3Example4cdg"
                  class="form-control form-control-lg"
                  v-model="book.published"
                />
                <label class="form-label" for="form3Example4cdg"
                  >Published</label
                >
              </div>

              <div class="form-outline mb-4">
                <input
                  type="text"
                  id="publisher"
                  class="form-control form-control-lg"
                  v-model="book.publisher"
                />
                <label class="form-label" for="publisher">Publisher</label>
              </div>

              <div class="form-outline mb-4">
                <textarea
                  class="form-control form-control-lg"
                  id="description"
                  rows="3"
                  v-model="book.description"
                ></textarea>
                <label class="form-label" for="description">Description</label>
              </div>

              <div class="d-flex justify-content-center">
                <button
                  type="button"
                  class="btn btn-success btn-block btn-lg gradient-custom-4 text-body"
                  :disabled="processing"
                  @click="update"
                >
                  {{ processing ? "Please wait" : "Update" }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import router from '@/router'
export default {
  name: "Edit",
  data() {
    return {
      book: {},
      processing:false,
      validationErrors:{},
    }
  },
  mounted(){
    console.log(this.$route.params.id)
    this.showBook()
  },
  methods: {
    async showBook() {
      await axios.get('/sanctum/csrf-cookie')
      await axios.get('/api/books/'+this.$route.params.id).then(({data})=>{
        if(data.status == 200){
          this.book = data.data
          console.log("this.book = ", this.book)
        }else{
          this.$router.push({name:"books"})
        }
      }).catch(({response})=>{
        this.$router.push({name:"books"})
      }).finally(()=>{

      })
    },
    async update() {
      if(confirm("Are you sure to update this book?")){
        this.processing = true
        await axios.post('/api/books/'+this.$route.params.id, this.book).then(({data})=>{
          router.push({name:'books'})
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
}
</script>
<style scoped>
.mx-t3 {
  margin-top: -3rem;
}
</style>
