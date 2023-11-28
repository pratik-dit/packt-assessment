<template>
  <div class="container dashboard">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header">
            <h2>Books</h2>
          </div>
          <div class="card-body d-grid gap-3">
            <div class="p-1 bg-light rounded rounded-pill shadow-sm mb-4">
                <div class="input-group">
                  <input v-model="term" type="search" placeholder="What're you searching for?" aria-describedby="button-addon1" class="form-control border-0 bg-light">
                  <div class="input-group-append">
                    <button id="button-addon1" type="btn" class="btn btn-link text-primary" @click="search"><i class="fa fa-search"></i></button>
                  </div>
                </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead class="table__head">
                  <tr class="winner__table">
                    <th>#</th>
                    <th><i class="fa fa-book" aria-hidden="true"></i> Title</th>
                    <th>
                      <i class="fa fa-user" aria-hidden="true"></i> Author
                    </th>
                    <th>
                      <i class="fa fa-music" aria-hidden="true"></i> Genre
                    </th>
                    <th>
                      <i class="fa fa-barcode" aria-hidden="true"></i> ISBN
                    </th>
                    <th>
                      <i class="fa fa-calendar" aria-hidden="true"></i>
                      Published
                    </th>
                    <th>
                      <i class="fa fa-book" aria-hidden="true"></i> Publisher
                    </th>
                    <th>
                      <i class="fa fa-file-image-o" aria-hidden="true"></i>
                      Description
                    </th>
                  </tr>
                </thead>
                <tbody v-if="books.data && books.data.length > 0">
                  <tr
                    v-for="book in books.data"
                    :key="book.id"
                    class="winner__table"
                  >
                    <td>{{ book.id }}</td>
                    <td>{{ book.title }}</td>
                    <td>{{ book.author }}</td>
                    <td>{{ book.genre }}</td>
                    <td>{{ book.isbn }}</td>
                    <td>{{ book.published }}</td>
                    <td>{{ book.publisher }}</td>
                    <td>{{book.description.substring(0,30)+".."}}</td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="3">No record found.</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <Bootstrap5Pagination
              class="mb-0"
              :data="books"
              :limit="limit"
              :keep-length="keepLength"
              :show-disabled="showDisabled"
              :size="size"
              :align="align"
              @pagination-change-page="getResults"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.css';
import { Bootstrap5Pagination } from 'laravel-vue-pagination/src/lib';
export default {
  name:"home",
  components:{
    Bootstrap5Pagination
  },
  data(){
      return {
        processing:false,
        books: [],
        limit: 10,
        keepLength: false,
        showDisabled: false,
        size: 'default',
        align: 'left',
        term: '',
      }
  },
  mounted() {
    this.getBooks(1)
  },
  methods: {
    async getBooks(page){
        this.processing = true
        await axios.get(`/api/search?page=${page}&query=${this.term}`).then(({data})=>{
            this.books = data.data
        }).catch(({response})=>{

        }).finally(()=>{
            this.processing = false
        })
    },
    getResults(page){
      if (!page) {
        page = 1;
      }
      this.getBooks(page)
    },
    search(){
      this.getBooks(1)
    }
  }
}
</script>

<style scoped>
.table__head {
  color: #fff;
  font-weight: 700;
  background: #9b4085;
  background: -moz-linear-gradient(-45deg, #9b4085 0%, #608590 100%);
  background: -webkit-linear-gradient(-45deg, #9b4085 0%, #608590 100%);
  background: linear-gradient(135deg, #9b4085 0%, #608590 100%);
  white-space: nowrap;
}
.table-bordered td,
.table-bordered th {
  border: 0px solid #fff;
}
.winner__table {
  white-space: nowrap;
}

@media screen and (max-width: 567px) {
  .winner__table {
    font-size: 12px;
  }
}

.form-input-fields {
 margin-bottom: 0; 
}
.input-search {
  border:1px solid #fff;
  box-shadow:none;  
}
@media (max-width: 767px) {
  .btn-submit {
    margin-top:10px;
  }
}
</style>
