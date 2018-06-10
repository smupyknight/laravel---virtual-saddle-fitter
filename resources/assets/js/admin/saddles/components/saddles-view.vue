<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Saddle Details: {{ data.name }}</h5>
            <div class="ibox-tools">
                <a href="javascript:history.back()" class="btn btn-xs btn-default">Back</a>
                <router-link :to="{ name: 'saddles-edit', params: { id: data.id } }"
                             class="btn btn-primary btn-xs">Edit
                </router-link>
            </div>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <div class="form-horizontal">

                <!-- select rider -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Rider</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.rider.first_name + ' ' + data.rider.last_name }}</p>
                    </div>
                </div>
                <!-- select rider end -->

                <!-- select horse -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Horse</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.horse.stable_name }}</p>
                    </div>
                </div>
                <!-- select horse end -->

                <!-- select brand -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Brand</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.brand.name }}</p>
                    </div>
                </div>
                <!-- select brand end -->

                <!-- select style -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Style</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.style.name }}</p>
                    </div>
                </div>
                <!-- select style end -->

                <!-- input name -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Model</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.name }}</p>
                    </div>
                </div>
                <!-- input name end -->

                <!-- input price -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Price</label>
                    <div class="col-md-10">
                        <p class="form-control-static">$ {{ data.price }}</p>
                    </div>
                </div>
                <!-- input price end -->

                <!-- input serial_number -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Serial Number</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.serial_number }}</p>
                    </div>
                </div>
                <!-- input serial_number end -->

                <!-- input size -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Saddle Seat Size</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.size }}</p>
                    </div>
                </div>
                <!-- input size end -->

                <!-- select type -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Type</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.type }}</p>
                    </div>
                </div>
                <!-- select type end -->

                <!-- select gullet_size -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Gullet Size</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.gullet_size }}</p>
                    </div>
                </div>
                <!-- select gullet_size end -->

                <!-- select panel_type -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Panel Type</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.panel_type }}</p>
                    </div>
                </div>
                <!-- select panel_type end -->

                <!-- select seat_style -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Seat Style</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.seat_style }}</p>
                    </div>
                </div>
                <!-- select seat_style end -->

                <!-- input purchased_at -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Purchase Date</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.purchased_at }}</p>
                    </div>
                </div>
                <!-- input purchased_at end -->

                <!-- input warranty_period -->
                <div class="form-group">
                    <label class="col-md-2 control-label">Warranty Period</label>
                    <div class="col-md-10">
                        <p class="form-control-static">{{ data.warranty_period }}</p>
                    </div>
                </div>
                <!-- input warranty_period end -->

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mixins: [FormErrors, MyAxios],
        props: {
            saddlesResourceUrl: '',
        },
        data() {
            return {
                data: {
                    rider_id: '',
                    horse_id: '',
                    brand_id: '',
                    style_id: '',
                    name: '',
                    price: 0,
                    serial_number: '',
                    size: '',
                    type: '',
                    gullet_size: '',
                    panel_type: '',
                    seat_style: '',
                    purchased_at: '',
                    warranty_period: 0,
                    rider: {
                        'first_name': '',
                        'last_name': '',
                    },
                    horse: {
                        'stable_name': '',
                    },
                    style: {
                        'name': '',
                    },
                    brand: {
                        'name': '',
                    }
                }
            }
        },
        methods: {
            getSaddle() {
                this.myAxios.get(this.saddlesResourceUrl + '/' + this.$route.params.id)
                    .then((res) => {
                        this.data = res.data;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
            }
        },
        mounted() {
            this.getSaddle();
        },
    }
</script>

<style lang="scss">

</style>