<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Create a New Fit Check</h5>
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

                <!-- select horse -->
                <div class="form-group" :class="{'has-error': errors.has('horse_id')}">
                    <label class="col-md-2 control-label" for="horse_id">Horse</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.horse_id" id="horse_id">
                            <option selected disabled value="">Select Horse</option>
                            <option v-for="horse in client.horses"
                                    :value="horse.id">{{ horse.stable_name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('horse_id') }}</strong></span>
                    </div>
                </div>
                <!-- select horse end -->

                <!-- select saddle -->
                <div class="form-group" :class="{'has-error': errors.has('saddle_id')}">
                    <label class="col-md-2 control-label" for="saddle_id">Saddle</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.saddle_id" id="saddle_id">
                            <option selected value="">Create a Saddle</option>
                            <option v-for="saddle in client.saddles"
                                    :value="saddle.id">{{ saddle.brand_name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('saddle_id') }}</strong></span>
                    </div>
                </div>
                <!-- select saddle end -->

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-w-m btn-primary" @click.prevent="postCreate()">Create
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
            fitchecksResourceUrl: '',
            clientsResourceUrl: '',
        },
        data() {
            return {
                clients: [],
                client: {
                    horses: [],
                    riders: [],
                    saddles: [],
                },
                data: {
                    client_id: '',
                    rider_id: '',
                    horse_id: '',
                    saddle_id: '',

                    'back_length': '',
                    'wither_template': '',
                    'wither_shape': '',
                    'back_type': '',
                    'shoulder': [],
                    'abdomen': 'Dropped',
                    'fat_cover': 3,
                    'muscling': 3,

                    'back_angle': '',
                    'point_of_hip_tuber_coxae': '',
                    'girth_position': 'Forward',

                    'muscle_wastage': [],
                    'soreness': [],
                    'reduced_flexibility': [],
                    'hair_changes': [],
                    'palation_findings': [],

                    'foot_problems': [],
                    'feet_length': '',
                    'heel_balance': '',
                    'foot_balance': '',
                    'shoeing_status': 'All 4 feet shod',

                    'movement_when_saddled': [],
                    'movement_when_saddled_no_rider': [],
                    'movement_when_ridden': [],

                    'saddle_balance': 'Horizontal seat',
                    'pommel_clearance': 'Mounted',
                    'saddle_length': 'Short',
                    'tree_match_at_wither': 'Parallel to wither',
                    'tree_match_at_arc_of_spine': 'Bridging',
                    'channel_depth': 'Shallow',
                    'channel_width': 'Wide',
                    'saddle_tilt': false,
                    'saddle_twist': false,
                    'contours_of_panel': 'Matched to central',
                    'girth_point_angle': 'Straight',
                    'girth_point_position': 'Point strap and 1',
                    'girth_type': 'Shaped',
                    'girth_size': 0,

                    'drops_to': '',
                    'sits_off_centre': '',
                    'sits_upright': false,

                    'flocking_front': false,
                    'flocking_middle': false,
                    'flocking_back': false,
                    'alterations': [],
                    'history_of_alterations': [],
                    'recommended_products': [],
                },
            }
        },
        methods: {
            postCreate() {
                this.myAxios.post(this.fitchecksResourceUrl, this.data)
                    .then((response) => {
                        this.showElementNotify('FitCheck Started', 'Please enter values.');
                        this.$router.push({ name: 'fitchecks-edit', params: { id: response.data.id } });
                    })
                    .catch((error) => {
                        console.log(error);
                        this.errors.put(error.response.data);
                        this.showErrorNotify(error);
                    });
            },
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
            onSelectClient(client_id) {
                this.getClientDetails(client_id);
            },
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
        },
        mounted() {
            this.getClients();
        },
    }
</script>

<style lang="scss">

</style>