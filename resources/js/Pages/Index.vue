<template>
  <div>
    <h1>{{data}}</h1>
    <form @submit.prevent="submit">
      <input type="text" v-model="form.message" />
    </form>

    <Link :href="route('getList')" as="button" type="button">Logout</Link>
  </div>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
  components: {
    Link
  },
  data() {
    return {
      data: [],
      form: this.$inertia.form({
        message: null
      })
    };
  },
  mounted() {
    this.listenForNewConverstion();
  },
  methods: {
    listenForNewConverstion() {
      var self = this;
      // window.Echo.channel("message-send").listen("SendMessage", e => {
      //   this.data.push(e.message);
      // });
      socketio
        .emit("subscribe", {
          channel: "message-send"
        })
        .on("App\\Events\\SendMessage", function(channel, data) {
          console.log(data.message);
          self.data.push(data.message);
        });
      // window.socketio.on(
      //   "message-send:App\\Events\\SendMessage",
      //   function(e) {
      //     self.data.push(e.message);
      //   }
      // );
    },
    submit() {
      this.form.post(this.route("poss.message"), {
        preserveState: true,
        onError: errors => {
          if (Object.keys(errors).length > 0) {
            this.visible = true;
          }
        },
        onSuccess: page => {
          this.visible = false;
          this.reset();
        }
      });
    },
    reset() {
      this.form = this.$inertia.form({
        message: null
      });
    }
  }
};
</script>

<style>
</style>