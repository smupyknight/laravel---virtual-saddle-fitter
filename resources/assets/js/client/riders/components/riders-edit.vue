<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Edit Rider: {{ data.first_name }} {{ data.last_name }}</h5>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <form class="form-horizontal">

                <div class="form-group" :class="{'has-error': errors.has('first_name')}">
                    <label class="col-md-2 control-label" for="first_name">First Name</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.first_name" id="first_name">
                        <span class="help-block is-danger"><strong>{{ errors.get('first_name') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('last_name')}">
                    <label class="col-md-2 control-label" for="last_name">Last Name</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.last_name" id="last_name">
                        <span class="help-block is-danger"><strong>{{ errors.get('last_name') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('address')}">
                    <label class="col-md-2 control-label" for="address">Address</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.address" id="address">
                        <span class="help-block is-danger"><strong>{{ errors.get('address') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('postcode')}">
                    <label class="col-md-2 control-label" for="postcode">Post Code</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.postcode" id="postcode">
                        <span class="help-block is-danger"><strong>{{ errors.get('postcode') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('suburb')}">
                    <label class="col-md-2 control-label" for="suburb">Suburb</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.suburb" id="suburb">
                        <span class="help-block is-danger"><strong>{{ errors.get('suburb') }}</strong></span>
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

                <div class="form-group" :class="{'has-error': errors.has('mobile')}">
                    <label class="col-md-2 control-label" for="mobile">Mobile</label>
                    <div class="col-md-10">
                        <input class="form-control no-spin" type="number" v-model="data.mobile" id="mobile">
                        <span class="help-block is-danger"><strong>{{ errors.get('mobile') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('email')}">
                    <label class="col-md-2 control-label" for="email">Email</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.email" id="email">
                        <span class="help-block is-danger"><strong>{{ errors.get('email') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('discipline')}">
                    <label class="col-md-2 control-label" for="discipline">Discipline</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.discipline" id="discipline">
                            <option selected disabled value="">Select Discipline</option>
                            <option v-for="discipline in disciplines"
                                    :value="discipline">{{ discipline }}</option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('discipline') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('stirrup_size')}">
                    <label class="col-md-2 control-label" for="stirrup_size">Stirrup Size</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" v-model="data.stirrup_size" id="stirrup_size">
                        <span class="help-block is-danger"><strong>{{ errors.get('stirrup_size') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('stirrup_leather')}">
                    <label class="col-md-2 control-label" for="stirrup_leather">Stirrup Leather</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.stirrup_leather" id="stirrup_leather">
                        <span class="help-block is-danger"><strong>{{ errors.get('stirrup_leather') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('height')}">
                    <label class="col-md-2 control-label" for="height">Height</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" v-model="data.height" id="height">
                        <span class="help-block is-danger"><strong>{{ errors.get('height') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('jodphur_size')}">
                    <label class="col-md-2 control-label" for="jodphur_size">Jodphur Size</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.jodphur_size" id="jodphur_size">
                        <span class="help-block is-danger"><strong>{{ errors.get('jodphur_size') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('is_vip_member')}">
                    <label class="col-md-2 control-label" for="is_vip_member">Is VIP Member?</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.is_vip_member" id="is_vip_member">
                            <option value="true">Yes</option>
                            <option value="false">No</option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('is_vip_member') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('award_points')}">
                    <label class="col-md-2 control-label" for="award_points">Award Points</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" min="0" v-model="data.award_points" id="award_points">
                        <span class="help-block is-danger"><strong>{{ errors.get('award_points') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('has_registered_on_website')}">
                    <label class="col-md-2 control-label" for="has_registered_on_website">Has Registered on Website?</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.has_registered_on_website" id="has_registered_on_website">
                            <option value="true">Yes</option>
                            <option value="false">No</option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('has_registered_on_website') }}</strong></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-w-m btn-primary" @click.prevent="postPut()">Update</button>
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
        },
        data() {
            return {
                clients: [],
                disciplines: [],
                data: {
                    first_name: '',
                    last_name: '',
                    address: '',
                    postcode: '',
                    suburb: '',
                    state: '',
                    mobile: '',
                    email: '',
                    discipline: '',
                    stirrup_size: '',
                    stirrup_leather: '',
                    height: '',
                    jodphur_size: '',
                    is_vip_member: 0,
                    award_points: 0,
                    has_registered_on_website: 0,
                },
            }
        },
        methods: {
            postPut() {
                this.myAxios.put(this.resourceUrl + '/' + this.$route.params.id, this.data)
                    .then((response) => {
                        this.showElementNotify('Rider Updated', 'Rider has updated.');
                        this.$router.push({ name: 'riders-view', params: { id: response.data.id } });
                    })
                    .catch((error) => {
                        console.log(error);
                        this.errors.put(error.response.data);
                        this.showErrorNotify(error);
                    });
            },
            getDisciplines() {
                this.myAxios.get(this.disciplinesResourceUrl)
                    .then((res) => {
                        this.disciplines = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
            },
            getRider() {
                this.myAxios.get(this.resourceUrl + '/' + this.$route.params.id)
                    .then((response) => {
                        this.data = response.data.rider;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
            }
        },
        mounted() {
            this.getDisciplines();
            this.getRider();
        },
    }
</script>

<style lang="scss">

</style>