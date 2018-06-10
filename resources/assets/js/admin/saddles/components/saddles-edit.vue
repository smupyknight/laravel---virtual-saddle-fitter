<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Edit Saddle: {{ data.name }}</h5>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <form class="form-horizontal">

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
                        <select class="form-control" v-model="data.horse_id" id="horse_id">
                            <option selected disabled value="">Select Horse</option>
                            <option v-for="horse in horses"
                                    :value="horse.id">{{ horse.stable_name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('horse_id') }}</strong></span>
                    </div>
                </div>
                <!-- select horse end -->

                <!-- select brand -->
                <div class="form-group" :class="{'has-error': errors.has('brand_id')}">
                    <label class="col-md-2 control-label" for="brand_id">Brand</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.brand_id" id="brand_id"
                                @change="onSelectBrand(data.brand_id)">
                            <option selected disabled value="">Select Brand</option>
                            <option v-for="brand in brands"
                                    :value="brand.id">{{ brand.name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('brand_id') }}</strong></span>
                    </div>
                </div>
                <!-- select brand end -->

                <!-- select style -->
                <div class="form-group" :class="{'has-error': errors.has('style_id')}">
                    <label class="col-md-2 control-label" for="style_id">Style</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.style_id" id="style_id">
                            <option selected disabled value="">Select Style</option>
                            <option v-for="style in styles"
                                    :value="style.id">{{ style.name }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('style_id') }}</strong></span>
                    </div>
                </div>
                <!-- select style end -->

                <!-- input name -->
                <div class="form-group" :class="{'has-error': errors.has('name')}">
                    <label class="col-md-2 control-label" for="name">Model</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.name" id="name"
                               @focus="showTooltip" @blur="hideTooltip">
                        <div class="tooltip-under-the-box">If you are not sure, please add a '0' or 'Unknown' to progress to the next step</div>
                        <span class="help-block is-danger"><strong>{{ errors.get('name') }}</strong></span>
                    </div>
                </div>
                <!-- input name end -->

                <!-- input price -->
                <div class="form-group" :class="{'has-error': errors.has('price')}">
                    <label class="col-md-2 control-label" for="price">Price</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" v-model="data.price" id="price">
                        <span class="help-block is-danger"><strong>{{ errors.get('price') }}</strong></span>
                    </div>
                </div>
                <!-- input price end -->

                <!-- input serial_number -->
                <div class="form-group" :class="{'has-error': errors.has('serial_number')}">
                    <label class="col-md-2 control-label" for="serial_number">Serial Number</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.serial_number" id="serial_number"
                               @focus="showTooltip" @blur="hideTooltip">
                        <div class="tooltip-under-the-box">If you are not sure, please add a '0' or 'Unknown' to progress to the next step</div>
                        <span class="help-block is-danger"><strong>{{ errors.get('serial_number') }}</strong></span>
                    </div>
                </div>
                <!-- input serial_number end -->

                <!-- input size -->
                <div class="form-group" :class="{'has-error': errors.has('size')}">
                    <label class="col-md-2 control-label" for="size">Saddle Seat Size</label>
                    <div class="col-md-10">
                        <div class="input-group">
                            <input class="form-control" v-model="data.size" id="size"
                                   @focus="showTooltip" @blur="hideTooltip" autocomplete="false">
                            <div class="input-group-addon">Inches</div>
                        </div>
                        <div class="tooltip-under-the-box">If you are not sure, please add a '0' or 'Unknown' to progress to the next step</div>
                        <span class="help-block is-danger"><strong>{{ errors.get('size') }}</strong></span>
                    </div>
                </div>
                <!-- input size end -->

                <!-- select type -->
                <div class="form-group" :class="{'has-error': errors.has('type')}">
                    <label class="col-md-2 control-label" for="type">Type</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.type" id="type">
                            <option selected disabled value="">Select Type</option>
                            <option v-for="type in selectOptions.saddle_type"
                                    :value="type">{{ type }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('type') }}</strong></span>
                    </div>
                </div>
                <!-- select type end -->

                <!-- select gullet_size -->
                <div class="form-group" :class="{'has-error': errors.has('gullet_size')}">
                    <label class="col-md-2 control-label" for="gullet_size">Gullet Size</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.gullet_size" id="gullet_size">
                            <option selected disabled value="">Select Gullet Size</option>
                            <option v-for="gullet_size in selectOptions.gullet_size"
                                    :value="gullet_size">{{ gullet_size }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('gullet_size') }}</strong></span>
                    </div>
                </div>
                <!-- select gullet_size end -->

                <!-- select panel_type -->
                <div class="form-group" :class="{'has-error': errors.has('panel_type')}">
                    <label class="col-md-2 control-label" for="panel_type">Panel Type</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.panel_type" id="panel_type">
                            <option selected disabled value="">Select Panel Type</option>
                            <option v-for="panel_type in selectOptions.panel_type"
                                    :value="panel_type">{{ panel_type }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('panel_type') }}</strong></span>
                    </div>
                </div>
                <!-- select panel_type end -->

                <!-- select seat_style -->
                <div class="form-group" :class="{'has-error': errors.has('seat_style')}">
                    <label class="col-md-2 control-label" for="seat_style">Seat Style</label>
                    <div class="col-md-10">
                        <select class="form-control" v-model="data.seat_style" id="seat_style">
                            <option selected disabled value="">Select Seat Style</option>
                            <option v-for="seat_style in selectOptions.seat_style"
                                    :value="seat_style">{{ seat_style }}
                            </option>
                        </select>
                        <span class="help-block is-danger"><strong>{{ errors.get('seat_style') }}</strong></span>
                    </div>
                </div>
                <!-- select seat_style end -->

                <!-- input purchased_at -->
                <div class="form-group" :class="{'has-error': errors.has('purchased_at')}">
                    <label class="col-md-2 control-label" for="purchased_at">Purchase Date</label>
                    <div class="col-md-10">
                        <input class="form-control" v-model="data.purchased_at" id="purchased_at">
                        <span class="help-block is-danger"><strong>{{ errors.get('purchased_at') }}</strong></span>
                    </div>
                </div>
                <!-- input purchased_at end -->

                <!-- input warranty_period -->
                <div class="form-group" :class="{'has-error': errors.has('warranty_period')}">
                    <label class="col-md-2 control-label" for="warranty_period">Warranty Period</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" v-model="data.warranty_period" id="warranty_period">
                        <span class="help-block is-danger"><strong>{{ errors.get('warranty_period') }}</strong></span>
                    </div>
                </div>
                <!-- input warranty_period end -->

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <button type="button" class="btn btn-w-m btn-primary" @click.prevent="postPut()">Update
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
            saddlesResourceUrl: '',
            brandsResourceUrl: '',
            horsesResourceUrl: '',
            ridersResourceUrl: '',
        },
        data() {
            return {
                horses: [],
                riders: [],
                brands: [],
                styles: [],
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
                },
                selectOptions: {
                    saddle_type: [],
                    seat_style: [],
	                panel_type: [],
	                gullet_size: [],
                }
            }
        },
        methods: {
            postPut() {
                this.myAxios.put(this.saddlesResourceUrl + '/' + this.$route.params.id, this.data)
                    .then((response) => {
                        this.showElementNotify('Saddle Updated', 'Saddle information has Updated.');
                        this.$router.push({ name: 'saddles-view', params: { id: response.data.id } });
                    })
                    .catch((error) => {
                        console.log(error);
                        this.errors.put(error.response.data);
                        this.showErrorNotify(error);
                    });
            },
            getSaddle() {
                this.myAxios.get(this.saddlesResourceUrl + '/' + this.$route.params.id)
                    .then((res) => {
                        this.data = res.data;
	                    this.selectOptions.saddle_type = res.data.available_types;
	                    this.selectOptions.seat_style = res.data.available_seat_styles;
	                    this.selectOptions.panel_type = res.data.available_panel_types;
	                    this.selectOptions.gullet_size = res.data.available_gullet_sizes;
                        this.getData();
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
            },
            getData() {
                this.myAxios.get(this.ridersResourceUrl, {
                        params: {
                            per_page: Number.MAX_SAFE_INTEGER,
                        }
                    })
                    .then((res) => {
                        this.riders = res.data.data;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
                this.myAxios.get(this.horsesResourceUrl, {
                        params: {
                            per_page: Number.MAX_SAFE_INTEGER,
                        }
                    })
                    .then((res) => {
                        this.horses = res.data.data;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
                this.myAxios.get(this.brandsResourceUrl)
                    .then((res) => {
                        this.brands = res.data;
                        this.getStyles(this.data.brand_id);
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
            },
            getStyles(brand_id) {
                this.myAxios.get(this.brandsResourceUrl + '/' + brand_id)
                    .then((res) => {
                        this.styles = res.data.styles;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
            },
            onSelectBrand(brand_id) {
                this.getStyles(brand_id);
                this.data.style_id = '';
            },
	        showTooltip(e){
            	$(e.target).closest('.form-group').addClass('focused');
            },
	        hideTooltip(e){
		        $(e.target).closest('.form-group').removeClass('focused');
	        },
        },
        mounted() {
            this.getSaddle();

            $('#purchased_at').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: true,
                locale: {
                    format: 'DD/MM/YYYY'
                },
            }, (date) => {
                this.data.purchased_at = date.format('DD/MM/YYYY');
            });
        },
    }
</script>

<style lang="scss" scoped>
    
</style>