import { createWebHistory, createRouter } from "vue-router";
import Home from "./views/Home";
import Statistics from "./views/Statistics";
import LastActivities from './views/LastActivities';

const routes = [
  {
    path: "/tracker",
    name: "Home",
    component: Home,
  },
  {
    path: "/tracker/statistics",
    name: "Statistics",
    component: Statistics,
  },
  {
    path: "/tracker/last-activities",
    name: "LastActivities",
    component: LastActivities,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;