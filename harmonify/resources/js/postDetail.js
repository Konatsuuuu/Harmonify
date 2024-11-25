import "./bootstrap";
import { createApp } from "vue";
import PostDetail from "./components/PostDetail.vue";
import "../css/app.css";

import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "@mdi/font/css/materialdesignicons.css";

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: "mdi",
    },
});

createApp(PostDetail).use(vuetify).mount("#postdetail-app");

import anime from "animejs/lib/anime.es.js";
anime({
    targets: ".bubble",
    translateY: [15, -15],
    direction: "alternate",
    easing: "easeInOutSine",
    duration: 2500,
    loop: true,
});
