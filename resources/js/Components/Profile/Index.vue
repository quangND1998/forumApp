<template>
    <main class="profile-page">
      <section class="relative block" style="height: 500px;">
        <div
          class="absolute top-0 w-full h-full bg-center bg-cover"
          style='background-image: url("logo/MX_CoverSQ.png");'
        >
          <span
            id="blackOverlay"
            class="w-full h-full absolute opacity-50 bg-black"
          ></span>
        </div>
        <div
          class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden"
          style="height: 70px;"
        >
          <svg
            class="absolute bottom-0 overflow-hidden"
            xmlns="http://www.w3.org/2000/svg"
            preserveAspectRatio="none"
            version="1.1"
            viewBox="0 0 2560 100"
            x="0"
            y="0"
          >
            <polygon
              class="text-gray-300 fill-current"
              points="2560 0 2560 100 0 100"
            ></polygon>
          </svg>
        </div>
      </section>
      <section class="relative py-16 bg-gray-300 mt-10 sm:mt-0" >
        <div class="container mx-auto px-4">
          <div
            class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64"
          >
            <div class="px-6 ">
              <div class="flex flex-wrap justify-center">
                <div
                  class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center"
                >
                  <div class="relative">
                    <img
                      alt="..."
                      :src="user.avatar"
                      class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 lg:-ml-16"
                      style="max-width: 150px;"
                    />
                  </div>
                </div>
                <div
                  class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center"
                >
      
                </div>
                <div class="w-full lg:w-4/12 px-4 lg:order-1">
                  <div class="flex justify-center py-4 lg:pt-4 pt-8">
                    <div class="mr-4 p-3 text-center">
                      <span
                        class="text-xl font-bold block uppercase tracking-wide text-gray-700"
                        >{{user.conversations.length}}</span
                      ><span class="text-sm text-gray-500">Questions</span>
                    </div>
                    <div class="mr-4 p-3 text-center">
                      <span
                        class="text-xl font-bold block uppercase tracking-wide text-gray-700"
                        >{{total_view}}</span
                      ><span class="text-sm text-gray-500">Views</span>
                    </div>
                    <div class="lg:mr-4 p-3 text-center">
                      <span
                        class="text-xl font-bold block uppercase tracking-wide text-gray-700"
                        >{{total_replies}}</span
                      ><span class="text-sm text-gray-500">Comments</span>
                    </div>
                    <div class="lg:mr-4 p-3 text-center">
                      <span
                        class="text-xl font-bold block uppercase tracking-wide text-gray-700"
                        >{{user.replies.length}}</span
                      ><span class="text-sm text-gray-500">Like</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-center mt-12">
                <h3
                  class="text-4xl font-semibold leading-normal mb-2 text-gray-800 mb-2"
                >
                     {{user.name}}
                </h3>
                <div
                  class="text-sm leading-normal mt-0 mb-2 text-gray-500 font-bold uppercase"
                >
                  <i
                    class="fas fa-map-marker-alt mr-2 text-lg text-gray-500"
                  ></i>
                 {{user.address}} , {{user.country}}
                </div>
                <!-- <div class="mb-2 text-gray-700 mt-10">
                  <i class="fas fa-briefcase mr-2 text-lg text-gray-500"></i
                  >
                </div> -->
                
              </div>
              <div class="mt-10 py-10 border-t border-gray-300 text-center">
                <div class="flex flex-wrap justify-center">
                  <div class="w-full lg:w-9/12 px-4">
                    <p class="mb-4 text-lg leading-relaxed text-gray-800">
                      {{user.about_you}}
                    </p>

                  </div>
                </div>
              </div>
            </div>


                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form @submit.prevent="save">
                      <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                          <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                              <label for="first_name" class="block text-sm font-medium text-gray-700"> Name</label>
                              <input v-model="form.name" type="text" name="first_name" id="first_name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                  <div
                                                class="text-red-500"
                                                v-if="errors.name"
                                            >{{ errors.name }}</div>
                            </div>

                        
                            <div class="col-span-6 sm:col-span-3">
                              <label for="email_address" class="block text-sm font-medium text-gray-700">Email </label>
                              <input   v-model="form.email" type="text" name="email_address" id="email_address" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <div
                                                class="text-red-500"
                                                v-if="errors.email"
                                            >{{ errors.email }}</div>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                           <country-select class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="form.country" :country="form.country" topCountry="United States" :countryName="true" />
                           <div
                                                class="text-red-500"
                                                v-if="errors.country"
                                            >{{ errors.country }}</div>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="street_address" class="block text-sm font-medium text-gray-700">Street address</label>
                              <input type="text"  v-model="form.address" name="street_address" id="street_address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <div
                                                class="text-red-500 "
                                                v-if="errors.address"
                                            >{{ errors.address }}</div>
                            </div>
                              <div class="col-span-6">
                                <label for="street_address" class="block text-sm font-medium text-gray-700">About you</label>
                                    <div class="mt-1">
                                      <textarea  v-model="form.about_you" id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="
Introduce yourself"></textarea>
                                    </div>
                              </div>
                         
                                <label class="block text-sm font-medium text-gray-700">
                                  Cover photo
                                </label>
                                <div class="col-span-6 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                  <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="True">
                                      <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                      <label @input="form.avatar = $event.target.files[0]" for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                      </label>
                                      <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                      PNG, JPG, GIF up to 2MB
                                    </p>
                                  </div>
                                </div>
                                  <div
                                                class="text-red-500"
                                                v-if="errors.avatar"
                                            >{{ errors.avatar }}</div>
                          </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                          <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
          </div>

          
        </div>
        
      </section>
      
    </main>
</template>

<script>

export default {
    props:{
        user:Object,
        total_replies:Number,
        errors:Object,
        total_view:Number
    },
    components:{
   
    },
     data() {
        return {
            form: this.$inertia.form({
                name:this.user.name,
                email:this.user.email,
                about_you:this.user.about_you,
                address:this.user.address,
                country:this.user.country,
                avatar:null
                
            })
        }
    },
    methods:{
      save(){
          this.form.post(this.route('saveProfile'));
      }
    }

}
</script>

<style>

</style>