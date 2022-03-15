<template>
  <div class="page-header mb-8">
    <h4 class="page-title">{{ name }}</h4>
    <i class="fas fa-reply" @click="Back()"></i>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <Link :href="route('booth.list')">
          <i class="fas fa-home"></i>
        </Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-item">
        <Link :href="route('booth.list')" class="uppercase">{{
          __("booth")
        }}</Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-item">
        <Link :href="route('booth.info', booth.id)">{{ booth.name }}</Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right">{{ name }}</i>
      </li>
    </ul>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
  components: {
    Link,
  },
  props: {
    name: String,
    booth: Object,
  },
  methods: {
    Back() {
      window.history.back();
    },
  },
};
</script>

<style>
</style>
