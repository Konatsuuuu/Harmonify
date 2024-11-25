import "./bootstrap";
import { createApp } from "vue";
import Posts from "./components/Posts.vue";
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

createApp(Posts).use(vuetify).mount("#posts-app");
