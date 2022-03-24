<template>
  <div class="page-header">
    <h4 class="page-title">{{__(route_name)}} Image</h4>
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
        <Link :href="route('booth.info',booth.id)" class="uppercase">{{__('booth')}}</Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-item">
        <strong>{{booth.name}}</strong>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li class="nav-item">
        <Link v-if="route_name =='info'" :href="route('booth.info', booth.id,)">
          <strong>{{__(route_name)}}</strong>
        </Link>
        <Link
          v-if="route_name =='product'"
          :href="route('booth.product', booth.id)"
        >{{__(route_name)}}</Link>
      </li>
      <li class="separator">
        <i class="fas fa-angle-right"></i>
      </li>
      <li v-if="route_name =='product'" class="nav-item">{{data.name}}</li>
      <li v-if="route_name =='info'" class="nav-item">{{data.title}}</li>
      <li class="separator">
        <i class="fas fa-angle-right">Images</i>
      </li>
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
    route_name: String,
    booth: Object,
    data: Object
  }
};
</script>

<style>
</style>