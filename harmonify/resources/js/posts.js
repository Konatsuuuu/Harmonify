import "./bootstrap";
import { createApp } from "vue";
import SleepPage from "./components/Posts.vue";
import "../css/app.css";

createApp(SleepPage).mount("#posts-app");
