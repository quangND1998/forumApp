<template>
    <div
        class="forum-comment-edit-links relative mt-4 -mb-1 flex justify-end gap-x-2 md:leading-none lg:justify-start "
        style="height: 34px;"
    >
        <button
            v-if="$page.props.auth.user"
            @click="LikeReply()"
            :class="checkIsLike($page.props.auth.user.email) ? 'hover:border hover:bg-blue-200' : 'hover:border hover:border-gray-400 bg-gray-200'"
            class="rounded-md inline-flex items-center border dark:bg-[#213154]  border-solid border-deep-black/3 bg-gray-200 px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs reply-likes mobile:text-sm has-none border-deep-black/3 bg-grey-200 mr-auto md:mr-0"
        >
            <svg
                :class="checkIsLike($page.props.auth.user.email) ? 'cursor-pointer fill-current text-blue-500' : 'cursor-pointer fill-current text-gray-300'"
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
            <button
                v-if="$page.props.auth.user && $page.props.auth.user.id !== comment.owner.id"
                @click="onClickReply"
                class="rounded-md inline-flex items-center dark:bg-[#213154]  hover:border hover:border-gray-400 border border-solid border-deep-black/3 bg-grey-200 px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs mr-2 text-grey-800"
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
        <i
            v-if="$page.props.auth.user && $page.props.auth.user.id == comment.owner.id"
            @click="onEdit(comment)"
            class="fas fa-edit cursor-pointer dark:bg-[#213154] rounded-md inline-flex items-center border border-solid border-deep-black/3 bg-gray-200 px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs reply-likes mobile:text-sm has-none border-deep-black/3 bg-grey-200 mr-auto md:mr-0"
        ></i>
        <div
            v-if="$page.props.auth.user && $page.props.auth.user.id == conversation.owner.id && $page.props.auth.user.id !== comment.owner.id"
            class="rounded-md inline-flex items-center hover:border hover:border-gray-400  border border-solid border-deep-black/3 bg-grey-200 px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs mr-2 text-grey-800"
        >
            <div class="flex justify-center" >
                <div class="form-check">
                    <input
                        class=" flex justify-center form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white  checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
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
    </div>
</template>

<script>
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
        checkIsLike(email) {
            if (email && this.comment.likes.length > 0) {
                let array = this.comment.likes.filter(element => element.email == email)
                if (array.length > 0) {
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
        }

    }
}
</script>

<style>
</style>