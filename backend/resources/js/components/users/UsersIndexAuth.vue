<template>
  <div>
    <div v-if="authError" class="card">
      <div class="card-body">
        <h5 class="card-title">Error</h5>
        <p class="card-text">Unauthorized API call</p>
      </div>
    </div>
    <div v-else v-for="(user, index) in users" :key="index" class="card">
      <div class="card-body">
        <h5 class="card-title">{{ user.name }}</h5>
        <div class="card-text">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{ user.email }}</h5>
            <small>{{ user.created_at | formatDate }}</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
      authError: false
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      axios
        .get("/api/users/auth")
        .then(response => {
          this.users = response.data;
        })
        .catch(e => {
          if (e.response.status === 401) {
            this.authError = true;
          }
        });
    }
  },
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
