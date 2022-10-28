<template>
  <div class="card mb-3 mx-auto shadow-sm" style="max-width: 900px">
    <div class="row g-0">
      <div class="col-md-5">
        <img
          v-if="post.image"
          :src="`http://localhost:8000/storage/img/posts/${post.image}`"
          class="rounded img-fluid m-3 detail-img"
          alt="data.item.id"
        />
      </div>
      <div class="col-md-7">
        <div class="card-body">
          <span class="card-title fs-4 semibolder text-capitalize">{{ post.title }}</span>
          <p>
            Date :
            <span class="pr-3 text-secondary">
              {{ new Date(post.created_at).toDateString() }}</span
            >By: <span class="pl-1 text-primary">{{ post.user.name }}</span>
          </p>
          <p>
            <span
              class="badge bg-secondary mx-1"
              v-for="category in post.categories"
              :key="category.id"
              >{{ category.name }}</span
            >
          </p>
          <p class="card-text">
            {{ post.body }}
          </p>
        </div>
      </div>
    </div>
    <div class="row p-3">
      <div class="input-group input-group mb-3">
        <input
          type="text"
          class="form-control"
          placeholder="Write comment here!"
          v-model="comment"
        />
        <button
          class="input-group-text"
          @click="createComment()"
          :disabled="comment == '' || comment == null"
        >
          Comment
        </button>
      </div>
      <div>All Comments :</div>
      <div
        v-if="comments.length > 0"
        data-bs-spy="scroll"
        class="overflow-auto display-inline-block"
        style="max-height: 150px"
      >
        <div v-for="comment in comments" :key="comment.id" class="d-flex flex-row my-2">
          <div>
            <span class="badge bg-primary float-start mt-1">{{ comment.user.name }}</span>
          </div>
          <div class="bg-light p-2 text-dark ml-1 d-flex justify-content-start rounded-2">
            <div class="pr-1">{{ comment.body }}</div>
            <div
              class="text-secondary px-2 float-top"
              v-if="$auth.user.id === comment.user.id"
              @click="deleteComment(comment.id)"
            >
              <i class="fa-solid fa-xmark"></i>
            </div>
          </div>
        </div>
      </div>
      <span v-if="comments.length == 0" class="ml-2 text-secondary">
        No comment yet!
      </span>
    </div>
  </div>
</template>

<script>
export default {
  head: {
    title: "Post",
  },
  data() {
    return {
      post: {
        user: {},
      },
      comment: null,
      comments: [],
    };
  },
  mounted() {
    this.getPost();
  },
  methods: {
    async getPost() {
      await this.$axios
        .$get(`http://127.0.0.1:8000/api/posts/${this.$route.params.id}`)
        .then((res) => {
          this.post = res;
          this.getComments();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    async getComments() {
      await this.$axios
        .$get(`comments/${this.post.id}`)
        .then((res) => {
          this.comments = res;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    async createComment() {
      let data = {
        post_id: this.post.id,
        body: this.comment,
      };
      await this.$axios
        .$post("/comments", data)
        .then((res) => {
          this.comments.unshift(res.data);
          this.comment = "";
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async deleteComment(id) {
      if (confirm("Are you sure to delete your comment?")) {
        this.$axios
          .$delete(`comments/${id}`)
          .then((res) => {
            this.comments = this.comments.filter((item) => {
              return item.id !== id;
            });
          })
          .catch((err) => {
            if (err.response.status == 403) {
              alert("You are not authorized!");
            }
          });
      }
    },
  },
};
</script>

<style>
.detail-img {
  width: 100%;
  height: 300px;
}
</style>
