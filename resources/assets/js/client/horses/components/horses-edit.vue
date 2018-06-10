<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Edit Horse: {{ data.stable_name }}</h5>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <form class="form-horizontal">

                <div class="form-group" :class="{'has-error': errors.has('stable_name')}">
                    <label class="col-md-2 control-label" for="stable_name">Stable Name</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.stable_name" id="stable_name">
                        <span class="help-block is-danger"><strong>{{ errors.get('stable_name') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('breeding_name')}">
                    <label class="col-md-2 control-label" for="breeding_name">Breeding Name</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.breeding_name" id="breeding_name">
                        <span class="help-block is-danger"><strong>{{ errors.get('breeding_name') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('paddock_address')}">
                    <label class="col-md-2 control-label" for="paddock_address">Paddock Address</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.paddock_address" id="paddock_address">
                        <span class="help-block is-danger"><strong>{{ errors.get('paddock_address') }}</strong></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('postcode')}">
                            <label class="col-md-4 control-label" for="postcode">Post Code</label>
                            <div class="col-md-8">
                                <input class="form-control" v-model="data.postcode" id="postcode">
                                <span class="help-block is-danger"><strong>{{ errors.get('postcode') }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('suburb')}">
                            <label class="col-md-4 control-label" for="suburb">Suburb</label>
                            <div class="col-md-8">
                                <input class="form-control" v-model="data.suburb" id="suburb">
                                <span class="help-block is-danger"><strong>{{ errors.get('suburb') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('state')}">
                    <label class="col-md-2 control-label" for="state">State</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.state" id="state">
                            <option selected disabled value="">Select State</option>
                            <option v-for="state in states"
                                    :value="state">{{ state }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('state') }}</strong></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('breed')}">
                            <label class="col-md-4 control-label" for="breed">Breed</label>
                            <div class="col-md-8">
                                <select class="form-control" v-model="data.breed" id="breed">
                                    <option selected disabled value="">Select Breed</option>
                                    <option v-for="breed in breeds"
                                            :value="breed.name">{{ breed.name }}
                                    </option>
                                </select>
                                <span class="help-block is-danger"><strong>{{ errors.get('breed') }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('colour')}">
                            <label class="col-md-4 control-label" for="colour">Colour</label>
                            <div class="col-md-8">
                                <select class="form-control" v-model="data.colour" id="colour">
                                    <option selected disabled value="">Select Colour</option>
                                    <option v-for="colour in colors"
                                            :value="colour">{{ colour }}
                                    </option>
                                </select>
                                <span class="help-block is-danger"><strong>{{ errors.get('colour') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('height')}">
                            <label class="col-md-4 control-label" for="height">Height</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" v-model="data.height" id="height">
                                <span class="help-block is-danger"><strong>{{ errors.get('height') }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('weight')}">
                            <label class="col-md-4 control-label" for="weight">Weight</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" v-model="data.weight" id="weight">
                                <span class="help-block is-danger"><strong>{{ errors.get('weight') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('girth')}">
                            <label class="col-md-4 control-label" for="girth">Girth</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" v-model="data.girth" id="girth">
                                <span class="help-block is-danger"><strong>{{ errors.get('girth') }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('age')}">
                            <label class="col-md-4 control-label" for="age">Age</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" v-model="data.age" id="age">
                                <span class="help-block is-danger"><strong>{{ errors.get('age') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('dob')}">
                            <label class="col-md-4 control-label" for="dob">Date of Birth</label>
                            <div class="col-md-8">
                                <input class="form-control" v-model="data.dob" id="dob">
                                <span class="help-block is-danger"><strong>{{ errors.get('dob') }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('discipline')}">
                            <label class="col-md-4 control-label" for="discipline">Discipline</label>
                            <div class="col-md-8">
                                <select class="form-control" v-model="data.discipline" id="discipline">
                                    <option selected disabled value="">Select Discipline</option>
                                    <option v-for="discipline in disciplines"
                                            :value="discipline">{{ discipline }}
                                    </option>
                                </select>
                                <span class="help-block is-danger"><strong>{{ errors.get('discipline')
                                    }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('sex')}">
                            <label class="col-md-4 control-label" for="sex">Sex</label>
                            <div class="col-md-8">
                                <select class="form-control" v-model="data.sex" id="sex">
                                    <option selected disabled value="">Select Sex</option>
                                    <option v-for="sex in sexes"
                                            :value="sex">{{ sex }}
                                    </option>
                                </select>
                                <span class="help-block is-danger"><strong>{{ errors.get('sex') }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('microchip_number')}">
                            <label class="col-md-4 control-label" for="microchip_number">Microchip Number</label>
                            <div class="col-md-8">
                                <input class="form-control" v-model="data.microchip_number" id="microchip_number">
                                <span class="help-block is-danger"><strong>{{ errors.get('microchip_number') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-w-m btn-primary" @click.prevent="postPut()">Save
                        </button>
                        <a href="javascript:history.back()" class="btn btn-w-m btn-default">Cancel</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
    export default {
        mixins: [FormErrors, MyAxios],
        props: {
            resourceUrl: '',
            disciplinesResourceUrl: '',
            breedsResourceUrl: '',
        },
        data() {
            return {
                breeds: [],
                disciplines: [],
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
                data: {
                    'stable_name': '',
                    'breeding_name': '',
                    'paddock_address': '',
                    'postcode': '',
                    'state': '',
                    'suburb': '',
                    'breed': '',
                    'height': '',
                    'weight': '',
                    'girth': '',
                    'colour': '',
                    'age': '',
                    'dob': '',
                    'discipline': '',
                    'sex': '',
                    'photo': '',
                    'microchip_number': '',
                },
            }
        },
        methods: {
            getData() {
                this.myAxios.get(this.resourceUrl + '/' + this.$route.params.id)
                    .then((res) => {
                        this.data = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });

                this.myAxios.get(this.disciplinesResourceUrl)
                    .then((res) => {
                        this.disciplines = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });

                this.myAxios.get(this.breedsResourceUrl)
                    .then((res) => {
                        this.breeds = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });

            },
            postPut() {
                this.myAxios.put(this.resourceUrl + '/' + this.$route.params.id, this.data)
                    .then((response) => {
                        this.showElementNotify('Horse Updated', 'Horse has updated successfully.');
                        this.$router.push({ name: 'horses-view', params: { id: response.data.id } });
                    })
                    .catch((error) => {
                        console.log(error);
                        this.errors.put(error.response.data);
                        this.showErrorNotify(error);
                    });
            },
        },
        mounted() {
            this.getData();

            $('#dob').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: true,
                locale: {
                    format: 'DD/MM/YYYY'
                },
            }, (date) => {
                this.data.dob = date.format('DD/MM/YYYY');
            });
        },
    }
</script>

<style lang="scss">

</style>