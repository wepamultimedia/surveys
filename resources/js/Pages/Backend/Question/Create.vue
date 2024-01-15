<script>
import MainLayout from "@pages/Vendor/Core/Backend/Layouts/MainLayout/MainLayout.vue";

export default {
    layout: (h, page) => h(MainLayout, {
        title: "question",
        bc: [{label: "surveys", route: "admin.surveys.questions.index"}, {label: "edit"}]
    }, () => page)
};
</script>
<script setup>
import SaveFormButton from "@core/Components/Form/SaveFormButton.vue";
import Textarea from "@core/Components/Form/Textarea.vue";
import ToggleButton from "@core/Components/Form/ToggleButton.vue";
import {reactive} from "vue";
import "@vuepic/vue-datepicker/dist/main.css";
import Input from "@core/Components/Form/Input.vue";
import {useForm} from "@inertiajs/vue3";
import {__} from "@core/Mixins/translations";
import {useStore} from "vuex";

const props = defineProps([]);

const store = useStore();

const questionForm = reactive({
    form: useForm({
        question: null,
        tag: null,
        status: true
    }),
    store: () => {
        questionForm.form.post(route("admin.surveys.questions.store"), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => store.dispatch("backend/addAlert", {type: "success", message: __("saved")}),
            onError: () => store.dispatch("backend/addAlert", {type: "error", message: questionForm.form.errors})
        });
    }
});
</script>
<template>
    <div class="flex justify-between my-6 items-center h-14 rounded-lg overflow-hidden mt-4">
        <span class="dark:text-light font-medium text-xl">{{ __("create_title") }}</span>
    </div>
    <form class="pb-8"
          @submit.prevent="questionForm.store">
        <div class="text-skin-base border dark:border-gray-600 bg-white dark:bg-gray-600 rounded-lg shadow">
            <div class="">
                <!-- question -->
                <div class="p-6">
                    <div class="mb-6">
                        <Textarea v-model="questionForm.form.question"
                                  :errors="questionForm.form.errors"
                                  :label="__('question')"
                                  autofocus
                                  name="question"
                                  required/>
                    </div>
                    <div class="mb-6">
                        <Input v-model="questionForm.form.tag"
                                  :errors="questionForm.form.errors"
                                  :label="__('tag')"
                                  name="tag"/>
                    </div>
                    <div class="mb-6">
                        <ToggleButton :key="questionForm.form.id + '-toggle'"
                                      v-model="questionForm.form.status"
                                      @change="questionForm.form.status = !!questionForm.form.status"/>
                    </div>
                </div>
            </div>
            <div class="rounded-b-lg overflow-hidden">
                <div class="p-3 bg-gray-200 dark:bg-gray-500 flex justify-end">
                    <SaveFormButton :form="questionForm.form"/>
                </div>
            </div>
        </div>
    </form>
</template>
<style>
.ck-editor__editable {
    @apply min-h-[260px] max-h-[800px]
}
</style>
