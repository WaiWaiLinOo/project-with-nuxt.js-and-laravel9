<template>
  <div class="post col-8 px-3 mx-auto">
    <div class="card shadow-lg">
      <div class="card-header">
        <h4 class="fw-bolder text-center text-uppercase">Post Create</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-3 text-center">
            <img v-if="url" :src="url" class="rounded img-fluid" alt="default image" />
            <img
              v-if="!url"
              src="../../assets/img/default-img.jpg"
              class="rounded img-fluid"
              alt="user selected image"
            />
          </div>
          <div class="col-9">
            <form @submit.prevent="createPost()" id="form">
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
      errors: {},
    };
  },
  async fetch() {
    this.getAllCategories();
  },
  methods: {
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
      const file = e.target.files[0];
      if (!file.type.includes("image")) {
        this.url = null;
      } else {
        this.url = URL.createObjectURL(file);
      }
    },
    async createPost() {
      let form = new FormData(document.getElementById("form"));
      await this.$axios
        .$post("http://127.0.0.1:8000/api/posts", form, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "Created Successfully!",
          });
          this.$router.push({
            path: "/posts",
          });
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
        });
    },
  },
};
</script>

<style>
.post img {
  max-height: 150px;
  width: auto;
  min-width: 150px;
}
.form-select option {
  padding: 3px 0;
}
</style>
