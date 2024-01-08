export default {
    getUniqueArray(arr) {
        return [...new Set(arr)];
    },
    objectToFormData(object, formData = new FormData(), parent = null) {
        for (const property in object) {
            if (object.hasOwnProperty(property)) {
                appendToFormData(formData, getKey(parent, property), object[property]);
            }
        }

        return formData;
    },
    round(value, exp) {
        if (typeof exp === 'undefined' || +exp === 0)
            return Math.round(value);

        value = +value;
        exp = +exp;

        if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
            return NaN;

        // Shift
        value = value.toString().split('e');
        value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

        // Shift back
        value = value.toString().split('e');
        return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
    }
}