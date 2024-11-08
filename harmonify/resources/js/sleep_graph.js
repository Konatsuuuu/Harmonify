import "./bootstrap";
import { createApp } from "vue";
import SleepPage from "./components/SleepGraph.vue";
import "../css/app.css";

import "flowbite"; // Import Flowbite JS file here

createApp(SleepPage).mount("#sleep-app");
