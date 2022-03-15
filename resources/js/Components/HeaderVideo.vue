<template>
  <div class="page-header mb-8">
    <h4 class="page-title">Videos</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <Link :href="route('virtual-expo.lobby.index', virtual.id)">
          <i class="fas fa-home"></i>
        </Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-item">
        <Link :href="route('virtual-expo.' + name_route + '.index', virtual.id)">{{ name_route }}</Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-item">
        <Link :href="route('virtual-expo.' + name_route + '.index', virtual.id)">{{ name }}</Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-item">Videos</li>
    </ul>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
  props: {
    name_route: String,
    virtual: Object,
    name: String
  },
  components: {
    Link
  }
}
</script>

<style>
</style>