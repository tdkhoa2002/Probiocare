<template>
  <div class="sc-table">
    <div class="tool-bar el-row" style="padding-bottom: 20px">
      <div class="actions el-col el-col-8">
        <el-button type="primary" @click="openForm(0)">
          <i class="el-icon-edit"></i>Create
        </el-button>
      </div>
    </div>

    <el-table
      ref="pageTable"
      v-loading.body="tableIsLoading"
      :data="data"
      stripe
      style="width: 100%"
    >
      <el-table-column prop="id" label="Id" width="75" sortable="custom">
      </el-table-column>
      <el-table-column
        :label="trans('paymentmethodattrs.table.title')"
        prop="title"
      >
        <template slot-scope="scope">
          {{ scope.row.title }}
        </template>
      </el-table-column>
      <el-table-column
        :label="trans('paymentmethodattrs.table.type')"
        prop="type"
      >
        <template slot-scope="scope">
          {{ scope.row.type }}
        </template>
      </el-table-column>
      <el-table-column
        :label="trans('core.table.created at')"
        prop="created_at"
        sortable="custom"
      >
      </el-table-column>
      <el-table-column :label="trans('core.table.actions')" prop="actions">
        <template slot-scope="scope">
          <el-button-group>
            <el-button type="primary" @click="openForm(scope.row.id)" size="mini">
              <i class="el-icon-edit"></i>
            </el-button>
            <delete-button :scope="scope" :rows="data"></delete-button>
          </el-button-group>
        </template>
      </el-table-column>
    </el-table>
    <PaymentmethodAttrForm
      :locales="locales"
      :paymentmethodId="paymentmethodId"
      :paymentmethodAttrId="paymentmethodAttrId"
      :dialogFormVisible="dialogFormVisible"
      @closeForm="closeForm"
    ></PaymentmethodAttrForm>
  </div>
</template>

<script>
import axios from "axios";
import DeleteButton from "../../../../../Core/Assets/js/components/DeleteComponent.vue";
import PaymentmethodAttrForm from "./PaymentmethodAttrForm.vue";

export default {
  props: {
    locales: {
      default: null,
      type: Object,
    },
    paymentmethodId: {
      default: null,
      type: Number,
    },
  },
  components: { DeleteButton, PaymentmethodAttrForm },
  data() {
    return {
      paymentmethodAttrId: 0,
      data: [],
      dialogFormVisible: false,
      tableIsLoading: false,
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.tableIsLoading = true;
      axios
        .get(
          route("api.customer.paymentmethodattr.indexServerSide", {
            paymentmethodId: this.paymentmethodId,
          })
        )
        .then((response) => {
          this.tableIsLoading = false;
          this.data = response.data.data;
        });
    },
    openForm(paymentmethodAttrId) {
      this.paymentmethodAttrId = paymentmethodAttrId;
      this.dialogFormVisible = true;
    },
    closeForm() {
      this.paymentmethodAttrId = 0;
      this.dialogFormVisible = false;
      this.fetchData();
    },
  },
};
</script>

<style>
.text-success {
  color: #13ce66;
}

.text-danger {
  color: #ff4949;
}
</style>
