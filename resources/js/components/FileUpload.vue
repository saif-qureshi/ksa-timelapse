<template>
  <file-pond
    name="test"
    ref="pond"
    :label-idle="label"
    :allow-multiple="allow_multiple"
    :max-file-size="max_file_size"
    :accepted-file-types="accept_file_types"
    :server="{ process, revert, load }"
    :allow-revert="true"
    :force-revert="true"
    @removefile="removeFile"
    :files="files"
    :allowImageValidateSize="Boolean(imageValidateSizeWidth)"
    :imageValidateSizeMinWidth="imageValidateSizeWidth"
    :imageValidateSizeMaxWidth="imageValidateSizeWidth"
    :imageValidateSizeMinHeight="imageValidateSizeHeight"
    :imageValidateSizeMaxHeight="imageValidateSizeHeight"
  />
</template>

<script>
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginPdfPreview from "filepond-plugin-pdf-preview";
import FilePondPluginImageValidateSize from "filepond-plugin-image-validate-size";

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFileValidateSize,
  FilePondPluginImageValidateSize,
  FilePondPluginPdfPreview
);
export default {
  name: "FileUpload",
  props: [
    "label",
    "myFiles",
    "max_file_size",
    "allow_multiple",
    "accept_file_types",
    "imageValidateSizeWidth",
    "imageValidateSizeHeight"
  ],
  components: {FilePond},
  data: function () {
    return {
      files: [],
      load: {
        url: "/image/fetch?load=",
      },
    };
  },
  created() {
    this.buildFilePondFileArray();
  },
  methods: {
    process(fieldName, file, metadata, load, error, progress, abort) {
      let formData = new FormData();
      formData.append("test", file);
      axios
        .post(`/image/upload`, formData)
        .then((res) => {
          load(res.data);
          this.$emit("process", res.data);
        })
        .catch(() => abort());
    },
    revert(uniqueFileId, load) {
      axios
        .delete(`/image/delete?file=${uniqueFileId}`)
        .then(() => {
          load();
        })
        .catch(console.log);
    },
    removeFile(a, metadata) {
      this.$emit("removeFile", metadata.file.name);
    },
    buildFilePondFileArray(filesArray = this.myFiles) {
      if (this.myFiles === null) return;
      let filePondArray = [];
      if (filesArray !== undefined) {
        if (typeof filesArray === "string") {
          filesArray = filesArray.split(",").filter((item) => item);
        }
        filesArray.forEach((value) => {
          filePondArray.push({
            source: value,
            options: {
              type: "local",
            },
          });
        });
      }
      this.files = filePondArray;
    },
  },
};
</script>
