<template>
  <div class="w-100 bg-light">
    <Navbar />
    <main class="p-5 min-vh-100"><Nuxt /></main>
  </div>
</template>

<script>
import Navbar from "~/components/NavBar";

export default {
  components: {
    Navbar,
  },
};
</script>

<style></style>
