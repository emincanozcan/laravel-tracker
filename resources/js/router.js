import { createWebHistory, createRouter } from "vue-router";
import Home from "./views/Home";
import Statistics from "./views/Statistics";
import LastActivities from './views/LastActivities';
let prefix = window.tracker.prefix;
if (!prefix.startsWith("/")) prefix = "/" + prefix;
const routes = [
  {
    path: prefix,
    name: "Home",
    component: Home,
  },
  {
    path: prefix + "/statistics",
    name: "Statistics",
    component: Statistics,
  },
  {
    path: prefix + "/last-activities",
    name: "LastActivities",
    component: LastActivities,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;