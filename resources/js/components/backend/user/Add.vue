 <template>
    <div>
        <div class="grid grid-cols-12 mt-8">
            <div class="col-span-12 lg:col-span-8 sm:col-span-12">
                <h2 class="text-lg font-medium truncate mr-5">
                    Create New User
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12">
                <div class="w-full intro-y box p-5">
                    <div class="flex flex-wrap mb-6">
                        <a-form
                            layout="vertical"
                            class="w-full grid grid-cols-2 gap-5"
                        >
                            <a-form-item label="First Name" class="col-span-1">
                                <a-input
                                    v-model:value="data.first_name"
                                    placeholder="Enter First Name"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                />
                                <span
                                    v-if="hasError('first_name')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("first_name") }}
                                </span>
                            </a-form-item>
                            <a-form-item label="Last Name" class="col-span-1">
                                <a-input
                                    v-model:value="data.last_name"
                                    placeholder="Enter Last Name"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                />
                                <span
                                    v-if="hasError('last_name')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("last_name") }}
                                </span>
                            </a-form-item>
                            <a-form-item label="Password">
                                <a-input-password
                                    v-model:value="data.password"
                                    placeholder="Enter Password"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                    type="password"
                                    size="large"
                                />
                                <span
                                    v-if="hasError('password')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("password") }}
                                </span>
                            </a-form-item>
                            <a-form-item label="Confrim Password">
                                <a-input-password
                                    v-model:value="data.password_confirmation"
                                    placeholder="Enter Confirm password"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                    type="password"
                                    size="large"
                                />
                                <span
                                    v-if="hasError('confrim password')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("confirm_password") }}
                                </span>
                            </a-form-item>
                            <a-form-item label="Email">
                                <a-input
                                    v-model:value="data.email"
                                    placeholder="Enter Email"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                />
                                <span
                                    v-if="hasError('email')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("email") }}
                                </span>
                            </a-form-item>
                            <a-form-item label="Role">
                                <a-select
                                    :options="roles"
                                    v-model:value="data.role"
                                    placeholder="Select User Role"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                    allow-clear
                                    size="large"
                                />
                                <span
                                    v-if="hasError('role')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("role") }}
                                </span>
                            </a-form-item>
                            <a-form-item
                                label="Permission to Developers"
                                class="col-span-1"
                            >
                                <a-select
                                    :options="developers"
                                    v-model:value="data.developers"
                                    placeholder="Developer Access"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                    allow-clear
                                    mode="multiple"
                                    size="large"
                                />
                                <span
                                    v-if="hasError('developers')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("developers") }}
                                </span>
                            </a-form-item>
                            <a-form-item
                                label="Permission to Projects"
                                class="col-span-1"
                            >
                                <a-select
                                    :options="projects"
                                    v-model:value="data.projects"
                                    placeholder="Project Access"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                    allow-clear
                                    size="large"
                                    mode="multiple"
                                />
                                <span
                                    v-if="hasError('projects')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("projects") }}
                                </span>
                            </a-form-item>
                            <div class="col-span-2 flex">
                                <a-form-item label="Active" class="w-1/2">
                                    <a-switch
                                        v-model:checked="data.is_active"
                                    />
                                </a-form-item>
                                <a-form-item
                                    label="Can Generate Videos"
                                    class="w-1/2"
                                    tooltip="By selecting this option you allow user to create new users"
                                >
                                    <a-switch
                                        v-model:checked="data.can_create_user"
                                    />
                                </a-form-item>
                                <a-form-item
                                    label="Can Generate Videos"
                                    class="w-1/2"
                                    tooltip="By selecting this option you allow user to create videos"
                                >
                                    <a-switch
                                        v-model:checked="data.can_create_video"
                                    />
                                </a-form-item>
                            </div>
                            <a-space class="col-span-2 justify-end w-full">
                                <a-button> Cancel </a-button>
                                <a-button
                                    type="primary"
                                    :loading="loading"
                                    :disabled="loading"
                                    @click="onSubmit"
                                    class="btn-primary bg-blue-500"
                                >
                                    Save
                                </a-button>
                            </a-space>
                        </a-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { message } from "ant-design-vue";
import axios from "axios";

const { developers, roles } = defineProps({
    developers: Object,
    roles: Array,
});

const data = ref({
    first_name: null,
    last_name: null,
    pasword: null,
    password_confirmation: null,
    email: null,
    role: null,
    developers: [],
    projects: [],
    is_active: true,
    can_create_users: false,
    can_create_videos: false,
});

const errors = ref({});
const projects = ref([]);
const loading = ref(false);

const hasError = (type, isCheck = false) => {
    if (type in errors.value && errors.value[type][0].length > 0) {
        if (isCheck) return true;
        return errors.value[type][0];
    }
    return false;
};

const onSubmit = async () => {
    try {
        loading.value = true;
        errors.value = {};
        await axios.post("/user", data.value);
        loading.value = false;
        message.success("User created successfully");
        window.location.href = "/user";
    } catch (error) {
        loading.value = false;
        if (error.response) {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        } else {
            message.error("Internet Disconnected");
        }
    }
};

watch(
    () => data.value.developers,
    async (newDevelopers) => {
        try {
            const { data } = await axios.post(`/developer/project`, {
                developers: newDevelopers,
            });
            projects.value = data;
        } catch (errors) {
            conssole.log(error);
        }
    }
);
</script>

