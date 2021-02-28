import {createRouter, createWebHistory} from "vue-router";
import Statistics from "./views/Statistics";
import LastActivities from './views/LastActivities';

let prefix = window.tracker.prefix;
if (!prefix.startsWith("/")) prefix = "/" + prefix;
const routes = [
    {
        path: prefix,
        name: "LastActivities",
        component: LastActivities,
    },
    {
        path: prefix + "/statistics",
        name: "Statistics",
        component: Statistics,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
