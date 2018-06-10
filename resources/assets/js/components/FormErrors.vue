<script>
    class Errors {
        constructor() {
            this.errors = {};
        }

        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }

        put(errors) {
            this.errors = errors;
        }

        clear(field) {
            if (this.errors[field]) {
                delete this.errors[field];
            }
        }

        has(field) {
            return this.errors.hasOwnProperty(field);
        }

        clearAll() {
            this.errors = {};
        }
    }

    export default {
        data() {
            return {
                states: [
                    "ACT",
                    "QLD",
                    "NSW",
                    "NT",
                    "SA",
                    "WA",
                    "TAS",
                    "VIC",
                ],
                colors: [
                    'bay',
                    'dark bay',
                    'blood bay',
                    'brown bay',
                    'Chestnut',
                    'liver chestnut',
                    'sorrel chestnut',
                    'blond or light chestnut',
                    'Grey',
                    'steel grey',
                    'dapple grey',
                    'fleabitten grey',
                    'rose grey',
                    'black',
                    'brindle',
                    'buckskin',
                    'champagne',
                    'cream dilution',
                    'cremello',
                    'dun',
                    'blue dun (grullo, grulla)',
                    'red dun',
                    'bay dun',
                    'buckskin dun',
                    'leopard',
                    'palomino',
                    'pinto',
                    'piepald',
                    'skewbald',
                    'overo',
                    'sabino',
                    'tobiano',
                    'tovero',
                    'rabicano',
                    'roan',
                    'red roan',
                    'bay roan',
                    'blue roan',
                    'dapple',
                    'black',
                    'cream',
                    'whiteblood bay',
                    'brown bay',
                    'chestnut',
                    'liver chestnut',
                    'sorrel chestnut',
                    'blond or light chestnut',
                    'Grey',
                    'steel grey',
                    'dapple grey',
                    'fleabitten grey',
                    'rose grey',
                    'black',
                    'brindle',
                    'buckskin',
                    'champagne',
                    'cream dilution',
                    'cremello',
                    'dun',
                    'blue dun (grullo, grulla)',
                    'red dun',
                    'bay dun',
                    'buckskin dun',
                    'leopard',
                    'palomino',
                    'pinto',
                    'piepald',
                    'skewbald',
                    'overo',
                    'sabino',
                    'tobiano',
                    'tovero',
                    'rabicano',
                    'roan',
                    'red roan',
                    'bay roan',
                    'blue roan',
                    'dapple',
                    'black',
                    'cream',
                    'white',
                ],
                sexes: [
                    'Stallion',
                    'Mare',
                    'Gelding',
                ],
                errors: new Errors()
            }
        },
        filters: {
            capitalize(val) {
                if (!val) return '';
                val = val.toString();
                return val.charAt(0).toUpperCase() + val.slice(1);
            }
        },
        methods: {
            showErrorNotify(error) {
                let msg = '';
                _.forEach(error.response.data, (val, key) => {
                    msg += val + '\n';
                });

                this.showElementNotify('Edit Error', msg, 'error');
            },
            showElementNotify(title, msg, type = 'success') {
                this.$notify({
                    title: title,
                    message: msg,
                    type: type,
                });
            }
        }
    }
</script>

<style lang="scss">
    .el-notification__content {
        word-wrap: break-word;
        white-space: pre-wrap;
    }
</style>