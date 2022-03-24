<template>
  <div class="page-header mb-8">
    <h4 class="page-title">{{name}}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <Link :href="route('virtual-expo.index')">
          <i class="fas fa-home"></i>
        </Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-item">
        <Link :href="route('virtual-expo.index')"></Link>
        {{ virtual.name }}
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-item">{{name}}</li>
    </ul>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
  components: {
    Link
  },
  props: {
    name: String,
    virtual: Object
  }

}
</script>

<style>
</style>