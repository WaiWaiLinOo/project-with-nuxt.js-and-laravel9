<template>
  <form class="col-3 m-auto" @submit.prevent="register()">
    <div class="text-center">
      <img class="mb-3" src="/favicon.ico" alt="" width="80" height="70" />
    </div>
    <h1 class="h3 mb-3 fw-normal text-center">Please Sign Up</h1>
    <div class="form-floating mt-2">
      <input
        type="text"
        class="form-control"
        id="floatingName"
        placeholder="Su Su"
        v-model="user.name"
      />
      <label for="floatingName">User Name</label>
      <small class="text-danger" v-if="errors.name != null">* {{ errors.name[0] }}</small>
    </div>
    <div class="form-floating my-2">
      <input
        type="email"
        class="form-control"
        id="floatingInput"
        placeholder="name@example.com"
        v-model="user.email"
      />
      <label for="floatingInput">Email address</label>
      <small class="text-danger" v-if="errors.email != null"
        >* {{ errors.email[0] }}</small
      >
    </div>

    <div class="form-floating my-2">
      <input
        type="password"
        class="form-control"
        id="floatingPassword"
        placeholder="Password"
        v-model="user.password"
      />
      <label for="floatingPassword">Password</label>
      <small class="text-danger" v-if="errors.password != null"
        >* {{ errors.password[0] }}</small
      >
    </div>
    <div class="form-floating my-2">
      <input
        type="password"
        class="form-control"
        id="floatingPasswordConfirmation"
        placeholder="Password"
        v-model="user.password_confirmation"
      />
      <label for="floatingPasswordConfirmation">Password Confirmation</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Submit</button>
  </form>
</template>

<script>
export default {
  auth: "guest",
  head: {
    title: "Register",
  },
  data() {
    return {
      user: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
      },
      errors: {},
    };
  },
  mounted() {
    this.$axios.$get("http://127.0.0.1:8000/sanctum/csrf-cookie");
  },
  methods: {
    register() {
      this.$axios
        .post("http://127.0.0.1:8000/api/register", this.user)
        .then((res) => {
          this.$router.push({
            path: "/login",
          });
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
        });
    },
  },
};
</script>

<style></style>
