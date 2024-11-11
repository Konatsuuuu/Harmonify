import "./bootstrap";
import { createApp } from "vue";
import App from "./components/App.vue";
import "../css/app.css";

import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

const vuetify = createVuetify({
    components,
    directives,
});

createApp(App).use(vuetify).mount("#app");

import anime from "animejs/lib/anime.es.js";

anime({
    targets: ".bubble",
    translateY: [10, -20],
    direction: "alternate",
    easing: "easeInOutSine",
    duration: 3000,
    loop: true,
});
