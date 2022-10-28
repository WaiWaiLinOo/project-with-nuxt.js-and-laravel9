<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container justify-between">
      <NuxtLink class="nav-link text-white" to="/">
        <h2 class="text-uppercase">Nuxt Auth</h2>
      </NuxtLink>
      <div class="" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item" v-if="!$auth.loggedIn">
            <NuxtLink class="nav-link" to="/register">Register</NuxtLink>
          </li>
          <li class="nav-item" v-if="!$auth.loggedIn">
            <NuxtLink class="nav-link" to="/login">Login</NuxtLink>
          </li>
          <li class="nav-item" v-if="$auth.loggedIn">
            <NuxtLink class="nav-link" to="/category">Category</NuxtLink>
          </li>
          <li class="nav-item" v-if="$auth.loggedIn">
            <NuxtLink class="nav-link" to="/posts">Post</NuxtLink>
          </li>
          <li class="nav-item dropdown" v-if="$auth.loggedIn">
            <a
              class="nav-link dropdown-toggle text-uppercase"
              href="#"
              id="dropdown07XL"
              data-bs-toggle="dropdown"
              aria-expanded="true"
              >{{ $auth.user.name }}</a
            >
            <ul
              class="dropdown-menu"
              aria-labelledby="dropdown07XL"
              data-bs-popper="none"
            >
              <li><a class="dropdown-item" href="#">Profile</a></li>
              <li>
                <span @click="logout" class="dropdown-item">Logout</span>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  middleware: "auth",
  methods: {
    async logout() {
      this.$nuxt.$loading.start();
      await this.$auth.logout();
      this.$nuxt.$loading.finish();
      this.$router.push({
        path: "/login",
      });
    },
  },
};
</script>
<style></style>
