import "./bootstrap";
import { createApp } from "vue";
import App from "./components/App.vue";
import "../css/app.css";

createApp(App).mount("#app");

import anime from "animejs/lib/anime.es.js";

anime({
    targets: ".bubble",
    translateY: [10, -20],
    direction: "alternate",
    easing: "easeInOutSine",
    duration: 3000,
    loop: true,
});
