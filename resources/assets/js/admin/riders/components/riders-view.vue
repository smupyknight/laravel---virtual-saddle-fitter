<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Details of Rider: {{ data.rider.first_name + ' ' + data.rider.last_name }}</h5>
            <div class="ibox-tools">
                <a href="javascript:history.back()" class="btn btn-xs btn-default">Back</a>
                <router-link :to="{ name: 'riders-edit', params: { id: data.rider.id } }" class="btn btn-primary btn-xs">Edit</router-link>
            </div>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <div class="form-horizontal">
                <div class="form-group">

                    <label class="col-md-2 control-label">Client: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.client.name }}</p>
                    </div>

                    <label class="col-md-2 control-label">First Name :</label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.first_name }}</p>
                    </div>

                    <label class="col-md-2 control-label">Last Name:</label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.last_name }}</p>
                    </div>

                    <label class="col-md-2 control-label">Address: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.address }}</p>
                    </div>

                    <label class="col-md-2 control-label">Postcode: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.postcode }}</p>
                    </div>

                    <label class="col-md-2 control-label">Suburb: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.suburb }}</p>
                    </div>

                    <label class="col-md-2 control-label">State: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.state }}</p>
                    </div>

                    <label class="col-md-2 control-label">Mobile Number: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.mobile }}</p>
                    </div>

                    <label class="col-md-2 control-label">Email Address: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.email }}</p>
                    </div>

                    <label class="col-md-2 control-label">Discipline: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.discipline }}</p>
                    </div>

                    <label class="col-md-2 control-label">Stirrup Size: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.stirrup_size }}</p>
                    </div>

                    <label class="col-md-2 control-label">Stirrup Leather: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.stirrup_leather }}</p>
                    </div>

                    <label class="col-md-2 control-label">Height: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.height }}</p>
                    </div>

                    <label class="col-md-2 control-label">Jodphur Size: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.jodphur_size }}</p>
                    </div>

                    <label class="col-md-2 control-label">Is Vip Member: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.is_vip_member }}</p>
                    </div>

                    <label class="col-md-2 control-label">Award Points: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.award_points}}</p>
                    </div>

                    <label class="col-md-2 control-label">Has registered on website: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.has_registered_on_website }}</p>
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
            ridersResourceUrl: '',
        },
        data() {
            return {
                data: {
                    client: {
                        name: ''
                    },
                    rider: {
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
                        is_vip_member: '',
                        award_points: '',
                        has_registered_on_website: '',
                    }
                },
            }
        },
        methods: {
            getRider() {
                this.myAxios.get(this.ridersResourceUrl + '/' + this.$route.params.id)
                    .then((response) => {
                        this.data = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
            }
        },
        mounted() {
        this.getRider();
    },
    }
</script>

<style lang="scss">

</style>