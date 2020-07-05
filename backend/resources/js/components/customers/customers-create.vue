<template>
  <div class="card mb-3">
    <div class="card-content">
      <div class="card-body">
        <h4 class="card-title">Add Customer</h4>
        <h6 class="card-subtitle text-muted">test</h6>
      </div>
      <div class="card-body">
        <!-- <p class="card-text">Add new customer here</p> -->
        <div class="form-group">
          <label for="name">Name</label>
          <input
            v-model="customer.name"
            type="text"
            class="form-control"
            name="name"
            id="name"
            aria-describedby="nameHelp"
          />
          <small id="nameHelp" class="form-text text-muted">Enter the customers name</small>
        </div>
        <!-- <a href="#" class="card-link">Card link</a>
        <a href="#" class="card-link">Another link</a>-->
        <div class="card-actions">
          <div class="text-right">
            <button type="button" class="btn btn-secondary">Cancel</button>
            <button type="button" class="btn btn-primary" @click="storeCustomer">Save</button>
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
      authError: false,
      customer: {
        name: ""
      },
      test: "########"
    };
  },
  created() {
    // this.fetchCustomers();
  },
  methods: {
    storeCustomer() {
      axios
        .post("/api/user/customers", {
          customer: this.customer
        })
        .then(response => {
          this.$emit("customerStored", response.data);
        })
        .catch(e => {
          if (e.response.status === 401) {
            this.authError = true;
          }
        });
    },
    store: () => {}
  },
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
