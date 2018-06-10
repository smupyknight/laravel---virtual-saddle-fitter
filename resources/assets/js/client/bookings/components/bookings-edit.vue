<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Edit a Booking #: {{ data.id }}</h5>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <form class="form-horizontal">

                <!-- select fitter -->
                <div class="form-group" :class="{'has-error': errors.has('fitter_id')}">
                    <label class="col-md-2 control-label" for="fitter_id">Fitter</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.fitter_id" id="fitter_id">
                            <option selected disabled value="">Select Fitter</option>
                            <option v-for="fitter in fitters"
                                    :value="fitter.id">{{ fitter.name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('fitter_id') }}</strong></span>
                    </div>
                </div>
                <!-- select fitter end -->

                <!-- select rider -->
                <div class="form-group" :class="{'has-error': errors.has('rider_id')}">
                    <label class="col-md-2 control-label" for="rider_id">Rider</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.rider_id" id="rider_id">
                            <option selected disabled value="">Select Rider</option>
                            <option v-for="rider in riders"
                                    :value="rider.id">{{ rider.first_name + ' ' + rider.last_name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('rider_id') }}</strong></span>
                    </div>
                </div>
                <!-- select rider end -->

                <!-- select horse -->
                <div class="form-group" :class="{'has-error': errors.has('horse_id')}">
                    <label class="col-md-2 control-label" for="horse_id">Horse</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.horse_id" id="horse_id"
                                @change="onHorseChange(data.horse_id)">
                            <option selected disabled value="">Select Horse</option>
                            <option v-for="horse in horses"
                                    :value="horse.id">{{ horse.stable_name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('horse_id') }}</strong></span>
                    </div>
                </div>
                <!-- select horse end -->

                <!-- input date -->
                <div class="form-group" :class="{'has-error': errors.has('date')}">
                    <label class="col-md-2 control-label" for="date">Date</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.date" id="date">
                        <span class="help-block is-danger"><strong>{{ errors.get('date') }}</strong></span>
                    </div>
                </div>
                <!-- input date end -->

                <!-- select saddle -->
                <div class="form-group" :class="{'has-error': errors.has('saddle_id')}">
                    <label class="col-md-2 control-label" for="saddle_id">Saddle</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.saddle_id" id="saddle_id">
                            <option selected value="">-</option>
                            <option v-for="saddle in saddles"
                                    :value="saddle.id">{{ saddle.name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('saddle_id') }}</strong></span>
                    </div>
                </div>
                <!-- select saddle end -->

                <!-- input address -->
                <div class="form-group" :class="{'has-error': errors.has('address')}">
                    <label class="col-md-2 control-label" for="address">Address</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.address" id="address">
                        <span class="help-block is-danger"><strong>{{ errors.get('address') }}</strong></span>
                    </div>
                </div>
                <!-- input address end -->

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-w-m btn-primary" @click.prevent="putUpdate()">Save
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
            bookingsResourceUrl: '',
            myFittersResourceUrl: '',
            horsesResourceUrl: '',
            ridersResourceUrl: '',
        },
        data() {
            return {
                fitters: [],
                horses: [],
                riders: [],
                saddles: [],

                data: {
                    id: '',
                    fitter_id: '',
                    horse_id: '',
                    rider_id: '',
                    date: '',
                    saddle_id: '',
                    address: '',
                },
            }
        },
        methods: {
            putUpdate() {
                this.myAxios.put(this.bookingsResourceUrl + '/' + this.$route.params.id, this.data)
                    .then((response) => {
                        this.showElementNotify('Booking Updated', 'Booking information has Updated.');
                        this.$router.push({ name: 'bookings-view', params: { id: response.data.id } });
                    })
                    .catch((error) => {
                        console.log(error);
                        this.errors.put(error.response.data);
                        this.showErrorNotify(error);
                    });
            },
            getData() {
                // Get booking details
                this.myAxios.get(this.bookingsResourceUrl + '/' + this.$route.params.id)
                    .then((res) => {
                        this.data = res.data;
                        this.data.fitter_id = res.data.fitter.id;
                        this.data.horse_id = res.data.horse.id;
                        this.data.rider_id = res.data.rider.id;
                        this.data.date = res.data.date;
                        this.data.saddle_id = res.data.saddle.id;
                        this.data.address = res.data.address;

                        this.getHorseDetails(this.data.horse_id);
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
                // Get list of fitters
                this.myAxios.get(this.myFittersResourceUrl, {
                        params: {
                            per_page: Number.MAX_SAFE_INTEGER,
                            related: 'true',
                        }
                    })
                    .then((res) => {
                        this.fitters = res.data.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });

                // Get list of Horses
                this.myAxios.get(this.horsesResourceUrl, {
                        params: {
                            per_page: Number.MAX_SAFE_INTEGER,
                        }
                    })
                    .then((res) => {
                        this.horses = res.data.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });

                // Get list of Riders
                this.myAxios.get(this.ridersResourceUrl, {
                        params: {
                            per_page: Number.MAX_SAFE_INTEGER,
                        }
                    })
                    .then((res) => {
                        this.riders = res.data.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
            },
            onHorseChange(horse_id) {
                this.getHorseDetails(horse_id);
                this.data.saddle_id = '';
            },
            getHorseDetails(horse_id) {
                this.myAxios.get(this.horsesResourceUrl + '/' + horse_id)
                    .then((res) => {
                        this.saddles = res.data.saddles;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
            },
        },
        mounted() {
            this.getData();

            $('#date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: true,
                locale: {
                    format: 'DD/MM/YYYY'
                },
            }, (date) => {
                this.data.date = date.format('DD/MM/YYYY');
            });
        },
    }
</script>

<style lang="scss">

</style>