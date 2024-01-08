<template>
  <div>
    <div class="box-curency-attr">
      <el-table :data="packageTerms" style="width: 100%">
        <el-table-column prop="id" label="Id" width="75" sortable="custom">
        </el-table-column>
        <el-table-column prop="title" :label="trans('packages.table.title')">
        </el-table-column>
        <el-table-column prop="type" :label="trans('packages.table.type')">
        </el-table-column>
        <el-table-column
          prop="apr_reward"
          :label="trans('packages.table.apr_reward')"
        >
        </el-table-column>
        <el-table-column
          prop="day_reward"
          :label="trans('packages.table.day_reward')"
        >
        </el-table-column>
        <el-table-column
          prop="total_stake"
          :label="trans('packages.table.total_stake')"
        >
        </el-table-column>
        <el-table-column
          :label="trans('core.table.created at')"
          prop="created_at"
          sortable="custom"
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
            type="danger"
            icon="el-icon-delete"
            size="small"
            circle
            @click="deletePackageTerm(scope.row.urls.delete_url)"
          ></el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <el-button type="text" @click="openForm(0)">Add package term</el-button>
    <PackageTermForm
      :package-term-id="packageTermId"
      :dialog-form-visible="dialogFormVisible"
      :package-id="packageId"
      :locales="locales"
      @closeForm="closeForm"
    ></PackageTermForm>
  </div>
</template>
  <script>
import axios from "axios";
import Form from "form-backend-validation";
import PackageTermForm from "./PackageTermForm";
export default {
  components: {
    PackageTermForm,
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
      dialogFormVisible: false,
      packageTerms: [],
      packageTermId: 0,
      form: new Form(),
      loading: false,
    };
  },
  created() {
    this.fetchPackageTerms();
  },
  methods: {
    fetchPackageTerms() {
      this.loading = true;
      axios
        .get(
          route("api.staking.packageterm.indexServerSide", {
            packageId: this.packageId,
          })
        )
        .then((response) => {
          this.loading = false;
          this.packageTerms = response.data.data;
        });
    },
    closeForm() {
      this.dialogFormVisible = false;
      this.packageTermId = 0;
      this.fetchPackageTerms();
    },
    openForm(packageTermId) {
      if (packageTermId != 0) {
        this.packageTermId = +packageTermId;
      }
      this.dialogFormVisible = true;
    },
    deletePackageTerm(delete_url) {
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
              this.fetchPackageTerms();
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