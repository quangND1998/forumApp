<template>
  <div>
    <div class="alert alert-success" v-if="$page.props.flash.success">{{$page.props.flash.success}}</div>
    <div class="alert alert-danger" v-if="$page.props.flash.warning">{{$page.props.flash.warning}}</div>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>