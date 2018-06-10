<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Edit Booking: #{{ data.id }}</h5>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <form class="form-horizontal">

                <!-- select client -->
                <div class="form-group" :class="{'has-error': errors.has('client_id')}">
                    <label class="col-md-2 control-label" for="client_id">Client</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.client_id" id="client_id"
                                @change="onSelectClient(data.client_id)">
                            <option selected disabled value="">Select Client</option>
                            <option v-for="client in clients"
                                    :value="client.id">{{ client.name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('client_id') }}</strong></span>
                    </div>
                </div>
                <!-- select client end -->

                <!-- select horse -->
                <div class="form-group" :class="{'has-error': errors.has('horse_id')}">
                    <label class="col-md-2 control-label" for="horse_id">Horse</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.horse_id" id="horse_id"
                                @change="onHorseChange(data.horse_id)">
                            <option selected disabled value="">Select Horse</option>
                            <option v-for="horse in client.horses"
                                    :value="horse.id">{{ horse.stable_name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('horse_id') }}</strong></span>
                    </div>
                </div>
                <!-- select horse end -->
                <!-- select rider -->
                <div class="form-group" :class="{'has-error': errors.has('rider_id')}">
                    <label class="col-md-2 control-label" for="rider_id">Rider</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.rider_id" id="rider_id">
                            <option selected disabled value="">Select Rider</option>
                            <option v-for="rider in client.riders"
                                    :value="rider.id">{{ rider.first_name + ' ' + rider.last_name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('rider_id') }}</strong></span>
                    </div>
                </div>
                <!-- select rider end -->
                <!-- select fitter-user -->
                <div class="form-group" :class="{'has-error': errors.has('user_id')}">
                    <label class="col-md-2 control-label" for="user_id">Fitter User</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.user_id" id="user_id">
                            <option selected disabled value="">Select Fitter User</option>
                            <option v-for="user in fitterUsers"
                                    :value="user.id">{{ user.first_name + ' ' + user.last_name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('user_id') }}</strong></span>
                    </div>
                </div>
                <!-- select fitter-user end -->

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
            bookingsResourceUrl: '',
            clientsResourceUrl: '',
            fittersResourceUrl: '',
            horsesResourceUrl: '',
        },
        data() {
            return {
                clients: [],
                fitterUsers: [],
                saddles: [],
                client: {
                    horses: [],
                    riders: [],
                },
                data: {
                    client_id: '',
                    horse_id: '',
                    rider_id: '',
                    user_id: '',
                    saddle_id: '',
                    date: '',
                    address: '',
                },
            }
        },
        methods: {
            postPut() {
                this.myAxios.put(this.bookingsResourceUrl + '/' + this.$route.params.id, this.data)
                    .then((response) => {
                        this.showElementNotify('Booking Updated', 'Booking has updated.');
                        this.$router.push({ name: 'bookings-view', params: { id: this.$route.params.id } });
                    })
                    .catch((error) => {
                        console.log(error);
                        this.errors.put(error.response.data);
                        this.showErrorNotify(error);
                    });
            },
            // First get all clients list
            getClients() {
                this.myAxios.get(this.clientsResourceUrl, {
                        params: {
                            per_page: Number.MAX_SAFE_INTEGER,
                        }
                    })
                    .then((res) => {
                        this.clients = res.data.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
            },
            // Get all Fitter users next
            getFitterUsers() {
                this.myAxios.get(this.fittersResourceUrl + '/my-users-all')
                    .then((res) => {
                        this.fitterUsers = res.data.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
            },
            // Then get current booking
            getBooking() {
                this.myAxios.get(this.bookingsResourceUrl + '/' + this.$route.params.id)
                    .then((response) => {
                        this.data.client_id = response.data.client.id;
                        this.data.horse_id = response.data.horse.id;
                        this.data.rider_id = response.data.rider.id;
                        this.data.user_id = response.data.user.id;
                        this.data.date = response.data.date;
                        this.data.saddle_id = response.data.saddle.id;
                        this.data.address = response.data.address;

                        this.getClientDetails(this.data.client_id);
                        this.getHorseDetails(this.data.horse_id);
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
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
            // Get Client details based on current value
            getClientDetails(client_id) {
                this.myAxios.get(this.clientsResourceUrl + '/' + client_id)
                    .then((res) => {
                        this.client = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
            },
            onSelectClient(client_id) {
                this.getClientDetails(client_id);
            },
        },
        mounted() {
            this.getClients();
            this.getFitterUsers();
            this.getBooking();

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