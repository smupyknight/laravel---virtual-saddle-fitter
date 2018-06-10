<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Details of Horse: {{ data.stable_name }}</h5>
            <div class="ibox-tools">
                <a href="javascript:history.back()" class="btn btn-xs btn-default">Back</a>
                <router-link :to="{ name: 'horses-edit', params: { id: data.id } }"
                             class="btn btn-primary btn-xs">Edit
                </router-link>
            </div>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <div class="form-horizontal">

                <div class="form-group">
                    <label class="col-md-2 control-label" for="client_name">Client</label>
                    <div class="col-md-10">
                        <p class="form-control-static" id="client_name">{{ data.client.name }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="stable_name">Stable Name</label>
                    <div class="col-md-10">
                        <p class="form-control-static" id="stable_name">{{ data.stable_name }}</p>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('breeding_name')}">
                    <label class="col-md-2 control-label" for="breeding_name">Breeding Name</label>
                    <div class="col-md-10">
                        <p class="form-control-static" id="breeding_name">{{ data.breeding_name }}</p>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('paddock_address')}">
                    <label class="col-md-2 control-label" for="paddock_address">Paddock Address</label>
                    <div class="col-md-10">
                        <p class="form-control-static" id="paddock_address">{{ data.paddock_address }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('postcode')}">
                            <label class="col-md-4 control-label" for="postcode">Post Code</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="postcode">{{ data.postcode }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('suburb')}">
                            <label class="col-md-4 control-label" for="suburb">Suburb</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="suburb">{{ data.suburb }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('state')}">
                    <label class="col-md-2 control-label" for="state">State</label>
                    <div class="col-md-10">
                        <p class="form-control-static" id="state">{{ data.state }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('breed')}">
                            <label class="col-md-4 control-label" for="breed">Breed</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="breed">{{ data.breed }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('colour')}">
                            <label class="col-md-4 control-label" for="colour">Colour</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="colour">{{ data.colour }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('height')}">
                            <label class="col-md-4 control-label" for="height">Height</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="height">{{ data.height }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('weight')}">
                            <label class="col-md-4 control-label" for="weight">Weight</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="weight">{{ data.weight }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('girth')}">
                            <label class="col-md-4 control-label" for="girth">Girth</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="girth">{{ data.girth }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('age')}">
                            <label class="col-md-4 control-label" for="age">Age</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="age">{{ data.age }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('dob')}">
                            <label class="col-md-4 control-label" for="dob">Date of Birth</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="dob">{{ data.dob }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('discipline')}">
                            <label class="col-md-4 control-label" for="discipline">Discipline</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="discipline">{{ data.discipline }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('sex')}">
                            <label class="col-md-4 control-label" for="sex">Sex</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="sex">{{ data.sex }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-error': errors.has('microchip_number')}">
                            <label class="col-md-4 control-label" for="microchip_number">Microchip Number</label>
                            <div class="col-md-8">
                                <p class="form-control-static" id="microchip_number">{{ data.microchip_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mixins: [FormErrors, MyAxios],
        props: {
            horsesResourceUrl: '',
        },
        data() {
            return {
                data: {
                    client: {
                        'name': '',
                    },
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
                this.myAxios.get(this.horsesResourceUrl + '/' + this.$route.params.id)
                    .then((res) => {
                        this.data = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
            },
        },
        mounted() {
            this.getData();
        },
    }
</script>

<style lang="scss">

</style>