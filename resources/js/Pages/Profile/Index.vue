<template>
    <div class="4xl:flex">
        <div class="header-wrap relative main-banner-gradient lg:rounded-b-[26px]">
            <section class="pt-0 pb-[60px] md:pt-8">
                <div class="px-0 pt-0 pb-1">
                    <div class="container" style="max-width: 1070px;">
                        <div class="mx-auto max-w-sm lg:mx-0 lg:flex lg:max-w-full lg:items-center">
                            <div class="flex justify-center">
                                <div class="profile-avatar pr-6">
                                    <div class="lg:block">
                                        <div class="relative flex flex-col items-center">
                                            <Link
                                                :href="route('profile', user.name)"
                                                class="relative flex items-start mb-2 bg-deep-black/10 p-2"
                                                style="width: 112px; height: 112px; padding: 2px; border-radius: 30px;"
                                            >
                                                <img
                                                    src="//www.gravatar.com/avatar/92df97f4c0723ebc9d7d974efba7a1af?s=100&d=https%3A%2F%2Fs3.amazonaws.com%2Flaracasts%2Fimages%2Fforum%2Favatars%2Fdefault-avatar-35.png"
                                                    class="relative bg-white text-deep-black/10 mb-4 lg:mb-0 p-1"
                                                    style="width: 100%; max-width: none; border-radius: 24px;"
                                                    height="112"
                                                    width="112"
                                                    alt
                                                />
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:mr-6">
                                    <div class="mb-8">
                                        <div class="flex w-full flex-col items-start text-white">
                                            <div class="flex">
                                                <h1
                                                    class="font-poppins text-xl tracking-normal lg:mr-4"
                                                >@{{ user.name }}</h1>
                                            </div>
                                            <div
                                                class="text-[12px] tracking-normal"
                                            >Member Since {{ user.time_ago }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue"
export default {
    props: {
        user: Object
    },
    components: {
        Link
    }

}
</script>
<style scoped>
.main-banner-gradient {
    background-image: radial-gradient(circle at 0 2%, #0b192c, #172337 99%);
}
</style>