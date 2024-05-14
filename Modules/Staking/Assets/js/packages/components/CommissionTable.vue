<template>
  <div>
    <div class="box-curency-attr">
      <el-table :data="commissions" style="width: 100%">
        <el-table-column prop="level" label="Level"> </el-table-column>
        <el-table-column prop="commission" label="Commission">
        </el-table-column>
        <el-table-column prop="type" label="Type">
          <template slot-scope="scope">
            <span v-if="scope.row.type == 1">Percent</span>
            <span v-if="scope.row.type == 0">Fixed</span>
          </template>
        </el-table-column>
        <el-table-column
          :label="trans('core.table.created at')"
          prop="created_at"
        >
        </el-table-column>
        <el-table-column :label="trans('core.table.actions')" prop="actions">
          <template slot-scope="scope">
            <el-button
              type="primary"
              icon="el-icon-edit"
              size="small"
              circle
              @click="openForm(scope.row.id)"
            ></el-button>
            <el-button
              v-if="scope.row.level == lastLevel"
              type="danger"
              icon="el-icon-delete"
              size="small"
              circle
              @click="deleteCommission(scope.row.urls.delete_url)"
            ></el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <el-button type="text" @click="openForm(0)">Add Commission</el-button>
    <el-button type="text" @click="openFormQuick()">Quick Create</el-button>
    <CommissionForm
      :commission-id="commissionId"
      :dialog-form-visible="dialogFormVisible"
      :package-id="packageId"
      @closeForm="closeForm"
    ></CommissionForm>
    <CommissionQuick
      :dialog-form-visible="dialogFormQuickVisible"
      :package-id="packageId"
      @closeForm="closeForm"
    ></CommissionQuick>
  </div>
</template>
    <script>
import axios from "axios";
import Form from "form-backend-validation";
import CommissionForm from "./CommissionForm.vue";
import CommissionQuick from "./CommissionQuick.vue";
export default {
  components: {
    CommissionForm,
    CommissionQuick,
  },
  props: {
    locales: {
      default: null,
      type: Object,
    },
    packageId: {
      type: Number,
    },
  },
  data() {
    return {
      dialogFormQuickVisible: false,
      dialogFormVisible: false,
      commissions: [],
      lastLevel: 0,
      commissionId: 0,
      form: new Form(),
      loading: false,
    };
  },
  created() {
    this.fetchCommissions();
  },
  methods: {
    fetchCommissions() {
      this.loading = true;
      axios
        .get(
          route("api.staking.commission.indexServerSide", {
            packageId: this.packageId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.commissions = response.data.commissions;
          this.lastLevel = response.data.commission.level;
        });
    },
    closeForm() {
      this.dialogFormVisible = false;
      this.dialogFormQuickVisible = false;
      this.commissionId = 0;
      this.fetchCommissions();
    },
    openForm(commissionId) {
      if (commissionId != 0) {
        this.commissionId = +commissionId;
      }
      this.dialogFormVisible = true;
    },
    openFormQuick() {
      this.dialogFormQuickVisible = true;
    },
    deleteCommission(delete_url) {
      this.$confirm(
        this.trans("core.modal.confirmation-message"),
        this.trans("core.modal.title"),
        {
          confirmButtonText: "OK",
          cancelButtonText: "Cancel",
          type: "warning",
        }
      )
        .then(() => {
          axios.delete(delete_url).then((response) => {
            this.$message({
              type: "success",
              message: response.data.message,
            });
            this.fetchCommissions();
          });
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "Delete canceled",
          });
        });
    },
  },
};
</script>
    <style>
.box-curency-attr .el-descriptions {
  margin-top: 30px;
  border: 1px solid #ebeef5;
  padding: 5px;
}
</style>