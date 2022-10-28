<template>
  <div class="post col-8 px-3 mx-auto">
    <div class="card shadow-lg">
      <div class="card-header">
        <h4 class="fw-bolder text-center text-uppercase">Post Edit</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-3 text-center">
            <img v-if="url" :src="url" class="rounded img-fluid" alt="default image" />
            <img
              v-if="post.image && !url"
              :src="`http://localhost:8000/storage/img/posts/${post.image}`"
              class="rounded img-fluid post-img"
              alt="data.item.id"
            />
            <img
              v-if="!post.image && !url"
              src="../../../assets/img/default-img.jpg"
              class="rounded img-fluid post-img"
              alt="default image"
            />
          </div>
          <div class="col-9">
            <form @submit.prevent="editPost()" id="form">
              <div class="mb-3">
                <label for="formFile" class="form-label fw-semibold">Choose Image</label>
                <input
                  class="form-control"
                  type="file"
                  name="image"
                  id="image"
                  @change="imageChangeHandler"
                />
                <small class="text-danger" v-if="errors.image != null"
                  >*{{ errors.image[0] }}</small
                >
              </div>

              <div class="form-group mb-3">
                <label for="name" class="fw-semibold">Select Category</label>
                <select
                  class="form-select"
                  multiple
                  name="categories[]"
                  aria-label="multiple select example"
                  v-model="selectedCategories"
                >
                  <option :value="item.id" v-for="item in categories" :key="item.id">
                    {{ item.name }}
                  </option>
                </select>
                <small class="text-danger" v-if="errors.categories != null"
                  >*{{ errors.categories[0] }}</small
                >
              </div>
              <div class="form-group mb-3">
                <label for="title" class="fw-semibold">Title</label>
                <input
                  type="text"
                  class="form-control"
                  id="title"
                  name="title"
                  placeholder="Write post title!"
                  v-model="post.title"
                />
                <small class="text-danger" v-if="errors.title != null"
                  >*{{ errors.title[0] }}</small
                >
              </div>
              <div class="form-group mb-3">
                <label for="body" class="fw-semibold">Body</label>
                <textarea
                  class="form-control"
                  id="body"
                  name="body"
                  rows="5"
                  placeholder="Write details here!"
                  v-model="post.body"
                ></textarea>
                <small class="text-danger" v-if="errors.body != null"
                  >*{{ errors.body[0] }}</small
                >
              </div>
              <div class="text-center">
                <button class="btn btn-secondary mr-3" type="reset">
                  <i class="fa-solid fa-trash-arrow-up"></i>Clear
                </button>
                <button class="btn btn-primary" type="submit">
                  <i class="fa-regular fa-floppy-disk"></i> Save
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
      url: null,
      categories: [],
      selectedCategories: [],
      errors: {},
      post: [],
    };
  },
  async fetch() {
    await this.getPost();
    await this.getAllCategories();
  },
  methods: {
    async getPost() {
      await this.$axios
        .$get(`http://127.0.0.1:8000/api/posts/${this.$route.params.id}`)
        .then((res) => {
          this.post = res;
          this.post.categories.map((item) => {
            this.selectedCategories.push(item.id);
          });
        })
        .catch((err) => {
          console.error(err);
        });
    },
    async getAllCategories() {
      await this.$axios
        .$get("http://127.0.0.1:8000/api/categories")
        .then((res) => {
          this.categories = res;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    imageChangeHandler(e) {
      this.post.image = e.target.files[0];
      let file = e.target.files[0];
      if (!file.type.includes("image")) {
        this.url = null;
      } else {
        this.url = URL.createObjectURL(file);
      }
    },
    async editPost() {
      let form = new FormData(document.getElementById("form"));
      await this.$axios
        .$post(`http://127.0.0.1:8000/api/posts/edit/${this.post.id}`, form)
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "Updated Successfully!",
          });
          this.$router.push({
            path: "/posts",
          });
        })
        .catch((err) => {
          if (err.response.status == 403) {
            this.$router.push({
              path: "/posts",
            });
            alert("You are not authorized!");
          } else {
            this.errors = err.response.data.errors;
          }
        });
    },
  },
};
</script>

<style></style>
