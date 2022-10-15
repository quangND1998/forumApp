<template>
    <div>
        <Notification></Notification>
        <div
            v-on:click="toggleModal()"
            class="border border-blue-600 text-blue-800 dark:text-gray-700 dark:bg-gray-100 hover:bg-blue-200 w-1/6 font-bold py-2 px-4 mr-1 mb-2 rounded-full text-center cursor-pointer"
        >New Chanel</div>

        <form class="space-y-4 text-gray-700 ">
            <div
                v-if="showModal"
                class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex"
            >
                <div class="relative w-auto my-6 mx-auto max-w-3xl">
                    <!--content-->
                    <div
                        class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white  dark:bg-gray-700  dark:text-gray-100 outline-none focus:outline-none"
                    >
                        <!--header-->
                        <div
                            class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t"
                        >
                            <h3
                                v-if="editMode == false"
                                class="text-3xl font-semibold"
                            >{{ __('create') }} Chanle</h3>
                            <h3 v-else class="text-3xl font-semibold">{{ __('update') }} Chanle</h3>
                            <button
                                class="p-1 ml-auto bg-transparent border-0 text-gray-300 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                                v-on:click="closeModal()"
                            >
                                <span
                                    class="bg-transparent h-6 w-6 text-2xl block outline-none focus:outline-none"
                                >
                                    <i class="fas fa-times"></i>
                                </span>
                            </button>
                        </div>
                        <!--body-->
                        <div class="md:flex">
                            <div class="w-full">
                                <div class="p-3">
                                    <div class="mb-2">
                                        <span class="text-sm">Name</span>
                                        <input
                                            type="text"
                                            v-model="form.title"
                                            class="h-8 px-3 w-full border-gray-200  border rounded focus:outline-none focus:border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required
                                        />
                                        <div
                                            class="text-red-500"
                                            v-if="errors.title"
                                        >{{ errors.title }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-sm">Description</span>
                                        <textarea  v-model="form.description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your SubTitle..."></textarea>
                                        <div
                                            class="text-red-500"
                                            v-if="errors.description"
                                        >{{ errors.description }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-sm">Color</span>
                                        <div class="one-colorpicker" ref="colorpicker">
                                            <div
                                                id="bg_color_bottom"
                                                class="color-block"
                                                :style="{ backgroundColor: form.color }"
                                                @click="toggle($event)"
                                            >
                                                <div
                                                    class="color-block-layer value"
                                                    :style="{ backgroundColor: form.color }"
                                                ></div>
                                                <div class="color-block-layer bg"></div>
                                            </div>
                                            <color-panel
                                                class="color-panel"
                                                id="bg_color_bottom_1"
                                                v-model="form.color"
                                            ></color-panel>
                                        </div>
                                        <p
                                            class="text-red-500 text-xs italic"
                                            v-if="errors.color"
                                        >{{ errors.color }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--footer-->
                        <div
                            class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b"
                        >
                            <button
                                class="w-32 inline-block bg-gray-200 hover:bg-gray-500 font-bold py-2 px-4 rounded-full text-center cursor-pointer mr-2 dark:bg-red-600  dark:text-gra-200 "
                                type="button"
                                @click="closeModal()"
                            >cancel</button>
                            <button
                                class="w-32 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full text-center cursor-pointer"
                                type="submit"
                                v-show="!editMode"
                                @click.prevent="save"
                            >save</button>
                            <button
                                class="w-32 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full text-center cursor-pointer"
                                type="submit"
                                v-show="editMode"
                                @click.prevent="update"
                            >update</button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
        </form>

        <div class="bg-white rounded shadow overflow-x-auto dark:text-white dark:bg-gray-600">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">ID</th>
                    <th class="px-6 pt-6 pb-4">Name</th>
                    <th class="px-6 pt-6 pb-4">SubTitle</th>
                    <th class="px-6 pt-6 pb-4">Color</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">{{ __('action') }}</th>
                </tr>
                <tr
                    v-for="(element, index) in chanels"
                    :key="index"
                    class="hover:bg-gray-100 focus-within:bg-gray-100 dark:hover:bg-gray-700 dark:focus-within:bg-gray-700"
                >
                    <td class="border-t">{{ index }}</td>
                    <td class="border-t">{{ element.title }}</td>
                    <td class="border-t crop-content ">{{ element.description }}</td>
                    <td class="border-t">
                        <div
                            class="text-sm text-gray-900"
                            :style="{ backgroundColor: element.color }"
                        >{{ element.color }}</div>
                    </td>

                    <td class="border-t">
                        <button
                            class="h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800"
                            @click="edit(element)"
                        >{{ __('update') }}</button>
                        <button
                            v-if="hasAnyPermission(['users_manage'])"
                            @click="deleteRow(element.id)"
                            class="h-10 px-5 m-2 text-red-100 transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800"
                        >{{ __('delete') }}</button>
                    </td>
                </tr>

                <tr v-if="chanels.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No Chanel found.</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>

import Notification from "@/Components/Notification";
import { Link } from '@inertiajs/inertia-vue'
import LayoutForum from '@/Pages/Forum/Layout'
import $ from 'jquery'
export default {
    layout: LayoutForum,
    components: {
        Link,
        Notification
    },
    props: {
        chanels: Array,
        errors: Object

    },
    data() {
        return {
            editMode: false,
            showModal: false,
            image: null,
            form: this.$inertia.form({
                id: null,
                title: null,
                description:null,
                color: null,

            }),

        };
    },
    methods: {
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        closeModal: function () {
            this.showModal = false;
            this.reset();
            this.editMode = false;
        },
        save() {
            this.form.post(
                this.route("admin.channels.store"),
                {
                    preserveState: true,
                    onError: errors => {
                        if (Object.keys(errors).length > 0) {
                            this.showModal = true;
                            this.editMode = false;
                        }
                    },
                    onSuccess: page => {
                        this.showModal = false;
                        this.editMode = false;
                        this.reset();
                    },
                }
            );
        },
        toggle(event) {
            var targetId = event.currentTarget.id;
            console.log(targetId); // returns 'foo'

            $(`#${targetId}_1`).toggle();
        },
        reset: function () {
            this.form = this.$inertia.form({
                id: null,
                title: null,
                color: null,
                description:null

            });
        },

        edit: function (data) {
            this.form.id = data.id;
            this.form.title = data.title;
            this.form.color = data.color;
            this.form.description= data.description,
            this.editMode = true;
            this.toggleModal();
        },
        update: function () {
            this.form.post(this.route("admin.channels.update", this.form.id), {
                preserveState: true,
                onError: errors => {
                    if (Object.keys(errors).length > 0) {
                        this.showModal = true;
                        this.editMode = false;
                    }
                },
                onSuccess: page => {
                    this.showModal = false;
                    this.editMode = false;
                    this.reset();
                },
            });
        },
        deleteRow: function (id) {
            if (!confirm("Are you sure want to remove?")) return;
            this.$inertia.delete(
                this.route("admin.channels.delete", id),
                null,
                {
                    preserveState: true
                }
            );
        },

    }
}
</script>

<style scoped>
.color-block {
    width: 20px;
    height: 20px;
    background-color: #b87823;
    z-index: 1000;
    border: 2px solid;
}
.color-panel {
    display: none;
}
.crop-content {
  max-width: 200px;
  overflow-x: auto;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.clamp {
    -webkit-box-orient: vertical;
    display: -webkit-box;
    overflow: hidden;
}
.two-lines {
    -webkit-line-clamp: 2;
}
</style>