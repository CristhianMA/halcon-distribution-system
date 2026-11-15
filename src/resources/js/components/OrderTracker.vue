<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-7">
        <div class="card shadow-sm">
          <div class="card-header bg-dark text-white text-center py-3">
            <h2 class="mb-0 fw-bold">HALCON</h2>
            <small class="text-light">Order Tracking System</small>
          </div>

          <div class="card-body p-4">
            <h4 class="card-title mb-2">Track Your Order</h4>
            <p class="text-muted mb-4">
              Enter your Customer Number and Invoice Number below to check the current status of your order.
            </p>

            <form @submit.prevent="checkOrderStatus">
              <div class="mb-3">
                <label for="customerNumber" class="form-label fw-semibold">Customer Number</label>
                <input
                  id="customerNumber"
                  v-model="customerNumber"
                  type="text"
                  class="form-control"
                  placeholder="Enter your Customer Number (e.g., 3 or CLI-1766)"
                  required
                />
              </div>

              <div class="mb-4">
                <label for="invoiceNumber" class="form-label fw-semibold">Invoice Number</label>
                <input
                  id="invoiceNumber"
                  v-model="invoiceNumber"
                  type="text"
                  class="form-control"
                  placeholder="Enter your Invoice Number (e.g., 632209)"
                  required
                />
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg" :disabled="loading">
                  {{ loading ? 'Searching...' : 'Check Order Status' }}
                </button>
              </div>
            </form>

            <div v-if="errorMessage" class="alert alert-danger mt-4 mb-0" role="alert">
              {{ errorMessage }}
            </div>

            <div v-if="order" class="card mt-4 border-primary">
              <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">Order #{{ order.id }}</span>
                <span class="badge bg-light text-dark fs-6">{{ order.status }}</span>
              </div>
              <div class="card-body">
                <p class="mb-2"><strong>Invoice Number:</strong> {{ order.invoice_number }}</p>
                <p class="mb-2">
                  <strong>Customer:</strong> 
                  {{ order.customer?.business_name || 'Customer #' + order.customer_id }}
                  <span v-if="order.customer?.customer_number" class="text-muted">
                    ({{ order.customer.customer_number }})
                  </span>
                </p>
                <p class="mb-2"><strong>Delivery Address:</strong> {{ order.delivery_address }}</p>
                <p v-if="order.notes" class="mb-2"><strong>Notes:</strong> {{ order.notes }}</p>
                <p v-if="order.user" class="mb-0"><strong>Assigned Operator:</strong> {{ order.user.name }}</p>
              </div>
            </div>
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
      customerNumber: '',
      invoiceNumber: '',
      order: null,
      errorMessage: '',
      loading: false,
    };
  },
  methods: {
    async checkOrderStatus() {
      this.loading = true;
      this.errorMessage = '';
      this.order = null;

      try {
        const response = await axios.post('/api/orders/track', {
          customer_number: this.customerNumber.trim(),
          invoice_number: this.invoiceNumber.trim(),
        });
        this.order = response.data;
      } catch (error) {
        if (error.response && error.response.status === 404) {
          this.errorMessage = error.response.data.message;
        } else {
          this.errorMessage = 'Error retrieving order information. Please verify your data.';
        }
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>