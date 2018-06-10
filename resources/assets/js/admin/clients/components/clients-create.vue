<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Create a New Client</h5>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <form class="form-horizontal">

                <div class="form-group" :class="{'has-error': errors.has('name')}">
                    <label class="col-md-2 control-label" for="name">Name</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.name" id="name">
                        <span class="help-block is-danger"><strong>{{ errors.get('name') }}</strong></span>
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('email')}">
                    <label class="col-md-2 control-label" for="email">Email</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.email" id="email">
                        <span class="help-block is-danger"><strong>{{ errors.get('email') }}</strong></span>
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
            clientsResourceUrl: '',
        },
        data() {
            return {
                data: {
                    name: '',
                    email: '',
                    address: '',
                    postcode: '',
                    suburb: '',
                    state: '',
                },
            }
        },
        methods: {
            postCreate() {
                this.myAxios.post(this.clientsResourceUrl, this.data)
                    .then((response) => {
                        this.showElementNotify('Client Created', 'New client has created.');
                        this.$router.push({ name: 'clients-view', params: { id: response.data.id } });
                    })
                    .catch((error) => {
                        console.log(error);
                        this.errors.put(error.response.data);
                        this.showErrorNotify(error);
                    });
            },
        },
        mounted() {
        },
    }
</script>

<style lang="scss">

</style>