<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Fit Check: {{ data.horse.stable_name }}</h5>
            <div class="ibox-tools">
                <router-link :to="{ name: 'fitchecks-edit', params: {id: this.$route.params.id}}"
                             class="btn btn-primary btn-xs">Edit
                </router-link>
            </div>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <div class="row">
                <!--step 0 Rider -->
                <div class="col-md-12 m-b">
                    <el-form ref="step0" labelWidth="120px" :model="data.rider">
                        <h2>
                            Rider <a class="small-link" :href="'/admin/riders#/view/' + data.rider.id" target="_blank">(View Details...)</a>
                        </h2>

                        <el-row>
                            <el-col :sm="{span:24}" :md="{span:12}">
                                <el-form-item label="First Name">
                                    <el-input v-model="data.rider.first_name" :readonly="true"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :sm="{span:24}" :md="{span:12}">
                                <el-form-item label="Last Name">
                                    <el-input v-model="data.rider.last_name" :readonly="true"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                    </el-form>
                </div>
                <!--step 0 Rider end -->
                <!--step 1 Horse -->
                <div class="col-md-12 m-b">
                    <h2>
                        Horse <a class="small-link" :href="'/admin/horses#/view/' + data.horse.id" target="_blank">(View Details...)</a>
                    </h2>
                    <!--step 1_0 Horse details-->
                    <el-form labelWidth="120px" :model="data.horse">
                        <el-form-item label="Stable Name">
                            <el-input v-model="data.horse.stable_name" :readonly="true"></el-input>
                        </el-form-item>
                    </el-form>
                    <!--step 1_0 Horse details end-->
                    <!--step 1_1 Back assessment-->
                    <el-form labelWidth="120px" :model="data.field_data">

                        <el-form-item label="Back Length">
                            <el-input v-model="data.field_data.back_length" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Wither Template">
                            <el-input v-model="data.field_data.wither_template" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Wither Shape">
                            <el-input v-model="data.field_data.wither_shape" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Back Type">
                            <el-input v-model="data.field_data.back_type" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Shoulder">
                            <el-checkbox-group v-model="data.field_data.shoulder">
                                <el-checkbox v-for="shoulder in selectOptions.shoulder"
                                             :label="shoulder"
                                             :key="shoulder" :readonly="true" :disabled="true">
                                    {{ shoulder }}
                                </el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Abdomen">
                            <el-input v-model="data.field_data.abdomen" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Fat Cover">
                            <el-slider v-model="data.field_data.fat_cover" :step="1" :min="1" :max="6" :readonly="true"
                                       :disabled="true"></el-slider>
                        </el-form-item>

                        <el-form-item label="Muscling">
                            <el-slider v-model="data.field_data.muscling" :step="1" :min="1" :max="6" :readonly="true"
                                       :disabled="true"></el-slider>
                        </el-form-item>

                    </el-form>
                    <!--step 1_1 Back assessment end-->
                    <!--step 1_2 Saddle Balance-->
                    <el-form labelWidth="120px" :model="data.field_data">

                        <el-form-item label="Back Angle">
                            <el-input v-model="data.field_data.back_angle" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Point of Hip/Tuber Coxae">
                            <el-input v-model="data.field_data.point_of_hip_tuber_coxae" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Girth Position">
                            <el-input v-model="data.field_data.girth_position" :readonly="true"></el-input>
                        </el-form-item>

                    </el-form>
                    <!--step 1_2 Saddle Balance end-->
                    <!--step 1_3 Back Problems-->
                    <el-form labelWidth="120px" :model="data.field_data">

                        <el-form-item label="Muscle Wastage">
                            <el-checkbox-group v-model="data.field_data.muscle_wastage">
                                <el-checkbox-button v-for="muscle_wastage in selectOptions.muscle_wastage"
                                                    :label="muscle_wastage"
                                                    :key="muscle_wastage"
                                                    :readonly="true" :disabled="true">
                                    {{ muscle_wastage }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Muscle Soreness">
                            <el-checkbox-group v-model="data.field_data.soreness">
                                <el-checkbox-button v-for="soreness in selectOptions.soreness"
                                                    :label="soreness"
                                                    :key="soreness"
                                                    :readonly="true" :disabled="true">
                                    {{ soreness }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Hair Changes">
                            <el-checkbox-group v-model="data.field_data.hair_changes">
                                <el-checkbox-button v-for="hair_changes in selectOptions.hair_changes"
                                                    :label="hair_changes"
                                                    :key="hair_changes"
                                                    :readonly="true" :disabled="true">
                                    {{ hair_changes }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Reduced Flexibility">
                            <el-checkbox-group v-model="data.field_data.reduced_flexibility">
                                <el-checkbox-button v-for="reduced_flexibility in selectOptions.reduced_flexibility"
                                                    :label="reduced_flexibility"
                                                    :key="reduced_flexibility"
                                                    :readonly="true" :disabled="true">
                                    {{ reduced_flexibility }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Palation Findings">
                            <el-checkbox-group v-model="data.field_data.palation_findings">
                                <el-checkbox-button v-for="palation_findings in selectOptions.palation_findings"
                                                    :label="palation_findings"
                                                    :key="palation_findings"
                                                    :readonly="true" :disabled="true">
                                    {{ palation_findings }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                    </el-form>
                    <!--step 1_3 Back Problems end-->
                    <!--step 1_4 Feet Observations-->
                    <el-form labelWidth="120px" :model="data.field_data">

                        <el-form-item label="Foot Problem">
                            <el-checkbox-group v-model="data.field_data.foot_problems">
                                <el-checkbox v-for="foot_problems in selectOptions.foot_problems"
                                             :label="foot_problems"
                                             :key="foot_problems"
                                             :readonly="true" :disabled="true">
                                    {{ foot_problems }}
                                </el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Feet Length">
                            <el-input v-model="data.field_data.feet_length" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Heel Balance">
                            <el-input v-model="data.field_data.heel_balance" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Foot Balance">
                            <el-input v-model="data.field_data.foot_balance" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Shoeing Status">
                            <el-input v-model="data.field_data.shoeing_status" :readonly="true"></el-input>
                        </el-form-item>

                    </el-form>
                    <!--step 1_4 Feet Observations end-->
                    <!--step 1_5 Movement & Behaviour Observations-->
                    <el-form labelWidth="120px" :model="data.field_data">

                        <el-form-item label="When Saddled">
                            <el-checkbox-group v-model="data.field_data.movement_when_saddled">
                                <el-checkbox-button v-for="movement_when_saddled in selectOptions.movement_when_saddled"
                                                    :label="movement_when_saddled"
                                                    :key="movement_when_saddled"
                                                    :readonly="true" :disabled="true">
                                    {{ movement_when_saddled }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Horse Saddled With No Rider">
                            <el-checkbox-group v-model="data.field_data.movement_when_saddled_no_rider">
                                <el-checkbox-button
                                        v-for="movement_when_saddled_no_rider in selectOptions.movement_when_saddled_no_rider"
                                        :label="movement_when_saddled_no_rider"
                                        :key="movement_when_saddled_no_rider"
                                        :readonly="true" :disabled="true">
                                    {{ movement_when_saddled_no_rider }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="When Ridden">
                            <el-checkbox-group v-model="data.field_data.movement_when_ridden">
                                <el-checkbox-button v-for="movement_when_ridden in selectOptions.movement_when_ridden"
                                                    :label="movement_when_ridden"
                                                    :key="movement_when_ridden"
                                                    :readonly="true" :disabled="true">
                                    {{ movement_when_ridden }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                    </el-form>
                    <!--step 1_5 Movement & Behaviour Observations end-->
                </div>
                <!--step 1 Horse end -->
                <!--step 2 Saddle -->
                <div class="col-md-12 m-b">
                    <h2>
                        Saddle <a class="small-link" :href="'/admin/saddles#/view/' + data.saddle.id" target="_blank">(View Details...)</a>
                    </h2>
                    <!--step 2_0 Saddle Details-->
                    <el-form labelWidth="120px" :model="data.saddle">

                        <el-form-item label="Saddle Name">
                            <el-input v-model="data.saddle.name" :readonly="true"></el-input>
                        </el-form-item>

                    </el-form>
                    <!--step 2_0 Saddle Details end-->
                    <!--step 2_1 Saddle Fit-->
                    <el-form labelWidth="120px" :model="data.field_data">

                        <el-form-item label="Saddle Balance">
                            <el-input v-model="data.field_data.saddle_balance" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Pummel Clearance">
                            <el-input v-model="data.field_data.pommel_clearance" :readonly="true"></el-input>
                        </el-form-item>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Saddle Length">
                                    <el-input v-model="data.field_data.saddle_length" :readonly="true"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Tree Match Wither">
                                    <el-input v-model="data.field_data.tree_match_at_wither"
                                              :readonly="true"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-form-item label="Tree Match with Arc of Spine">
                            <el-input v-model="data.field_data.tree_match_at_arc_of_spine" :readonly="true"></el-input>
                        </el-form-item>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Channel Depth">
                                    <el-input v-model="data.field_data.channel_depth" :readonly="true"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Channel Width">
                                    <el-input v-model="data.field_data.channel_width" :readonly="true"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-form-item label="">
                            <el-checkbox v-model="data.field_data.saddle_tilt" :readonly="true" :disabled="true">
                                Does the saddle tilt to one side when viewed from rear?
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="">
                            <el-checkbox v-model="data.field_data.saddle_twist" :readonly="true" :disabled="true">
                                Does the saddle twist when viewed from side?
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="Contours of the Panel">
                            <el-input v-model="data.field_data.contours_of_panel" :readonly="true"></el-input>
                        </el-form-item>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Girth Point Angle">
                                    <el-input v-model="data.field_data.girth_point_angle" :readonly="true"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Girth Point Positions">
                                    <el-input v-model="data.field_data.girth_point_position"
                                              :readonly="true"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Girth Type">
                                    <el-input v-model="data.field_data.girth_type" :readonly="true"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Girth Size">
                                    <div class="input-group">
                                        <el-input v-model="data.field_data.girth_size" :readonly="true">
                                        </el-input>
                                        <span class="input-group-addon">CM</span>
                                    </div>
                                </el-form-item>

                            </el-col>
                        </el-row>

                    </el-form>
                    <!--step 2_1 Saddle Fit end-->
                    <!--step 2_2 Rider In Saddle-->
                    <el-form labelWidth="120px" :model="data.field_data">

                        <el-form-item label="Drops Left/Right">
                            <el-input v-model="data.field_data.drops_to" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="Sits Off Centre">
                            <el-input v-model="data.field_data.sits_off_centre" :readonly="true"></el-input>
                        </el-form-item>

                        <el-form-item label="">
                            <el-checkbox v-model="data.field_data.sits_upright" :readonly="true" :disabled="true">
                                Sites Upright ?
                            </el-checkbox>
                        </el-form-item>

                    </el-form>
                    <!--step 2_2 Rider In Saddle end-->
                    <!--step 2_3 Rider In Saddle 2-->
                    <el-form labelWidth="120px" :model="data.field_data">

                        <el-form-item label="">
                            <el-checkbox v-model="data.field_data.flocking_front" :readonly="true" :disabled="true">
                                Flocking Front
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="">
                            <el-checkbox v-model="data.field_data.flocking_middle" :readonly="true" :disabled="true">
                                Flocking Middle
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="">
                            <el-checkbox v-model="data.field_data.flocking_back" :readonly="true" :disabled="true">
                                Flocking Back
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="Alteration" prop="alterations">
                            <div v-for="(item, index) in data.field_data.alterations"
                                 :key="index">
                                <el-input v-model="data.field_data.alterations[index]" :readonly="true"></el-input>
                            </div>
                        </el-form-item>

                        <el-form-item label="Alteration History" prop="history_of_alterations">
                            <div v-for="(item, index) in data.field_data.history_of_alterations"
                                 :key="index">
                                <el-input v-model="data.field_data.history_of_alterations[index]" :readonly="true"></el-input>
                            </div>
                        </el-form-item>

                        <el-form-item label="Recommended Products" prop="recommended_products">
                            <div v-for="(item, index) in data.field_data.recommended_products"
                                 :key="index">
                                <el-input v-model="data.field_data.recommended_products[index]" :readonly="true"></el-input>
                            </div>
                        </el-form-item>

                        <div id="drawing-uploaded" v-if="data.drawing">
                            <label>Drawing</label>
                            <div class="preview-image"><a :href="'/drawings/'+data.drawing.id" target="_blank"><img :src="'/drawings/'+data.drawing.id" class="image"></a></div>
                        </div>

                    </el-form>
                    <!--step 2_3 Rider In Saddle 2 end-->
                </div>
                <!--step 2 Saddle -->
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        mixins: [FormErrors, MyAxios],
        props: {
            fitchecksResourceUrl: '',
            ridersResourceUrl: '',
            horsesResourceUrl: '',
            saddlesResourceUrl: '',
	        drawingsResourceUrl: '',
            brandsResourceUrl: '',
            disciplinesResourceUrl: '',
            breedsResourceUrl: '',
        },
        data() {
            return {
                data: {
                    rider: {
                        'id': '',
                        'client_id': '',
                        'first_name': '',
                        'last_name': '',
                        'address': '',
                        'postcode': '',
                        'suburb': '',
                        'state': '',
                        'mobile': '',
                        'email': '',
                        'discipline': '',
                        'stirrup_size': '',
                        'stirrup_leather': '',
                        'height': '',
                        'jodphur_size': '',
                        'is_vip_member': 0,
                        'award_points': 0,
                        'has_registered_on_website': false,
                    },
                    horse: {
                        'id': '',
                        'client_id': '',
                        'stable_name': '',
                        'breeding_name': '',
                        'paddock_address': '',
                        'postcode': '',
                        'suburb': '',
                        'state': '',
                        'breed': '',
                        'colour': '',
                        'height': '',
                        'weight': '',
                        'girth': '',
                        'age': 0,
                        'dob': '',
                        'discipline': '',
                        'sex': '',
                        'photo': '',
                        'microchip_number': '',
                    },
                    saddle: {
                        'id': 0,
                        'horse_id': 0,
                        'rider_id': 0,
                        'brand_id': 0,
                        'style_id': 0,
                        'name': '',
                        'price': '0.00',
                        'serial_number': '',
                        'size': '',
                        'type': '',
                        'gullet_size': '',
                        'panel_type': '',
                        'seat_style': '',
                        'purchased_at': '',
                        'warranty_period': '',
                        'girth': 0,
                        'leathers': 0,
                        'irons': 0,
                        'condition': '',
                        'saddle_balance': ''
                    },
	                drawing: {
                        'id': 0,
                        'filename': null,
                    },
                    field_data: {
                        'back_length': '',
                        'wither_template': '',
                        'wither_shape': '',
                        'back_type': '',
                        'shoulder': [],
                        'abdomen': 'Dropped',
                        'fat_cover': 0,
                        'muscling': 0,

                        'back_angle': '',
                        'point_of_hip_tuber_coxae': '',
                        'girth_position': '',

                        'muscle_wastage': [],
                        'soreness': [],
                        'reduced_flexibility': [],
                        'hair_changes': [],
                        'palation_findings': [],

                        'foot_problems': [],
                        'feet_length': '',
                        'heel_balance': '',
                        'foot_balance': '',
                        'shoeing_status': '',

                        'movement_when_saddled': [],
                        'movement_when_saddled_no_rider': [],
                        'movement_when_ridden': [],

                        'saddle_balance': '',
                        'pommel_clearance': '',
                        'saddle_length': '',
                        'tree_match_at_wither': '',
                        'tree_match_at_arc_of_spine': '',
                        'channel_depth': '',
                        'channel_width': '',
                        'saddle_tilt': false,
                        'saddle_twist': false,
                        'contours_of_panel': ' ',
                        'girth_point_angle': '',
                        'girth_point_position': '',
                        'girth_type': '',
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
                    }
                },
                rules: {},
                brands: [],
                styles: [],
                breeds: [],

                // Option field datas
                selectOptions: {
                    colors: [
                        'bay',
                        'dark bay',
                        'blood bay',
                        'brown bay',
                        'Chestnut',
                        'liver chestnut',
                        'sorrel chestnut',
                        'blond or light chestnut',
                        'Grey',
                        'steel grey',
                        'dapple grey',
                        'fleabitten grey',
                        'rose grey',
                        'black',
                        'brindle',
                        'buckskin',
                        'champagne',
                        'cream dilution',
                        'cremello',
                        'dun',
                        'blue dun (grullo, grulla)',
                        'red dun',
                        'bay dun',
                        'buckskin dun',
                        'leopard',
                        'palomino',
                        'pinto',
                        'piepald',
                        'skewbald',
                        'overo',
                        'sabino',
                        'tobiano',
                        'tovero',
                        'rabicano',
                        'roan',
                        'red roan',
                        'bay roan',
                        'blue roan',
                        'dapple',
                        'black',
                        'cream',
                        'whiteblood bay',
                        'brown bay',
                        'chestnut',
                        'liver chestnut',
                        'sorrel chestnut',
                        'blond or light chestnut',
                        'Grey',
                        'steel grey',
                        'dapple grey',
                        'fleabitten grey',
                        'rose grey',
                        'black',
                        'brindle',
                        'buckskin',
                        'champagne',
                        'cream dilution',
                        'cremello',
                        'dun',
                        'blue dun (grullo, grulla)',
                        'red dun',
                        'bay dun',
                        'buckskin dun',
                        'leopard',
                        'palomino',
                        'pinto',
                        'piepald',
                        'skewbald',
                        'overo',
                        'sabino',
                        'tobiano',
                        'tovero',
                        'rabicano',
                        'roan',
                        'red roan',
                        'bay roan',
                        'blue roan',
                        'dapple',
                        'black',
                        'cream',
                        'white',
                    ],
                    sexes: [
                        'Stallion',
                        'Mare',
                        'Gelding',
                    ],
                    back_length: ['Short', 'Average', 'Long'],
                    wither_height: ['High', 'Standard', 'Low'],
                    back_type: ['Sway Back', 'Roach', 'Curved', 'Side', 'Flat', 'Rafter'],
                    shoulder: ['Left Higher', 'Right Higher', 'Left Flatter', 'Right Flatter', 'Left Bigger', 'Right Bigger'],
                    abdomen: ['Dropped', 'Neutral', 'Sloped'],
                    back_angle: ['Uphill/High Wither', 'Downhill/Croup High'],
                    point_of_hip_tuber_coxae: ['Lower on left', 'Lower on right'],
                    girth_position: ['Forward', 'Straight'],
                    muscle_wastage: ['Central left', 'Central right', 'Back left', 'Back right', 'Wither', 'Shoulders'],
                    soreness: ['Wither', 'Under waist of saddle', 'Under saddle cantle', 'Behind saddle'],
                    reduced_flexibility: ['Up and down', 'To left', 'To right', 'Croup Tuck'],
                    hair_changes: ['White hair', 'Broken hair', 'Curly hair', 'Dry spots'],
                    palation_findings: ['Heat', 'Muscle tense', 'Muscle in spasms', 'Rubs & gals'],
                    foot_problems: ['Lameness', 'Infections', 'Damage', 'Pain'],
                    feet_length: ['Short', 'Average', 'Long'],
                    heel_balance: ['High heel', 'Low heel'],
                    foot_balance: ['NF', 'OF', 'NH', 'OH'],
                    shoeing_status: ['Bare foot', 'All 4 feet shod', 'Front feet shod', 'Back feet shod', 'Special/corrective shoeing'],
                    movement_when_saddled: ['Tenderness/ discomfort when brushed', 'Dips back when rider mounts', 'Turns head /bites /cow kicks when saddled', 'Tail swishing/ head tossing', 'Cold backed when mounted', 'Bucks/ goes down when saddled', 'When Ridden'],
                    movement_when_saddled_no_rider: ['Saddle moves excessively', 'Saddle moves symmetrically'],
                    movement_when_ridden: ['Hollows back', 'Resistance', 'Bucking', 'Rearing', 'Retricted movement'],
                    saddle_type: ['All Purpose', 'Dressage', 'Endurance', 'Eventing', 'Icelandic', 'Jump', 'Pony', 'Show', 'Special', 'Stock', 'Trekking', 'Western'],
                    gullet_size: ['n', 'nm. m', 'mw.w.xw.wxw.xww.xxw'],
                    panel_type: ['Flock', 'Cair', 'Flair', 'Foam', 'Felt', 'Latex'],
                    seat_style: ['Deep seat', 'Standard', 'Flat seat'],
                    saddle_balance: ['Horizontal seat', 'Uphill', 'Downhill'],
                    pommel_clearance: ['Mounted', 'Un-Mounted', 'Girthed', 'Not girthed'],
                    saddle_length: ['Short', 'Adequate', 'Long'],
                    tree_match_at_wither: ['Parallel to wither', 'Narrow', 'Wide'],
                    tree_match_at_arc_of_spine: ['Bridging', 'Adequate', 'Rocking'],
                    channel_depth: ['Shallow', 'Adequate', 'Narrow'],
                    channel_width: ['Wide', 'Adequate', 'Narrow'],
                    contours_of_panel: ['Matched to central', 'To outer pitch', 'Not matched'],
                    girth_point_angle: ['Straight', 'Slightly forward', 'Forward'],
                    girth_point_position: ['Point strap and 1', 'Point strap and 2', 'Point strap and 3', '1 and 2', '1 and 3', '2 and 3'],
                    girth_type: ['Shaped', 'Straight', 'Stud', 'Corrective'],
                    drops_to: ['Neither', 'Left', 'Right'],
                    sits_off_centre: ['Neither', 'Left', 'Right'],
                    discipline: [],
                }
            }
        },
        methods: {
            // Get all data.
            getData() {
                this.myAxios.get(this.fitchecksResourceUrl + '/' + this.$route.params.id)
                    .then((response) => {
                        this.data = response.data;
                        this.data.field_data.rider_id = this.data.rider.id;
                        if (typeof(this.data.rider.has_registered_on_website) != 'boolean') {
                            this.data.rider.has_registered_on_website = Boolean(Number.parseInt(this.data.rider.has_registered_on_website));
                        }
                        this.data.field_data.horse_id = this.data.horse.id;
                        this.data.field_data.saddle_id = this.data.saddle.id;

                        this.data.field_data.fat_cover = Number.parseInt(this.data.field_data.fat_cover);
                        this.data.field_data.muscling = Number.parseInt(this.data.field_data.muscling);
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });

                this.myAxios.get(this.brandsResourceUrl)
                    .then((res) => {
                        this.brands = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });

                this.myAxios.get(this.breedsResourceUrl)
                    .then((res) => {
                        this.breeds = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });

                this.myAxios.get(this.disciplinesResourceUrl)
                    .then((res) => {
                        this.selectOptions.discipline = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
            },
        },
        mounted() {
            // Get Data from back-end
            this.getData();
        },
    }
</script>

<style lang="scss" scoped>
    .el-input-number, .el-select, .el-date-editor {
        width: 100% !important;
    }

    .el-checkbox-button.is-checked .el-checkbox-button__inner {
        color: #fff !important;
        background-color: #20a0ff !important;
        border-color: #20a0ff !important;
        box-shadow: -1px 0 0 0 #20a0ff !important;
    }

    .el-checkbox__input.is-disabled + .el-checkbox__label {
        color: #1f2d3d !important;
    }

    .el-checkbox__input.is-disabled.is-checked .el-checkbox__inner {
        background-color: #20a0ff !important;
        border-color: #0190fe !important;
    }

    .input-group .el-input input {
        border-radius: 4px 0 0 4px;
    }

    .input-group .input-group-addon {
        background-color: #d1dbe5;
    }

    .small-link {
        font-size: 0.7em;
        margin-left: 10px;
    }

    #drawing-uploaded {
        font-size: 14px;
        font-weight: bold;
    }
    #drawing-uploaded div {
        display: inline-block;
    }
    #drawing-uploaded label {
        width: 120px;
        text-align: right;
        vertical-align: top;
        padding: 11px 12px 11px 0;
    }
    #drawing-uploaded .preview-image {
        width: 13em;
        height: 13em;
    }
    #drawing-uploaded .preview-image img {
        max-width: 13em;
        max-height: 13em;
    }
</style>