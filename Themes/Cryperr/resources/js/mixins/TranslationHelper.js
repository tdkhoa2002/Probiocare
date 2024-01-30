export default {
    methods: {
        trans(string) {
            const array = string.split('.');

            if (array.length < 2) {
                return this.$t(string);
            }

            const first = array.splice(0, 1),
                key = array.join('.');
            return translations[first][key];
        },
    },
};
