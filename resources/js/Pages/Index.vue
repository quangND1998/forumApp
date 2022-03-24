<template>
    <div>
        <h1>aaaaaaaaaaaaaaa</h1>
        <Link :href="route('getList')" as="button" type="button">Logout</Link>
    </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue'
export default {
    components: {
        Link
    }

}
</script>

<style>
</style>