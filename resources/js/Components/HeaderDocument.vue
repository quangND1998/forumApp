<template>
  <div class="page-header mb-8">
    <h4 class="page-title">{{ __('document') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <i class="fas fa-home"></i>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-home">
        <Link :href="route('virtual-expo.documents.index', virtual.id)">{{ virtual.name }}</Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li v-if="route_name == null" class="nav-item">
        <Link
          :href="route('virtual-expo.documents.index', virtual.id)"
          class="uppercase"
        >{{ __('virtual_expo') }}</Link>
      </li>
      <li v-else class="nav-item">
        <Link
          :href="route('virtual-expo.booth.index', virtual.id)"
          class="uppercase"
        >{{ route_name }}</Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-home">
        <Link :href="route('virtual-expo.booth.index', virtual.id)">{{ data.name }}</Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-item">
        <Link v-if="route_name == null" :href="route('virtual-expo.documents.index', virtual.id)">
          <i class="fas fa-angle-right">{{ __('document') }}</i>
        </Link>
        <Link v-else :href="route('virtual-expo.booth.documents', [virtual.id, data.id])">
          <i class="fas fa-angle-right">{{ __('document') }}</i>
        </Link>
      </li>
    </ul>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
  props: {
    route_name: String,
    virtual: Object,
    data: Object
  },
  components: {
    Link
  }
}
</script>

<style>
</style>