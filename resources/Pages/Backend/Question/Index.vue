<script>
import MainLayout from "@pages/Vendor/Core/Backend/Layouts/MainLayout/MainLayout.vue";

export default {
    layout: (h, page) => h(MainLayout, {
        title: "Surveys",
        bc: [
            {
                label: "surveys"
            }
        ]
    }, () => page)
};
</script>
<script setup>
import Table from "@core/Components/Table.vue";
import ToggleButton from "@core/Components/Form/ToggleButton.vue";
import Icon from "@core/Components/Heroicon.vue";
import {__} from "@/Vendor/Core/Mixins/translations";
import {Link, router, useForm} from "@inertiajs/vue3";
import {useStore} from "vuex";

const props = defineProps(["questions", "errors"]);

const store = useStore();

function status(item) {
    item.status = !!item.status;
    router.put(route("admin.surveys.questions.status", {id: item.id}), {status: item.status}, {
        preserveState: true,
        preserveScroll: true
    });
}

</script>
<template>
    <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden my-6">
        <span class="text-skin-base  font-medium text-xl">{{ __("questions_list") }}</span>
        <Link :href="route('admin.surveys.questions.create')"
              as="button"
              class="btn btn-success text-sm"
              type="button">{{ __("create") }}
        </Link>
    </div>
    <div class="w-full bg-white dark:bg-gray-700 overflow-hidden shadow text-skin-base rounded-lg mb-20">
        <Table :columns="['question', {name: 'answers_count', label: 'Answers', class: 'text-center w-[1%]'}, {name: 'votes_count', label: 'Votes', class: 'text-center w-[1%]'},{name: 'status', class: 'text-center w-[1%]'},]"
               :data="questions.data"
               delete-route="admin.surveys.questions.destroy"
               divide-x
               edit-route="admin.surveys.questions.edit"
               even
               search-route="admin.surveys.questions.index">
            <template #col-content-status="{item}">
                <ToggleButton :key="item.id + '-toggle'"
                              v-model="item.status"
                              @change="status(item)"/>
            </template>
        </Table>
    </div>
</template>
<style lang="scss"
       scoped></style>
