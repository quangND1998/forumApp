<template>
  <section class="content">

    <alert :dismissible="true"></alert>

    <button
      type="button"
      class="inline-block px-8 py-4 bg-blue-600 text-white font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
       data-bs-toggle="modal"
      data-bs-target="#exampleModal"
      @click="clickModal()"
    >Create User</button>

    <!-- Modal -->
    <div
      class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModal"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable relative w-auto pointer-events-none" role="document">
        <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
          <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModal" v-if="editMode">Update User</h5>
            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModal" v-else>Create User</h5>

            <button class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" type="button"   data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="save">
              <div class="relative p-6 flex-auto">
                <div class="flex flex-wrap -mx-3 mb-6">
                  <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                      class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-first-name"
                    >{{__('name')}}</label>
                    <input
                      class="appearance-none block w-full bg-gray-200 text-gray-500 border rounded py-3 px-3  mb-3 text-xs leading-tight focus:outline-none focus:bg-white"
                      id="grid-first-name"
                      type="text"
                      placeholder
                      v-model="form.name"
                      :class="errors.name ? 'border-red-500' :''"
                    />
                    <p class="text-red-500 text-xs italic" v-if="errors.name">{{ errors.name }}</p>
                  </div>
                  <div class="w-full md:w-1/2 px-3">
                    <label
                      class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-last-name"
                    >{{__('email')}}</label>
                    <input
                      class="appearance-none block w-full bg-gray-200 text-gray-700 border text-xs border-gray-200 rounded py-3 px-3  leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      id="grid-last-name"
                      type="text"
                      placeholder="examp@example"
                      v-model="form.email"
                      :class="errors.email ? 'border-red-500' :''"
                    />
                    <p class="text-red-500 text-xs italic" v-if="errors.email">{{ errors.email }}</p>
                  </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                  <div class="w-full md:w-1/2 px-3">
                    <label
                      class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-phone"
                    >{{__('phone')}}</label>
                    <input
                      class="appearance-none block w-full bg-gray-200 text-gray-700 border text-xs border-gray-200 rounded py-3 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      id="grid-phone"
                      type="text"
                      placeholder
                      v-model="form.phone"
                      :class="errors.phone? 'border-red-500' :''"
                    />
                    <p class="text-red-500 text-xs italic" v-if="errors.phone">{{ errors.phone }}</p>
                  </div>

                  <div class="w-full md:w-1/2 px-3">
                    <label
                      class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-phone"
                    >Roles</label>

                    <Multiselect
                      v-model="form.roles"
                      mode="tags"
                      :appendNewTag="false"
                      :createTag="false"
                      :searchable="true"
                      label="name"
                      valueProp="id"
                      trackBy="name"
                      :options="roles"
                      class="multiselect-blue"
                   
                    />
                    <div class="text-red-500" v-if="errors.roles">{{ errors.roles }}</div>
                  </div>
                </div>
              </div>
              <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                <button
                  type="button"
                  class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out"
                  data-bs-dismiss="modal"
                >Close</button>
                <button
                  @click.prevent="save()"
                  type="submit"
                  class="inline-block px-6 py-2.5 bg-gray-800 text-white font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-900 hover:shadow-lg focus:bg-gray-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-900 active:shadow-lg transition duration-150 ease-in-out"
                >Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full max-w-md mr-4 mb-8 mt-8">
      <input
        v-model="term"
        @keyup="search"
        class="relative w-full px-8 py-3 text-xs rounded-r focus:shadow-outline dark:bg-gray-800 dark:border-gray-700 text-white"
        autocomplete="off"
        type="text"
        name="search"
        placeholder="Search…"
      />
    </div>
    <div class="flex flex-col mt-6">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:bg-gray-700 dark:text-gray-400">
              <thead class="bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-back text-gray-500 uppercase tracking-wider"
                  >id</th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-back text-gray-500 uppercase tracking-wider"
                  >name</th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-back text-gray-500 uppercase tracking-wider"
                  >Email</th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-back text-gray-500 uppercase tracking-wider"
                  >Phone</th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-back text-gray-500 uppercase tracking-wider"
                  >Roles</th>
                

                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(user,index) in  users.data" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                  <td class="px-6 py-4 whitespace-nowrap ">
                    <div class="flex items-center">
                      <div class="ml-4">
                        <div class="text-xs font-medium text-gray-900 dark:text-white">{{ index }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap ">
                    <div class="text-xs text-gray-900 dark:text-white">{{ user.name }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap ">
                    <div class="text-xs text-gray-900 dark:text-white" >{{ user.email }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap ">
                    <div class="text-xs text-gray-900 dark:text-white">{{ user.phone }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap ">
                    <span
                      v-for="role in user.roles"
                      :key="role.id"
                      class="bg-gray-600 text-gray-100 text-xs px-2 mx-1 py-1 rounded"
                    >{{ role.name }}</span>
                  </td>
                
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button
                    data-bs-toggle="modal"
                data-bs-target="#exampleModal"
                      class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out"
                      @click="edit(user)"
                    >Update</button>
                    <button
                      @click="deleteRow(user.id)"
                      class="inline-block px-6 py-2.5 bg-red-800 text-white font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-red-900 hover:shadow-lg focus:bg-red-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-900 active:shadow-lg transition duration-150 ease-in-out"
                    >Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination class="mt-6" :links="users.links" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import LayoutForum from "@/Pages/Forum/Layout";

import Pagination from "@/Components/Pagination";
import Alert from "@/Components/Alert";
import Multiselect from "@vueform/multiselect/dist/multiselect.vue2.js";
import admin from "./mixins/admin";
export default {
  layout: LayoutForum,
  mixins: [admin],
  props: {
    users: Object,
    roles: Array,
    errors: Object
  },

  components: {
    Link,
    Pagination,
    Alert,
    Multiselect
  },
  data() {
    return {
      term: null,
      editMode: false,
      form: this.$inertia.form({
        id: null,
        name: null,
        phone: null,
        email: null,
        roles: null
      })
    };
  },
  methods: {
    search() {
      this.$inertia.get(
        this.route("admin.users.index"),
        { term: this.term },
        {
          preserveState: true
        }
      );
    },
    clickModal() {},
    save() {
      if (this.editMode) {
        this.form.put(route("admin.users.update", this.form.id), {
          preserveState: true,
          onError: errors => {
            if (Object.keys(errors).length > 0) {
              this.editMode = true;
            }
          },
          onSuccess: page => {
            $("#exampleModal").modal("hide");
            this.reset();
          }
        });
      } else {
        this.form.post(route("admin.users.store"), {
          preserveState: true,
          onError: errors => {
            if (Object.keys(errors).length > 0) {
              this.editMode = false;
            }
          },
          onSuccess: page => {
            $("#exampleModal").modal("hide");
            this.reset();
          }
        });
      }
    },
    reset: function() {
      this.form = this.$inertia.form({
        id: null,
        name: null,
        phone: null,
        email: null,
        roles: null
      });
    },

    clickModal() {
      this.editMode = false;
      this.reset();
    },
    edit(data) {
      this.editMode = true;
      this.form.id = data.id;
      this.form.name = data.name;
      this.form.phone = data.phone;
      this.form.email = data.email;

      //trả về một biến array chưa id của permission
      // this.form = Object.assign({}, data);
      this.form.roles = this.multipleSelect(data.roles);
      this.editMode = true;
    },
    deleteRow(id) {
      if (!confirm("Are you sure want to remove?")) return;
      this.$inertia.delete(route("admin.users.destroy", id));
    }
  }
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style>
.multiselect-tags-search {
  font-size: 1.25rem;
}
</style>