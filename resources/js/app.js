import "./bootstrap";
import { createApp } from "vue";
import "./vanilla/app";
import Antd from "ant-design-vue";
import "ant-design-vue/dist/reset.css";

import AddDeveloper from "./components/backend/developer/Add.vue";
import EditDeveloper from "./components/backend/developer/Edit.vue";
import AddProject from "./components/backend/project/Add.vue";
import EditProject from "./components/backend/project/Edit.vue";
import AddUser from "./components/backend/user/Add.vue";
import EditUser from "./components/backend/user/Edit.vue";
import AddCamera from "./components/backend/camera/Add.vue"
import EditCamera from "./components/backend/camera/Edit.vue"
import ViewCamera from "./components/backend/camera/View.vue"
import VueCompareImage from 'vue3-compare-image'

const app = createApp({});

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

app.component("add-developer", AddDeveloper);
app.component("edit-developer", EditDeveloper);

app.component("add-project", AddProject);
app.component("edit-project", EditProject);

app.component("add-user", AddUser);
app.component("edit-user", EditUser);

app.component("add-camera", AddCamera);
app.component("edit-camera", EditCamera);
app.component("view-camera", ViewCamera);

app.use(Antd).mount("#backend-app");
