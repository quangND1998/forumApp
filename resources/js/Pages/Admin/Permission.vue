<template>
  <section class="content">

    <button
      type="button"
      class="inline-block px-8 py-4 bg-blue-600 text-white font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
      data-bs-toggle="modal"
      data-bs-target="#exampleModal"
    >Create Permission</button>

    <div
      class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto "
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalCenteredScrollable"
      aria-modal="true"
      role="dialog"
    >
      <div
        class="modal-dialog modal-dialog-centered modal-dialog-scrollable relative w-auto pointer-events-none "
      >
        <div
          class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current dark:bg-gray-800 dark:border-gray-700"
        >
          <div
            class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md"
          >
            <h5
              class="text-xl font-medium leading-normal text-gray-800 dark:text-white"
              v-if="editMode"
            >Update Permission</h5>
            <h5 class="text-xl font-medium leading-normal text-gray-800 dark:text-white"  v-else>Create Permission</h5>
            <button
              type="button"
              class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body relative p-4">
            <form @submit.prevent="save">
              <div class="form-group" :class="errors.name ? 'is-valid' :''">
                <label for="recipient-name" class="col-form-label dark:text-white">Name:</label>
                <input
                  type="text"
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border text-xs border-gray-200 rounded py-3 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  :class="errors.name ? 'border-red-500' :''"
                  v-model="form.name"
                  id="name"
                />
                <div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
              </div>
              <div
                class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md"
              >
                <button
                  type="button"
                  class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out"
                  data-bs-dismiss="modal"
                >Close</button>
                <button
                  @click.prevent="save()"
                  type="submit"
                  class=" ml-1 inline-block px-6 py-2.5 bg-blue-600 text-white font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-900 hover:shadow-lg focus:bg-blue-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-900 active:shadow-lg transition duration-150 ease-in-out"
                >Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-5">
      <table class="w-full text-xs text-left text-gray-500 dark:text-gray-400">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th scope="col" class="py-3 px-6 text-xs">STT</th>
            <th scope="col" class="py-3 px-6 text-xs">name</th>
            <th scope="col" class="py-3 px-6 text-xs">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(permission,index) in permissions.data"
            :key="index"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
          >
            <th
              scope="row"
              class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >{{ index}}</th>
            <th
              scope="row"
              class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >{{permission.name}}</th>
            <td class="py-4 px-6 text-right">
              <button
                @click="edit(permission)"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
                class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out"
              >Edit</button>
              <button
                type="button"
                @click="Delete(permission.id)"
                class="inline-block px-6 py-2.5 bg-red-800 text-white font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-red-900 hover:shadow-lg focus:bg-red-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-900 active:shadow-lg transition duration-150 ease-in-out"
              >Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination :links="permissions.links" />
  </section>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import LayoutForum from "@/Pages/Forum/Layout";
import Pagination from "@/Components/Pagination";
import Alert from "@/Components/Alert";

export default {
  layout: LayoutForum,
  components: {
    Link,
    Pagination,
    Alert
  },
  props: {
    errors: Object,
    permissions: Object
  },
  data() {
    return {
      editMode: false,
      showModal: false,
      form: this.$inertia.form({
        id: null,
        name: null
      })
    };
  },
  mounted() {},
  methods: {
    save() {
      if (this.editMode) {
        this.form.put(route("admin.permissions.update", this.form.id), {
          preserveState: true,
          onError: errors => {
            if (Object.keys(errors).length > 0) {
              this.editMode = true;
            }
          },
          onSuccess: page => {
            $("#exampleModal").modal("hide");
            this.form.reset();
          }
        });
      } else {
        this.form.post(route("admin.permissions.store"), {
          preserveState: true,
          onError: errors => {
            if (Object.keys(errors).length > 0) {
              this.editMode = false;
            }
          },
          onSuccess: page => {
            $("#exampleModal").modal("hide");
            this.form.reset();
          }
        });
      }
    },

    clickModal() {
      this.editMode = false;
      $('#exampleModal').on('shown.bs.modal', function () {
        $('#name').focus()
    });
      this.form.reset();
    },
    edit(data) {
      this.editMode = true;
      this.form.id = data.id;
      this.form.name = data.name;
      $('#exampleModal').on('shown.bs.modal', function() {
                $('#nameTour').focus()
            });
    },
    Delete(id) {
      if (!confirm("Are you sure want to remove?")) return;
      this.$inertia.delete(route("admin.permissions.delete", id));
    }
  }
};
</script>

<style>
</style>