export default {
  methods: {
    getPathImg(path) {
      const url = window.location.origin
      return url + '/themes/cryperr/' + path;
    },
    getValueInArray(dataArr, id) {
      const data = _.find(dataArr, { payment_attr_id: id });
      if (data) {
        return data.value;
      } else {
        return "";
      }
    },
    onlyNumber($event) {
      let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
        $event.preventDefault();
      }
    }
  },
};
