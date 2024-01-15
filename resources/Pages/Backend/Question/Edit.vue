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
import Flap from "@core/Components/Flap.vue";
import SaveFormButton from "@core/Components/Form/SaveFormButton.vue";
import Textarea from "@core/Components/Form/Textarea.vue";
import ToggleButton from "@core/Components/Form/ToggleButton.vue";
import Icon from "@core/Components/Heroicon.vue";
import Table from "@core/Components/Table.vue";
import {reactive, ref} from "vue";
import "@vuepic/vue-datepicker/dist/main.css";
import Input from "@core/Components/Form/Input.vue";
import {Link, router, useForm} from "@inertiajs/vue3";
import {__} from "@core/Mixins/translations";
import {useStore} from "vuex";

const props = defineProps(["question", "errors"]);

const store = useStore();

const questionForm = reactive({
    form: useForm({
        id: props.question.data.id,
        question: props.question.data.question,
        tag: props.question.data.tag,
        status: props.question.data.status
    }),
    update: () => {
        questionForm.form.put(route("admin.surveys.questions.update", {question: props.question.data.id}), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => store.dispatch("backend/addAlert", {type: "success", message: __("saved")}),
            onError: () => store.dispatch("backend/addAlert", {type: "error", message: questionForm.form.errors})
        });
    }
});

const answersForm = reactive({
    flap: false,
    form: useForm({
        id: null,
        questionId: props.question.data.id,
        answer: null,
    }),
    create: () => {
        answersForm.form.reset();
        answersForm.flap = true;
    },
    edit: item => {
        answersForm.flap = true;
        answersForm.form.id = item.id;
        answersForm.form.answer = item.answer;
    },
    close: () => {
        answersForm.form.reset();
        answersForm.flap = false;
    },
    update: () => {
        answersForm.form.put(route("admin.surveys.answers.update", {id: answersForm.form.id}), {
            preserveState: false,
            preserveScroll: true,
            onSuccess: () => store.dispatch("backend/addAlert", {type: "success", message: __("saved")}),
            onError: () => store.dispatch("backend/addAlert", {type: "error", message: answersForm.form.errors}),
            onFinish: () => answersForm.close()
        });
    },
    store: () => {
        answersForm.form.post(route("admin.surveys.answers.store"), {
            preserveState: false,
            preserveScroll: true,
            onSuccess: () => store.dispatch("backend/addAlert", {type: "success", message: __("saved")}),
            onError: () => store.dispatch("backend/addAlert", {type: "error", message: answersForm.form.errors}),
            onFinish: () => answersForm.close()
        });
    }
});

</script>
<template>
    <div class="flex justify-between my-6 items-center h-14 rounded-lg overflow-hidden mt-4">
        <span class="dark:text-light font-medium text-xl">{{ __("edit_title") }}</span>
        <button as="button"
                class="btn btn-success text-sm"
                type="button"
                @click="answersForm.create">{{ __("create_answer") }}
        </button>
    </div>
    <form class="pb-8"
          @submit.prevent="questionForm.update">
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
    <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden mt-4">
        <span class="dark:text-light font-medium text-xl">{{ __("answers") }}</span>

    </div>
    <div class="w-full bg-white dark:bg-gray-700 overflow-hidden shadow text-skin-base rounded-lg mb-20">
        <Table :columns="['answer', {name: 'percent', class: 'w-[1%] text-center'}, {name: 'progress-bar', label: __('progress_bar'),show: 'sm', class: 'w-1/5'}]"
               :data="question.data.answers"
               delete-route="admin.surveys.answers.destroy"
               divide-x
               even>
            <template #col-content-progress-bar="{item}">
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-400">
                    <div :style="'width:' + item.percent"
                         class="bg-blue-600 h-1.5 rounded-full dark:bg-skin-primary-500"></div>
                </div>
            </template>
            <template #action-edit="{item}">
                <button class="w-8 h-6"
                        @click="answersForm.edit(item)">
                    <icon class="fill-skin-base w-5 h-5"
                          icon="pencil-alt"></icon>
                </button>
            </template>

        </Table>
    </div>
    <Flap v-model="answersForm.flap"
          :on-close="answersForm.close"
          close-background
          md>
        <h2 v-if="answersForm.form.id">{{ __("update") }}</h2>
        <h2 v-else>{{ __("create") }}</h2>
        <form @submit.prevent="answersForm.form.id ? answersForm.update(): answersForm.store()">
            <div class="mb-6">
                <Textarea v-model="answersForm.form.answer"
                          :errors="answersForm.form.errors"
                          :label="__('answer')"
                          autofocus
                          name="answer"
                          required/>
            </div>
            <SaveFormButton :form="answersForm.form"/>
        </form>
    </Flap>
</template>
<style>
.ck-editor__editable {
    @apply min-h-[260px] max-h-[800px]
}
</style>
