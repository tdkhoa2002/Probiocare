<template>
  <div class="d-flex mb-3 mt-3 box-code-verify">
    <template v-for="(v, index) in values">
      <input
        :type="type === 'number' ? 'tel' : type"
        :pattern="type === 'number' ? '[0-9]' : null"
        :autoFocus="autoFocus && index === autoFocusIndex"
        :key="`${id}-${index}`"
        :data-id="index"
        :value="v"
        v-model="values[index]"
        :ref="iRefs[index]"
        v-on:input="onValueChange"
        v-on:focus="onFocus"
        v-on:keydown="onKeyDown"
        :disabled="disabled"
        :required="required"
        @paste="onPaste"
        maxlength="1"
      />
    </template>
  </div>
</template>
<script>
const KEY_CODE = {
  backspace: 8,
  left: 37,
  up: 38,
  right: 39,
  down: 40,
  paste: 86,
};
import _ from "lodash";
export default {
  props: {
    type: {
      type: String,
      default: "number",
    },
    className: String,
    fields: {
      type: Number,
      default: 6,
    },
    autoFocus: {
      type: Boolean,
      default: true,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    required: {
      type: Boolean,
      default: false,
    },
    title: String,
    change: Function,
    complete: Function,
  },
  data() {
    const { fields, values } = this;
    let vals;
    let autoFocusIndex = 0;
    if (values && values.length) {
      vals = [];
      for (let i = 0; i < fields; i++) {
        vals.push(values[i] || "");
      }
      autoFocusIndex = values.length >= fields ? 0 : values.length;
    } else {
      vals = Array(fields).fill("");
    }
    this.iRefs = [];
    for (let i = 0; i < fields; i++) {
      this.iRefs.push(`input_${i}`);
    }
    this.id = +new Date();
    return { values: vals, autoFocusIndex };
  },
  methods: {
    onPaste(evt) {
      let dataPaste = evt.clipboardData.getData("text");
      dataPaste = parseInt(dataPaste);
      let values = [];
      if (!isNaN(dataPaste)) {
        values = Array.from(String(dataPaste), Number);
        if (values.length < this.fields) {
          for (let i = values.length; i < this.fields; i++) {
            values.push("");
          }
        }
      } else {
        for (let i = 1; i <= this.fields; i++) {
          values.push("");
        }
      }
      this.values = values;
      this.triggerChange();
    },
    onFocus(e) {
      e.target.select(e);
    },
    onValueChange(e) {
      const index = parseInt(e.target.dataset.id);
      const { type, fields } = this;
      if (type === "number") {
        e.target.value = e.target.value.replace(/[^\d]/gi, "");
      }
      if (
        e.target.value === "" ||
        (type === "number" && !e.target.validity.valid)
      ) {
        this.resetData();
        return;
      }
      let next;
      const value = e.target.value;
      let { values } = this;
      values = Object.assign([], values);
      if (value.length > 1) {
        let nextIndex = value.length + index - 1;
        if (nextIndex >= fields) {
          nextIndex = fields - 1;
        }

        next = this.iRefs[nextIndex];
        const split = value.split("");
        split.forEach((item, i) => {
          const cursor = index + i;
          if (cursor < fields) {
            values[cursor] = item;
          }
        });
        this.values = values;
      } else {
        next = this.iRefs[index + 1];
        values[index] = value;
        this.values = values;
      }

      if (next) {
        const element = this.$refs[next][0];
        element.focus();
        element.select();
      }

      this.triggerChange(values);
    },
    resetData() {
      let values = [];
      for (let i = 1; i <= this.fields; i++) {
        values.push("");
      }
      this.values = values;
    },
    onKeyDown(e) {
      const index = parseInt(e.target.dataset.id);
      const prevIndex = index - 1;
      const nextIndex = index + 1;
      const prev = this.iRefs[prevIndex];
      const next = this.iRefs[nextIndex];
      switch (e.keyCode) {
        case KEY_CODE.backspace: {
          e.preventDefault();
          const vals = [...this.values];
          if (this.values[index]) {
            vals[index] = "";
            this.values = vals;
            this.triggerChange(vals);
          } else if (prev) {
            vals[prevIndex] = "";
            this.$refs[prev][0].focus();
            this.values = vals;
            this.triggerChange(vals);
          }
          break;
        }
        case KEY_CODE.left:
          e.preventDefault();
          if (prev) {
            this.$refs[prev][0].focus();
          }
          break;
        case KEY_CODE.right:
          e.preventDefault();
          if (next) {
            this.$refs[next][0].focus();
          }
          break;
        case KEY_CODE.up:
          e.preventDefault();
        case KEY_CODE.down:
          e.preventDefault();
          break;
        default:
          // this.handleKeys[index] = true;
          break;
      }
    },
    triggerChange(values = this.values) {
      const { fields } = this;
      const val = values.join("");
      this.$emit("change", val);
      if (val.length >= fields) {
        this.$emit("complete", val);
      }
    },
  },
};
</script>
<style scoped>
.box-code-verify {
  text-align: center;
  justify-content: center;
}
.box-code-verify input {
  margin: 0 5px;
  padding: 5px;
  text-align: center;
  width: 45px;
  height: 45px;
}
@media (min-width: 520px) {
  .box-code-verify input {
    margin: 0 10px;
    padding: 5px;
    text-align: center;
    width: 50px;
    height: 50px;
    font-size: 20px;
  }
}
@media (min-width: 992px) {
  .box-code-verify input {
    width: 60px;
    height: 50px;
    font-size: 24px;
  }
}
@media (min-width: 1200px) {
  .box-code-verify input {
    width: 60px;
    height: 60px;
    font-size: 28px;
  }
}
</style>