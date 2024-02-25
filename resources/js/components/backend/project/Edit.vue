<template>
    <div>
        <div class="grid grid-cols-12 mt-8">
            <div class="col-span-12 lg:col-span-8 sm:col-span-12">
                <h2 class="text-lg font-medium truncate mr-5">Edit Project</h2>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12">
                <div class="w-full intro-y box p-5">
                    <div class="flex flex-wrap mb-6">
                        <a-form layout="vertical" class="w-full">
                            <a-form-item label="Name">
                                <a-input
                                    v-model:value="data.name"
                                    placeholder="Enter name"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                />
                                <span
                                    v-if="hasError('name')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("name") }}
                                </span>
                            </a-form-item>
                            <a-form-item label="Developer">
                                <a-select
                                    :options="developers"
                                    v-model:value="data.developer_id"
                                    placeholder="Select developer"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                    allow-clear
                                />
                                <span
                                    v-if="hasError('developer_id')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("developer_id") }}
                                </span>
                            </a-form-item>
                            <a-form-item label="Tag">
                                <a-input
                                    v-model:value="data.tag"
                                    placeholder="Enter tag"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                />
                                <span
                                    v-if="hasError('tag')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("tag") }}
                                </span>
                            </a-form-item>
                            <a-form-item label="Description">
                                <a-textarea
                                    v-model:value="data.description"
                                    class="placeholder:text-sm shadow-sm rounded-md"
                                    placeholder="Enter description"
                                    :rows="5"
                                />
                                <span
                                    v-if="hasError('description')"
                                    class="block mt-1 text-red-500 text-xs font-semibold"
                                >
                                    {{ hasError("description") }}
                                </span>
                            </a-form-item>
                            <div class="flex gap-x-5">
                                <a-form-item
                                    label="Browse Logo (170x150)"
                                    class="flex-1"
                                >
                                    <FileUpload
                                        ref="bannerPond"
                                        id="logo"
                                        accept_file_types="image/jpeg, image/png"
                                        label="Browse"
                                        @removeFile="
                                            onRemoveFile($event, 'logo')
                                        "
                                        max_file_size="1MB"
                                        @process="setImage($event, 'logo')"
                                        :image-validate-size-width="170"
                                        :image-validate-size-height="150"
                                        :my-files="data.logo"
                                    />
                                    <span
                                        v-if="hasError('logo')"
                                        class="block mt-1 text-red-500 text-xs font-semibold"
                                    >
                                        {{ hasError("logo") }}
                                    </span>
                                </a-form-item>
                                <a-form-item
                                    label="Active Status"
                                    class="w-1/2"
                                >
                                    <a-switch
                                        v-model:checked="data.is_active"
                                        :checked-value="1"
                                        :unchecked-value="0"
                                    />
                                </a-form-item>
                            </div>
                            <a-space class="justify-end w-full">
                                <a-button @click="goBack"> Cancel </a-button>
                                <a-button
                                    type="primary"
                                    :loading="loading"
                                    :disabled="loading"
                                    @click="onSubmit"
                                    class="btn-primary bg-blue-500"
                                >
                                    Update
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
import { ref } from "vue";
import FileUpload from "../../FileUpload.vue";
import { message } from "ant-design-vue";

const { developers, project } = defineProps({
    developers: Object,
    project: Object,
});

const data = ref(project);
const errors = ref({});
const loading = ref(false);

const setImage = (img, key) => {
    data.value[key] = img;
};

const hasError = (type, isCheck = false) => {
    if (type in errors.value && errors.value[type][0].length > 0) {
        if (isCheck) return true;
        return errors.value[type][0];
    }
    return false;
};

const goBack = () => (window.location.href = "/project");

const onRemoveFile = (_, type) => {
    data.value[type] = "";
};

const onSubmit = async () => {
    try {
        loading.value = true;
        errors.value = {};
        await axios.put(`/project/${project.id}`, data.value);
        loading.value = false;
        message.success("Project updated successfully");
        window.location.href = "/project";
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
</script>
