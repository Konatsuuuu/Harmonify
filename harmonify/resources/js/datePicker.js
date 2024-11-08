import { createApp } from "vue";
import Vuetify from "vuetify";
import "vuetify/styles";
import App from "./App.vue";

const app = createApp(App);

app.use(Vuetify);
app.mount("#app");
