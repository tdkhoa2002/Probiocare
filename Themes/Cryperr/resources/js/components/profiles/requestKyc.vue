<template>
  <div class="account-kyc py-4 py-md-5">
    <loading :active.sync="visibleLoading"></loading>
    <div class="px-3 px-md-4">
      <div class="d-flex justify-content-between mb-4">
        <a class="backlink" href="/customer/setting">
          <img
            height="20px"
            class="me-3"
            :src="getPathImg('images/left-outline.png')"
            alt=""
          />
          <div class="label">Primary KYC</div>
        </a>
      </div>
      <div class="form-kyc">
        <div class="col-12">
          <div class="form-item mb-0">
            <label for="country" class="form-label">Nationality</label>
            <div class="input-group">
              <select
                name="country"
                id="nationality"
                v-model="dataRequest.country_id"
              >
                <option
                  v-bind:value="item.id"
                  v-for="(item, index) in countries"
                  :key="index"
                >
                  {{ item.name }}
                </option>
              </select>
              <img
                width="12px"
                height="8px"
                :src="getPathImg('images/down-outline.png')"
                alt=""
              />
            </div>
            <div
              v-if="form.errors.has('country_id')"
              class="form-text error"
              v-text="form.errors.first('country_id')"
            ></div>
          </div>
        </div>
        <div class="col-12">
          <div class="form-item mb-0">
            <label for="Passport" class="form-label">ID Type</label>
            <div class="input-group">
              <select
                name="passport"
                class="input"
                v-model="dataRequest.id_type"
              >
                <option value="passport">Passport</option>
                <option value="idcard">ID Card</option>
              </select>
              <img
                width="12px"
                height="8px"
                :src="getPathImg('images/down-outline.png')"
                alt=""
              />
            </div>
            <div
              v-if="form.errors.has('id_type')"
              class="form-text error"
              v-text="form.errors.first('id_type')"
            ></div>
          </div>
        </div>
        <div class="col-12">
          <div class="form-item mb-0">
            <label for="idNumber" class="form-label">ID Number</label>
            <input
              name="idNumber"
              type="text"
              class="input bg-secondary"
              placeholder="Id number"
              v-model="dataRequest.id_number"
            />
          </div>
          <div
            v-if="form.errors.has('id_number')"
            class="form-text error"
            v-text="form.errors.first('id_number')"
          ></div>
        </div>
        <div class="col-6">
          <div class="form-item mb-0">
            <label for="firstname" class="form-label">Fist Name</label>
            <input
              v-model="dataRequest.firstname"
              name="firstname"
              type="text"
              class="input bg-secondary"
              placeholder="First name"
            />
          </div>
          <div
            v-if="form.errors.has('firstname')"
            class="form-text error"
            v-text="form.errors.first('firstname')"
          ></div>
        </div>
        <div class="col-6">
          <div class="form-item mb-0">
            <label for="lastname" class="form-label">Last Name</label>
            <input
              name="lastname"
              v-model="dataRequest.lastname"
              type="text"
              class="input bg-secondary"
              placeholder="Last name"
            />
          </div>
          <div
            v-if="form.errors.has('firstname')"
            class="form-text error"
            v-text="form.errors.first('firstname')"
          ></div>
        </div>
        <div class="col-12">
          <div class="form-item mb-0">
            <label for="birtdate" class="form-label">Date of Birth</label>
            <input
              type="date"
              v-model="dataRequest.birthday"
              class="date input bg-secondary"
              name="date"
              value=""
              placeholder="Please enter your date of birth"
            />
          </div>
          <div
            v-if="form.errors.has('birthday')"
            class="form-text error"
            v-text="form.errors.first('birthday')"
          ></div>
        </div>

        <div class="col-12">
          <div class="form-passport mb-4">
            <div class="fs-5 mb-2">Passport Photo</div>
            <ul class="fw-light mb-3">
              <li>
                Please make sure the content of the photo is complete and
                clearly visible
              </li>
              <li>
                Only supports
                <span class="fw-medium">JPG, JPEF, PNG,</span> image formats
              </li>
              <li>
                Image size cannot exceed <span class="fw-medium">5MB</span>
              </li>
            </ul>
            <div class="row">
              <div class="col-md-6">
                <div class="box-upload-file pointer mb-3">
                  <img
                    class="icon-upload mb-3 opacity-10"
                    :src="
                      pathFileFront == ''
                        ? getPathImg(fileChoose)
                        : pathFileFront
                    "
                    alt=""
                  />
                  <div class="fw-light">
                    <span class="text-primary">Click me</span> to upload files !
                  </div>
                  <input type="file" ref="front_image" @change="changeFile" />
                </div>
                <div
                  v-if="form.errors.has('front_image')"
                  class="form-text error"
                  v-text="form.errors.first('front_image')"
                ></div>
              </div>
              <div class="col-md-6">
                <div class="box-upload-file pointer mb-3">
                  <img
                    class="icon-upload mb-3 opacity-10"
                    :src="
                      pathFileBack == '' ? getPathImg(fileChoose) : pathFileBack
                    "
                    alt=""
                  />
                  <div class="fw-light">
                    <span class="text-primary">Click me</span> to upload files !
                  </div>
                  <input type="file" ref="back_image" @change="changeFile" />
                </div>
                <div
                  v-if="form.errors.has('back_image')"
                  class="form-text error"
                  v-text="form.errors.first('back_image')"
                ></div>
              </div>
            </div>
          </div>
          <div class="form-portait mb-4">
            <div class="fs-5 mb-2">Portrait Photo</div>
            <ul class="fw-light mb-3">
              <li>
                Please make sure the content of the photo is complete and
                clearly visible
              </li>
              <li>
                Only supports
                <span class="fw-medium">JPG, JPEF, PNG,</span> image formats
              </li>
              <li>
                Image size cannot exceed <span class="fw-medium">5MB</span>
              </li>
            </ul>

            <div class="row g-3 g-md-4">
              <div class="col-12 col-md-6">
                <div class="box-upload-file pointer">
                  <img
                    class="icon-upload mb-3 opacity-10"
                    :src="
                      pathFileSelfi == ''
                        ? getPathImg(fileChoose)
                        : pathFileSelfi
                    "
                    alt=""
                  />
                  <div class="fw-light">
                    <span class="text-primary">Click me</span> to upload files !
                  </div>
                  <input type="file" ref="selfi_image" @change="changeFile" />
                </div>
                <div
                  v-if="form.errors.has('selfi_image')"
                  class="form-text error"
                  v-text="form.errors.first('selfi_image')"
                ></div>
              </div>
              <div class="col-12 col-md-6">
                <div class="box-upload-file pointer">
                  <img
                    class="icon-upload mb-3"
                    :src="getPathImg('images/icons/portrait-upload.png')"
                    alt=""
                  />
                  <div class="fw-light">Example Photo</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="form-action">
            <div class="text-center">
              <button class="btn btn-primary" @click="submitKyc()">
                Submit
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
    
  <script>
import _ from "lodash";
import Axios from "axios";
import GetPathImg from "../../mixins/GetPathImg";
import Form from "form-backend-validation";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  components: {
    Loading,
  },
  mixins: [GetPathImg],
  created() {
    this.getCurrentKyc();
    this.getListCountry();
  },
  data() {
    return {
      visibleLoading: false,
      fileChoose: "images/icons/upload.png",
      pathFileFront: "",
      pathFileBack: "",
      pathFileSelfi: "",
      countries: [],
      form: new Form(),
      dataRequest: {
        back_image: "",
        front_image: "",
        selfi_image: "",
        country_id: "",
        birthday: "",
        id_type: "",
        id_number: "",
        firstname: "",
        lastname: "",
      },
    };
  },
  methods: {
    changeFile(e) {
      let back_image = this.$refs.back_image;
      let front_image = this.$refs.front_image;
      let selfi_image = this.$refs.selfi_image;
      if (front_image.files && front_image.files.length > 0) {
        this.dataRequest.front_image = front_image.files[0];
        const theReader = new FileReader();
        theReader.onloadend = async () => {
          this.pathFileFront = await theReader.result;
        };
        theReader.readAsDataURL(front_image.files[0]);
      }
      if (back_image.files && back_image.files.length > 0) {
        this.dataRequest.back_image = back_image.files[0];
        const theReader = new FileReader();
        theReader.onloadend = async () => {
          this.pathFileBack = await theReader.result;
        };
        theReader.readAsDataURL(back_image.files[0]);
      }
      if (selfi_image.files && selfi_image.files.length > 0) {
        this.dataRequest.selfi_image = selfi_image.files[0];
        const theReader = new FileReader();
        theReader.onloadend = async () => {
          this.pathFileSelfi = await theReader.result;
        };
        theReader.readAsDataURL(selfi_image.files[0]);
      }
    },
    submitKyc() {
      this.visibleLoading = true;
      this.form = new Form(this.dataRequest);
      this.form
        .post(this.getRoute())
        .then((response) => {
          this.visibleLoading = false;
          if (response.error == true) {
            this.$bvToast.toast(response.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
          } else {
            this.$bvToast.toast(response.data.message, {
              variant: "success",
              solid: true,
              noCloseButton: true,
            });
            window.location.href = response.data.url;
          }
        })
        .catch((error) => {
          this.visibleLoading = false;
          console.log(error);
        });
    },
    getListCountry() {
      Axios.get("/list-country")
        .then((response) => {
          if (response.data.error === false) {
            this.countries = response.data.data;
          } else {
            this.$bvToast.toast(response.data.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getCurrentKyc() {
      Axios.get("/customer/getCurrentKyc")
        .then((response) => {
          if (response.data.error === false) {
            const kyc = response.data.data.kyc;
            if (kyc != null) {
              this.dataRequest = response.data.data.kyc;
              this.pathFileFront = response.data.data.kyc.pathFileFront;
              this.pathFileBack = response.data.data.kyc.pathFileBack;
              this.pathFileSelfi = response.data.data.kyc.pathFileSelfi;
            }
          } else {
            this.$bvToast.toast(response.data.message, {
              variant: "danger",
              solid: true,
              noCloseButton: true,
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getRoute() {
      if (this.dataRequest.id !== undefined) {
        return "/customer/updateKyc";
      } else {
        return "/customer/requestKyc";
      }
    },
  },
};
</script>