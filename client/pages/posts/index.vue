<template>
  <div class="container">
    <div class="row d-flex justify-content-start">
      <div class="col-9">
        <NuxtLink to="/posts/create">
          <button class="btn btn-sm btn-primary">
            <i class="fa-sharp fa-solid fa-plus"></i> Create
          </button>
        </NuxtLink>
      </div>
      <div class="col-3 d-flex justify-content-start">
        <div class="input-group input-group-sm mb-3">
          <input
            type="text"
            class="form-control"
            v-model="keyword"
            placeholder="Search"
            @keyup.enter="search()"
          />
          <button class="input-group-text bg-primary text-white" @click="search()">
            <i class="fa-sharp fa-solid fa-magnifying-glass"></i> Search
          </button>
        </div>
      </div>
    </div>
    <div class="row">
      <b-table
        striped
        id="my-table"
        :items="posts"
        :per-page="perPage"
        :current-page="currentPage"
        :fields="fields"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        class="mb-5"
      >
        <template #cell(image)="data">
          <img
            :src="`http://localhost:8000/storage/img/posts/${data.item.image}`"
            class="rounded img-fluid post-img"
            alt="data.item.id"
          />
        </template>
        <template #cell(user)="data">
          {{ data.item.user.name }}
        </template>
        <template #cell(actions)="data">
          <NuxtLink
            :to="`/posts/edit/${data.item.id}`"
            v-if="$auth.user.id == data.item.user.id"
          >
            <button class="btn btn-sm btn-success my-2">
              <i class="fa-regular fa-pen-to-square"></i> Edit
            </button>
          </NuxtLink>
          <button
            class="btn btn-sm btn-danger my-2"
            v-if="$auth.user.id == data.item.user.id"
            @click="deletePost(data.item.id)"
          >
            <i class="fa-solid fa-trash-can"></i> Delete
          </button>
          <NuxtLink :to="`/posts/${data.item.id}`">
            <button class="btn btn-sm btn-secondary my2">
              <i class="fa-sharp fa-solid fa-circle-info"></i> Details
            </button>
          </NuxtLink>
        </template>
      </b-table>
      <p v-if="rows == 0 && keyword != ''" class="text-danger text-center">
        No post here!
      </p>
      <b-pagination
        v-model="currentPage"
        :total-rows="rows"
        :per-page="perPage"
        :current-page="currentPage"
        first-text="First"
        prev-text="Prev"
        next-text="Next"
        last-text="Last"
        v-if="rows > 5"
      ></b-pagination>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";

const Toast = Swal.mixin({
  toast: true,
  position: "top-right",
  customClass: {
    popup: "colored-toast",
  },
  showConfirmButton: false,
  timer: 1500,
  timerProgressBar: true,
});
export default {
  head: {
    title: "Post",
  },
  data() {
    return {
      posts: [],
      keyword: "",
      fields: [
        { key: "id", label: "ID" },
        { key: "image", label: "Image" },
        { key: "user", label: "User", thStyle: { width: "10%" } },
        { key: "categories", label: "Categories", thStyle: { width: "10%" } },
        {
          key: "title",
          label: "Title",
          thStyle: { width: "20%" },
          tdClass: "semibolder",
        },
        { key: "body", label: "Body" },
        { key: "actions", label: "Actions", thStyle: { width: "20%" } },
      ],
      sortBy: "id",
      sortDesc: true,
      currentPage: 1,
      perPage: 5,
      file: null,
      errors: null,
    };
  },
  mounted() {
    this.getAllPosts();
  },
  methods: {
    async getAllPosts() {
      await this.$axios
        .$get("http://127.0.0.1:8000/api/posts?search=" + this.keyword)
        .then((res) => {
          this.posts = res;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    deletePost(id) {
      if (confirm("Are you sure to delete?")) {
        this.$axios
          .$delete(`posts/${id}`)
          .then((res) => {
            this.posts = this.posts.filter((item) => {
              return item.id !== id;
            });
            Toast.fire({
              icon: "warning",
              title: "Deleted Successfully!",
            });
          })
          .catch((err) => {
            if (err.response.status == 403) {
              alert("You are not authorized!");
            }
          });
      }
    },
    search() {
      this.getAllPosts();
    },
    clearErrMsg() {
      this.errors = null;
      let form = document.getElementById("import-form");
      form.reset();
    },
  },
  computed: {
    rows() {
      return this.posts.length;
    },
  },
};
</script>

<style>
.post {
  max-height: 200px;
}
.post-body {
  width: 200px;
  height: 150px;
  white-space: wrap;
  text-overflow: ellipsis;
}

.post-img {
  max-height: 140px;
  height: 140px;
  width: 180px;
  min-width: 180px;
}

.semibolder {
  font-weight: 600;
}
</style>
