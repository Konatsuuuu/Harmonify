import "./bootstrap";
import { createApp } from "vue";
import SleepPage from "./components/SleepGraph.vue";
import "../css/app.css";

createApp(SleepPage).mount("#sleep-app");
