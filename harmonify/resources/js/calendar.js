import "./bootstrap";
import { createApp } from "vue";
import CalendarPage from "./components/CalendarPage.vue";
import "../css/app.css";

createApp(CalendarPage).mount("#calendar-app");
