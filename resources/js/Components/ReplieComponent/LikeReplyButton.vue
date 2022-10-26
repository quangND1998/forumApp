<template>
    <div
        class="forum-comment-edit-links relative mt-4 -mb-1 flex justify-end gap-x-2 md:leading-none lg:justify-start " 
        style="height: 34px;"
    >
        <ToggleFavorite     v-if="$page.props.auth.user" :comment="comment" :user="$page.props.auth.user" />
        <!-- <button
            v-if="$page.props.auth.user"
            @click="LikeReply()"
            :class="checkIsLike($page.props.auth.user.name) ? 'hover:border hover:bg-blue-200' : 'hover:border hover:border-gray-400 bg-gray-200'"
            class="rounded-md inline-flex items-center border dark:bg-[#213154]  border-solid border-deep-black/3 bg-gray-200 px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs reply-likes mobile:text-sm has-none border-deep-black/3 bg-grey-200 mr-auto md:mr-0"
            :title="`Liked by ${comment.likes} `"
        >
            <svg
                :class="checkIsLike($page.props.auth.user.name) ? 'cursor-pointer fill-current text-blue-500' : 'cursor-pointer fill-current text-gray-300'"
                width="17"
                height="16"
                viewBox="0 0 14 13"
            >
                <path
                   
                    fill-rule="nonzero"
                    d="M13.59 1.778c-.453-.864-3.295-3.755-6.59.431C3.54-1.977.862.914.41 1.778c-.825 1.596-.33 4.014.823 5.18L7.001 13l5.767-6.043c1.152-1.165 1.647-3.582.823-5.18z"
                />
            </svg>


            <span class="ml-1" v-if="comment.likes.length > 0">{{ comment.likes.length }}</span>
        </button> -->
         <button
            v-else
            class="rounded-md inline-flex items-center border dark:bg-[#1d3151]   border-deep-black/3 bg-gray-200 px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs reply-likes mobile:text-sm has-none border-deep-black/3 bg-grey-200 mr-auto md:mr-0"
            :title="comment.likes.length >0 ?`Liked by ${comment.likes} `:''"
        >
            <svg
                class="cursor-pointer fill-current text-gray-300"
                width="17"
                height="16"
                viewBox="0 0 14 13"
            >
                <path
                    fill-rule="nonzero"
                    d="M13.59 1.778c-.453-.864-3.295-3.755-6.59.431C3.54-1.977.862.914.41 1.778c-.825 1.596-.33 4.014.823 5.18L7.001 13l5.767-6.043c1.152-1.165 1.647-3.582.823-5.18z"
                />
            </svg>
            <span class="ml-1" v-if="comment.likes.length > 0">{{ comment.likes.length }}</span>
        </button>
        <div class="flex">
            <button :disabled="isBlock()" :title="isBlock() ? 'You account is block':''"
                v-if="$page.props.auth.user && $page.props.auth.user.id !== comment.owner.id"
                @click="onClickReply"
                class="rounded-md inline-flex items-center dark:bg-[#1d3151]  bg-gray-200 hover:border hover:border-gray-400 border-deep-black/3 bg-grey-200 px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs mr-2 text-grey-800"
            >
                <svg width="12" height="13" viewBox="0 0 12 13" class="mr-1 lg:hidden">
                    <path
                        fill="#78909C"
                        stroke="#78909C"
                        stroke-width=".5"
                        fill-rule="evenodd"
                        d="M6.96 1.877L4.34.542l.435 1.413a5.196 5.196 0 0 0-3.161 2.64C.32 7.133 1.267 10.2 3.73 11.455s5.5.218 6.794-2.32a5.203 5.203 0 0 0 .316-3.989l-1.145.369c.338.955.29 2.087-.22 3.086-.99 1.944-3.308 2.735-5.194 1.774-1.887-.962-2.61-3.302-1.619-5.246a4.085 4.085 0 0 1 2.461-2.045l.46 1.493 1.377-2.7z"
                    />
                </svg>
                Reply
            </button>
        </div>
        <button   v-if="$page.props.auth.user && $page.props.auth.user.id == comment.owner.id" class="dark:bg-[#213154] rounded-md inline-flex items-center  hover:border hover:border-gray-400 border-deep-black/3 bg-gray-200 px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs reply-likes mobile:text-sm has-none border-deep-black/3 bg-grey-200 mr-auto md:mr-0"
            @click="onEdit(comment)"
            :disabled="isBlock() " :title="isBlock() ? 'You account is block':''" >
            <i
          
            class="fas fa-edit cursor-pointer "
        ></i>
        </button>
       
        <div
            v-if="$page.props.auth.user && $page.props.auth.user.id == conversation.owner.id && $page.props.auth.user.id !== comment.owner.id"
            class="rounded-md inline-flex items-center hover:border hover:border-gray-400 bg-gray-200 dark:bg-[#1d3151]  border-deep-black/3  px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs mr-2 text-grey-800"
        >
            <div class="flex justify-center" >
                <div class="form-check">
                    <input
                    :disabled="isBlock() " :title="isBlock() ? 'You account is block':''"
                        class=" flex justify-center form-check-input appearance-none h-4 w-4  rounded-sm bg-white  checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mx-auto align-top bg-no-repeat bg-center bg-contain float-left  mr-2 cursor-pointer"
                        type="checkbox"
                        value
                        :checked="comment.best_answer == 1 ? true : false"
                        @change="onChangeBestAnswer(comment, $event)"
                    />
                    <label
                        class="form-check-label inline-block text-gray-800 dark:text-white"
                        for="flexCheckChecked"
                    >Best Answer</label>
                </div>
            </div>
        </div>
        <div class="flex justify-center">
      <div v-if="hasAnyPermission(['Admin'])">
        <div class="dropdown relative">
          <button
            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            type="button"
            id="dropdownMenuButton1"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg>
          </button>
          <ul
            class="dropdown-menu min-w-max absolute hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none"
            aria-labelledby="dropdownMenuButton1"
          >
            <li class="cursor-pointer">
              <button type="button"  @click="deleteReplie()"
                class=" text-sm py-2 px-4 font-normal block w-full whitespace-nowrap   bg-transparent text-gray-700 hover:bg-gray-100 "
              
              >Delete</button>
            </li>
            <!-- <li>
              <a
                class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                href="#"
              >Another action</a>
            </li>
            <li>
              <a
                class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                href="#"
              >Something else here</a>
            </li> -->
          </ul>
        </div>
      </div>
    </div>
        
    </div>
</template>

<script>
import ToggleFavorite from '@/Components/ReplieComponent/ToggleFavorite'
export default {
    props: {
        replie: Object,
        conversation: Object,
        comment: Object
    },
    data() {
        return {
            form: {

            }
        }
    },
    components:{
        ToggleFavorite
    },


    methods: {
        onClickReply() {
            window.ChatterEvents.$emit('ReplieEvent', this.replie, this.comment)
        },
        LikeReply() {
            this.$inertia.post(
                this.route("admin.replie.like", this.comment.id), this.form,
                { preserveState: true, preserveScroll: true }
            );
            //    axios
            //     .post("/admin/replie/likeReplie/"+ this.comment.id, this.form)
            //     .then(response => {
                  
            //     }).catch(function (error) {
            //         // handle error
            //         console.log(error);
            //     });
        },
        checkIsLike(name) {
            if (name && this.comment.likes.length > 0) {
                if (this.comment.likes.includes(name)) {
                    return true;
                }
                return false;
            }
            else {
                return false;
            }

        },
        onEdit(data) {
            window.ChatterEvents.$emit('editReplyEvent', data)
        },
        onChangeBestAnswer(data, event) {
            if (event.target.checked) {
                this.form.best_answer = 1;
            } else {
                this.form.best_answer = 0;
            }
            let query = {
                id: data.id,
                best_answer: this.form.best_answer
            };
            this.$inertia.post(this.route("admin.replie.bestAnswer"), query, {
                preserveScroll: true
            });
            //   axios
            //     .post("/admin/replie/best_answer", query)
            //     .then(response => {
                    
            //     }).catch(function (error) {
            //         // handle error
            //         console.log(error);
            //     });
        },
        deleteReplie(){
            if (!confirm("Are you sure want to remove?")) return;
            this.$inertia.delete(this.route("admin.replie.deleteReplie", this.comment.id), null, {
                preserveState: true
            });
        }

    }
}
</script>

<style>
</style>