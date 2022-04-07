<template>
    <div >

        <div class="bg-white rounded shadow overflow-x-auto ">
            <div class="text-gray-800 antialiased"></div>

            <profile :user="user" :total_replies="total_replies" :errors="errors" :total_view="total_view"></profile>
        </div>
        <Footer></Footer>
    </div>
</template>

<script>
import Profile from '@/Components/Profile/Index'
import Footer from '@/Components/Footers/Footer'
import { Link } from "@inertiajs/inertia-vue"
export default {
    props: {
        user: Object,
        total_replies:Number,
        errors:Object,
        total_view:Number
    },
    components: {
        Link,
        Profile,
        Footer
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

.input.is-minimal,
.textarea.is-minimal {
    --tw-border-opacity: 1;
    background: 0 0;
    border: none;
    border-bottom: 1px solid;
    border-color: rgb(235 237 241 / var(--tw-border-opacity));
    padding-left: 0;
    padding-right: 0;
}
</style>