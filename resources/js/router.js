import { createWebHistory, createRouter } from "vue-router";
import Home from "./views/Home";
import Statistics from "./views/Statistics";

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
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;