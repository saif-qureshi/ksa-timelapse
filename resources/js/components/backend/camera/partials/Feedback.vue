<template>
    <div class="bg-white p-5 rounded-md mt-5">
        <div class="border-b flex gap-2 mb-5">
            <Icon name="MessageCircleMore" :size="30" />
            <h1 class="text-2xl">Post Your Feedback</h1>
        </div>
        <a-form>
            <a-form-item>
                <a-textarea
                    placeholder="Feedback goes here"
                    :rows="5"
                >
                </a-textarea>
            </a-form-item>
            <a-form-item class="ml-auto text-right">
              <a-button class="" type="">Post</a-button>
            </a-form-item>
        </a-form>
    </div>
</template>

<script setup>
import Icon from "../../../Icon.vue";
</script>
