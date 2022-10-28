export default {
  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: false,

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: "client",
    htmlAttrs: {
      lang: "en",
    },
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      { hid: "description", name: "description", content: "" },
      { name: "format-detection", content: "telephone=no" },
    ],
    link: [
      { rel: "icon", type: "image/x-icon", href: "/favicon.ico" },
      {
        rel: "stylesheet",
        href: "https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css",
      },
      {
        rel: "stylesheet",
        href: "https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,400;0,700;1,300&display=swap",
      },
      {
        rel: "stylesheet",
        href: "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css",
      },
    ],
    script: [
      {
        src: "https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js",
      },
    ],
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: ["~/assets/css/main.css"],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: ["@nuxtjs/axios", "@nuxtjs/auth-next", "bootstrap-vue/nuxt"],

  auth: {
    strategies: {
      local: {
        user: {
          property: "",
        },
        endpoints: {
          login: {
            url: "login",
            method: "post",
          },
          user: {
            url: "user",
            method: "get",
          },
          logout: {
            url: "logout",
            method: "post",
          },
        },
      },
      laravelSanctum: {
        provider: "laravel/sanctum",
        url: "http://localhost:8000",
      },
    },
  },

  axios: {
    baseURL: "http://127.0.0.1:8000/api",
    credentials: true,
  },

  router: {
    middleware: ["auth"],
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {},
};
