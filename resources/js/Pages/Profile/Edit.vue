<template>
    <div class="3xl:flex">
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
                                            <div class="flex justify-between gap-x-1">
                                                <Link
                                                    class="btn btn-dark-blue rounded-md px-2 py-1 text-[12px] normal-case"
                                                >Edit</Link>
                                            </div>
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

        <div class="section mt-[-71px] md:mt-[-96px]">
            <div class="py-6">
                <div>
                    <ul class="mb-8 flex justify-center lg:text-2lg" role="tablist">
                        <li
                            class="mx-4 mb-1 pb-1 lg:px-4 after:block after:h-1 after:w-full after:rounded-full after:bg-blue-400"
                        >
                            <button
                                class="h-full font-medium text-white focus:outline-none"
                                role="tab"
                                aria-selected="true"
                                style="padding-bottom: 12px;"
                            >Activity</button>
                        </li>
                    </ul>
                    <div>
                        <div class="container">
                            <div class="lg:mx-auto lg:w-2/3">
                                <div class="timeline-section flex">
                                    <div class="timeline-date mr-3">
                                        <div class="inline-block text-right">
                                            <div
                                                class="mb-1 flex text-xs font-semibold uppercase text-black lg:text-sm"
                                            >
                                                <div
                                                    class="h-7 mr-1 flex w-10 items-center justify-center rounded-lg border border-solid border-blue-200 bg-white text-xs"
                                                >Mar</div>
                                                <div
                                                    class="h-7 flex w-10 items-center justify-center rounded-lg border border-solid border-blue-200 bg-white text-lg"
                                                    style="box-shadow: rgba(36, 37, 38, 0.08) 4px 4px 15px 0px;"
                                                >20</div>
                                                <div
                                                    class="text-xs font-medium text-gray-500"
                                                >3m ago</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="relative rounded-xl px-5 py-4 border border-grey-200 bg-white timeline-contents-item mb-5 h-auto w-full border p-6"
                                    >
                                        <div
                                            class="timeline-contents-activity absolute flex h-full justify-center"
                                        >
                                            <div
                                                class="timeline-contents-activity-icon flex h-10 w-10 items-center justify-center rounded-full border border-card bg-white p-2"
                                            ></div>
                                        </div>
                                        <p
                                            class="mb-4 text-2lg font-semibold tracking-normal text-deep-black"
                                        >
                                            Started a new Conversation
                                            <Link
                                                class="link font-normal"
                                                href="https://laracasts.com/discuss/channels/laravel/laravel-how-do-i-set-focus-on-an-invalid-input-field"
                                            >Laravel : How do i set focus on an invalid input field</Link>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
.text-white {
    --tw-text-opacity: 1;
    color: rgb(255 255 255 / var(--tw-text-opacity));
}
.timeline-date {
    padding-top: 0;
}
.timeline-date,
.timeline-section {
    position: relative;
}
a.link:not(.no-transition) {
    transition: color 0.3s;
}

.font-normal {
    font-weight: 400;
}
.link {
    --tw-text-opacity: 1;
    color: rgb(50 138 241 / var(--tw-text-opacity));
}
a {
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s, border 0.3s;
}
a {
    color: inherit;
    text-decoration: inherit;
}
.btn-dark-blue {
    --tw-text-opacity: 1;
    align-items: center;
    background-color: rgba(50, 138, 241, 0.1);
    border-color: transparent;
    color: rgb(255 255 255 / var(--tw-text-opacity));
    display: inline-flex;
    font-weight: 500;
}
</style>