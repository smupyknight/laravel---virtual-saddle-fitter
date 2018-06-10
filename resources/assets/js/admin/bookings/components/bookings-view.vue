<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Details of Booking: #{{ data.id }}</h5>
            <div class="ibox-tools">
                <a href="javascript:history.back()" class="btn btn-xs btn-default">Back</a>
                <router-link :to="{ name: 'bookings-edit', params: { id: data.id } }"
                             class="btn btn-primary btn-xs">Edit
                </router-link>
            </div>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <div class="form-horizontal">
                <div class="form-group">

                    <label class="col-md-2 control-label">Client: </label>
                    <div class="col-md-10">
                        <p class="form-control-static"> {{ data.client.name }}</p>
                    </div>

                    <label class="col-md-2 control-label">Horse: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.horse.stable_name }}</p>
                    </div>

                    <label class="col-md-2 control-label">Saddle: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.saddle.name }}</p>
                    </div>

                    <label class="col-md-2 control-label">Rider: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.rider.first_name + ' ' + data.rider.last_name }}</p>
                    </div>

                    <label class="col-md-2 control-label">Fitter User: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.user.first_name + ' ' + data.user.last_name }}</p>
                    </div>

                    <label class="col-md-2 control-label">Date: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.date }}</p>
                    </div>

                    <label class="col-md-2 control-label">Address: </label>
                    <div class="col-md-4">
                        <p class="form-control-static"> {{ data.address }}</p>
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
            bookingsResourceUrl: '',
        },
        data() {
            return {
                data: {
                    client: {
                        name: ''
                    },
                    horse: {
                        stable_name: '',
                    },
                    rider: {
                        first_name: '',
                        last_name: '',
                    },
                    user: {
                        first_name: '',
                        last_name: '',
                    },
                },
            }
        },
        methods: {
            getBooking() {
                this.myAxios.get(this.bookingsResourceUrl + '/' + this.$route.params.id)
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
            this.getBooking();
        },
    }
</script>

<style lang="scss">

</style>