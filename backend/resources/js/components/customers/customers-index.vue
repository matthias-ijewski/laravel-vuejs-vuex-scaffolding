<template>
  <div>
    {{ customers.length }}len
    <CustomersCreate></CustomersCreate>
    <div v-if="authError" class="card">
      <div class="card-body">
        <h5 class="card-title">Error</h5>
        <p class="card-text">Unauthorized API call</p>
      </div>
    </div>
    <div v-else-if="customers.length > 0" class="card">
      <div class="card-body">
        <h4 class="card-title">Customers</h4>
        <div v-for="(customer, index) in customers" :key="index">
          <h6 class="card-subtitle">{{ customer.name }}</h6>
          <!-- <div class="card-text">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{ user.email }}</h5>
            <small>{{ user.created_at | formatDate }}</small>
          </div>
          </div>-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CustomersCreate from "./customers-create";

export default {
  components: {
    CustomersCreate
  },
  data() {
    return {
      customers: [],
      authError: false
    };
  },
  created() {
    this.fetchCustomers();
  },
  methods: {
    fetchCustomers() {
      axios
        .get("/api/user/customers")
        .then(response => {
          this.customers = response.data;
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
