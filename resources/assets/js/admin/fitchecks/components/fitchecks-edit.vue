<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Fit Check: {{ data.horse.stable_name }}</h5>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <!--big step bar-->
            <div class="row text-center m-b">
                <el-steps :space="100" :active="currentStep" finishStatus="success" direction="horizontal">
                    <el-step title="1. Rider"></el-step>
                    <el-step title="2. Horse"></el-step>
                    <el-step title="3. Saddle"></el-step>
                    <el-step title="4. Complete"></el-step>
                </el-steps>
            </div>
            <!--big step bar end-->
            <div class="row">
                <!--step 0 Rider -->
                <div class="col-md-12" v-show="currentStep==0">
                    <el-form ref="step0" labelWidth="120px" :model="data.rider" :rules="rules.data.rider">

                        <el-row>
                            <el-col :sm="{span:24}" :md="{span:12}">
                                <el-form-item label="First Name" prop="first_name">
                                    <el-input v-model="data.rider.first_name"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :sm="{span:24}" :md="{span:12}">
                                <el-form-item label="Last Name" prop="last_name">
                                    <el-input v-model="data.rider.last_name"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-form-item label="Address" prop="address">
                            <el-input v-model="data.rider.address"></el-input>
                        </el-form-item>

                        <el-row>
                            <el-col :sm="{span:24}" :md="{span:8}">
                                <el-form-item label="Suburb" prop="suburb">
                                    <el-input v-model="data.rider.suburb"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :sm="{span:24}" :md="{span:8}">
                                <el-form-item label="State" prop="state">
                                    <el-select v-model="data.rider.state" placeholder="Select State">
                                        <el-option label="Select State" value="" :disabled="true"></el-option>
                                        <el-option v-for="val in states"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <el-col :sm="{span:24}" :md="{span:8}">
                                <el-form-item label="Post Code" prop="postcode">
                                    <el-input v-model="data.rider.postcode"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Mobile" prop="mobile">
                                    <el-input v-model="data.rider.mobile"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Email" prop="email">
                                    <el-input v-model="data.rider.email"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-form-item label="Discipline" prop="discipline">
                            <el-select v-model="data.rider.discipline" placeholder="Select Discipline">
                                <el-option v-for="val in selectOptions.discipline"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Stirrup Size" prop="stirrup_size">
                                    <el-input v-model="data.rider.stirrup_size"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Stirrup Leather Size" prop="stirrup_leather">
                                    <el-input v-model="data.rider.stirrup_leather"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Jodphur Size" prop="jodphur_size">
                                    <el-input v-model="data.rider.jodphur_size"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="" prop="has_registered_on_website">
                                    <el-checkbox v-model="data.rider.has_registered_on_website"
                                                 label="Signed up to Website?"></el-checkbox>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <div class="text-center">
                            <el-button type="primary" @click="gotoStep(1)">Next</el-button>
                        </div>

                    </el-form>
                </div>
                <!--step 0 Rider end -->
                <!--step 1 Horse -->
                <div class="col-md-12" v-show="currentStep==1">
                    <!--step bar-->
                    <div class="row text-center m-b">
                        <el-steps :space="100" :active="horseStep" direction="horizontal">
                            <el-step></el-step>
                            <el-step></el-step>
                            <el-step></el-step>
                            <el-step></el-step>
                            <el-step></el-step>
                            <el-step></el-step>
                        </el-steps>
                    </div>
                    <!--step bar end-->
                    <!--step 1_0 Horse details-->
                    <el-form v-show="horseStep==0" ref="step1_0" labelWidth="120px" :model="data.horse"
                             :rules="rules.data.horse">

                        <el-form-item label="Stable Name" prop="stable_name">
                            <el-input v-model="data.horse.stable_name"></el-input>
                        </el-form-item>

                        <el-row>
                            <el-col :sm="{span:24}" :md="{span:12}">
                                <el-form-item label="Breeding Name" prop="breeding_name">
                                    <el-input v-model="data.horse.breeding_name"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :sm="{span:24}" :md="{span:12}">
                                <el-form-item label="Breed" prop="breed">
                                    <el-select v-model="data.horse.breed" placeholder="Select Breed">
                                        <el-option label="Select Breed" value="" :disabled="true"></el-option>
                                        <el-option v-for="val in breeds"
                                                   :key="val.id"
                                                   :label="val.name"
                                                   :value="val.name"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Paddock Address" prop="paddock_address">
                                    <el-input v-model="data.horse.paddock_address"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :sm="{span:24}" :md="{span:12}">
                                <el-form-item label="State" prop="state">
                                    <el-select v-model="data.horse.state" placeholder="Select State">
                                        <el-option label="Select State" value="" :disabled="true"></el-option>
                                        <el-option v-for="val in states"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                        </el-row>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Post code" prop="postcode">
                                    <el-input v-model="data.horse.postcode"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Suburb" prop="suburb">
                                    <el-input v-model="data.horse.suburb"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-form-item label="Discipline" prop="discipline">
                            <el-select v-model="data.horse.discipline" placeholder="Select Discipline">
                                <el-option v-for="val in selectOptions.discipline"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Height" prop="height">
                                    <el-input-number v-model="data.horse.height"></el-input-number>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Weight" prop="weight">
                                    <el-input-number v-model="data.horse.weight"></el-input-number>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Girth Measurement" prop="girth">
                                    <el-input-number v-model="data.horse.girth"></el-input-number>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Color" prop="colour">
                                    <el-select v-model="data.horse.colour" placeholder="Select Color">
                                        <el-option v-for="val in selectOptions.colors"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Age" prop="age">
                                    <el-input-number v-model="data.horse.age"></el-input-number>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Date of Birth" prop="dob">
                                    <el-date-picker v-model="data.horse.dob" format="dd/MM/yyyy" type="date"
                                                    placeholder="Date of Birth"></el-date-picker>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Sex" prop="sex">
                                    <el-select v-model="data.horse.sex" placeholder="Select Sex">
                                        <el-option v-for="val in selectOptions.sexes"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Microchip Number" prop="microchip_number">
                                    <el-input v-model="data.horse.microchip_number"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <div class="text-center">
                            <el-button type="primary" @click="gotoHorseStep(-1)">Previous</el-button>
                            <el-button type="primary" @click="gotoHorseStep(1)">Next</el-button>
                        </div>

                    </el-form>
                    <!--step 1_0 Horse details end-->
                    <!--step 1_1 Back assessment-->
                    <el-form v-show="horseStep==1" ref="step1_1" labelWidth="120px" :model="data.field_data"
                             :rules="rules.data.field_data">

                        <el-form-item label="Back Length" prop="back_length">
                            <el-select v-model="data.field_data.back_length" placeholder="Select Back Length">
                                <el-option v-for="val in selectOptions.back_length"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Wither Template" prop="wither_template">
                            <el-input v-model="data.field_data.wither_template"
                                      placeholder="Enter Wither Template"></el-input>
                        </el-form-item>

                        <el-form-item label="Wither Shape" prop="wither_shape">
                            <el-input v-model="data.field_data.wither_shape"
                                      placeholder="Enter Wither Shape"></el-input>
                        </el-form-item>

                        <el-form-item label="Back Type" prop="back_type">
                            <el-select v-model="data.field_data.back_type" placeholder="Select Back Type">
                                <el-option v-for="val in selectOptions.back_type"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Shoulder" prop="shoulder">
                            <el-checkbox-group v-model="data.field_data.shoulder">
                                <el-checkbox v-for="val in selectOptions.shoulder"
                                             :label="val"
                                             :key="val">
                                    {{ val }}
                                </el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Abdomen" prop="abdomen">
                            <el-select v-model="data.field_data.abdomen" placeholder="Select Abdomen">
                                <el-option v-for="val in selectOptions.abdomen"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Fat Cover" prop="fat_cover">
                            <el-slider v-model="data.field_data.fat_cover" :step="1" :min="1" :max="6"></el-slider>
                        </el-form-item>

                        <el-form-item label="Muscling" prop="muscling">
                            <el-slider v-model="data.field_data.muscling" :step="1" :min="1" :max="6"></el-slider>
                        </el-form-item>

                        <div class="text-center">
                            <el-button type="primary" @click="gotoHorseStep(0)">Previous</el-button>
                            <el-button type="primary" @click="gotoHorseStep(2)">Next</el-button>
                        </div>

                    </el-form>
                    <!--step 1_1 Back assessment end-->
                    <!--step 1_2 Saddle Balance-->
                    <el-form v-show="horseStep==2" ref="step1_2" labelWidth="120px" :model="data.field_data"
                             :rules="rules.data.field_data">

                        <el-form-item label="Back Angle" prop="back_angle">
                            <el-select v-model="data.field_data.back_angle" placeholder="Select Back Angle">
                                <el-option v-for="val in selectOptions.back_angle"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Point of Hip/Tuber Coxae" prop="point_of_hip_tuber_coxae">
                            <el-select v-model="data.field_data.point_of_hip_tuber_coxae"
                                       placeholder="Select Point of Hip/Tuber coxae">
                                <el-option v-for="val in selectOptions.point_of_hip_tuber_coxae"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Girth Position" prop="girth_position">
                            <el-select v-model="data.field_data.girth_position" placeholder="Girth Position">
                                <el-option v-for="val in selectOptions.girth_position"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <div class="text-center">
                            <el-button type="primary" @click="gotoHorseStep(1)">Previous</el-button>
                            <el-button type="primary" @click="gotoHorseStep(3)">Next</el-button>
                        </div>

                    </el-form>
                    <!--step 1_2 Saddle Balance end-->
                    <!--step 1_3 Back Problems-->
                    <el-form v-show="horseStep==3" ref="step1_3" labelWidth="120px" :model="data.field_data"
                             :rules="rules.data.field_data">

                        <el-form-item label="Muscle Wastage" prop="muscle_wastage">
                            <el-checkbox-group v-model="data.field_data.muscle_wastage">
                                <el-checkbox-button v-for="val in selectOptions.muscle_wastage"
                                                    :label="val"
                                                    :key="val">
                                    {{ val }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Muscle Soreness" prop="soreness">
                            <el-checkbox-group v-model="data.field_data.soreness">
                                <el-checkbox-button v-for="val in selectOptions.soreness"
                                                    :label="val"
                                                    :key="val">
                                    {{ val }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Hair Changes" prop="hair_changes">
                            <el-checkbox-group v-model="data.field_data.hair_changes">
                                <el-checkbox-button v-for="val in selectOptions.hair_changes"
                                                    :label="val"
                                                    :key="val">
                                    {{ val }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Reduced Flexibility" prop="reduced_flexibility">
                            <el-checkbox-group v-model="data.field_data.reduced_flexibility">
                                <el-checkbox-button v-for="reduced_flexibility in selectOptions.reduced_flexibility"
                                                    :label="reduced_flexibility"
                                                    :key="reduced_flexibility">
                                    {{ reduced_flexibility }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Palation Findings" prop="palation_findings">
                            <el-checkbox-group v-model="data.field_data.palation_findings">
                                <el-checkbox-button v-for="val in selectOptions.palation_findings"
                                                    :label="val"
                                                    :key="val">
                                    {{ val }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <div class="text-center">
                            <el-button type="primary" @click="gotoHorseStep(2)">Previous</el-button>
                            <el-button type="primary" @click="gotoHorseStep(4)">Next</el-button>
                        </div>

                    </el-form>
                    <!--step 1_3 Back Problems end-->
                    <!--step 1_4 Feet Observations-->
                    <el-form v-show="horseStep==4" ref="step1_4" labelWidth="120px" :model="data.field_data"
                             :rules="rules.data.field_data">

                        <el-form-item label="Foot Problem" prop="foot_problems">
                            <el-checkbox-group v-model="data.field_data.foot_problems">
                                <el-checkbox v-for="val in selectOptions.foot_problems"
                                             :label="val"
                                             :key="val">
                                    {{ val }}
                                </el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Feet Length" prop="feet_length">
                            <el-select v-model="data.field_data.feet_length" placeholder="Select Feet Length">
                                <el-option v-for="val in selectOptions.feet_length"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Heel Balance" prop="heel_balance">
                            <el-select v-model="data.field_data.heel_balance" placeholder="Select Heel Balance">
                                <el-option v-for="val in selectOptions.heel_balance"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Foot Balance" prop="foot_balance">
                            <el-select v-model="data.field_data.foot_balance" placeholder="Select Foot Balance">
                                <el-option v-for="val in selectOptions.foot_balance"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Shoeing Status" prop="shoeing_status">
                            <el-select v-model="data.field_data.shoeing_status" placeholder="Select Shoeing Status">
                                <el-option v-for="val in selectOptions.shoeing_status"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <div class="text-center">
                            <el-button type="primary" @click="gotoHorseStep(3)">Previous</el-button>
                            <el-button type="primary" @click="gotoHorseStep(5)">Next</el-button>
                        </div>

                    </el-form>
                    <!--step 1_4 Feet Observations end-->
                    <!--step 1_5 Movement & Behaviour Observations-->
                    <el-form v-show="horseStep==5" ref="step1_5" labelWidth="120px" :model="data.field_data"
                             :rules="rules.data.field_data">

                        <el-form-item label="When Saddled" prop="movement_when_saddled">
                            <el-checkbox-group v-model="data.field_data.movement_when_saddled">
                                <el-checkbox-button v-for="val in selectOptions.movement_when_saddled"
                                                    :label="val"
                                                    :key="val">
                                    {{ val }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="Horse Saddled With No Rider" prop="movement_when_saddled_no_rider">
                            <el-checkbox-group v-model="data.field_data.movement_when_saddled_no_rider">
                                <el-checkbox-button
                                        v-for="val in selectOptions.movement_when_saddled_no_rider"
                                        :label="val"
                                        :key="val">
                                    {{ val }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-form-item label="When Ridden" prop="movement_when_ridden">
                            <el-checkbox-group v-model="data.field_data.movement_when_ridden">
                                <el-checkbox-button v-for="val in selectOptions.movement_when_ridden"
                                                    :label="val"
                                                    :key="val">
                                    {{ val }}
                                </el-checkbox-button>
                            </el-checkbox-group>
                        </el-form-item>

                        <div class="text-center">
                            <el-button type="primary" @click="gotoHorseStep(4)">Previous</el-button>
                            <el-button type="primary" @click="gotoHorseStep(6)">Next</el-button>
                        </div>

                    </el-form>
                    <!--step 1_5 Movement & Behaviour Observations end-->
                </div>
                <!--step 1 Horse end -->
                <!--step 2 Saddle -->
                <div class="col-md-12" v-show="currentStep==2">
                    <!--step bar-->
                    <div class="row text-center m-b">
                        <el-steps :space="100" :active="saddleStep" direction="horizontal">
                            <el-step></el-step>
                            <el-step></el-step>
                            <el-step></el-step>
                            <el-step></el-step>
                        </el-steps>
                    </div>
                    <!--step bar end-->
                    <!--step 2_0 Saddle Details-->
                    <el-form v-show="saddleStep==0" ref="step2_0" labelWidth="120px" :model="data.saddle"
                             :rules="rules.data.saddle">

                        <el-form-item label="Saddle Name" prop="name">
                            <el-input v-model="data.saddle.name"></el-input>
                        </el-form-item>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Saddle Brand" prop="brand_id">
                                    <el-select v-model="data.saddle.brand_id" placeholder="Select Saddle Brand"
                                               @change="onBrandChange()">
                                        <el-option v-for="val in brands"
                                                   :key="val.id"
                                                   :label="val.name"
                                                   :value="val.id"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Saddle Model" prop="style_id">
                                    <el-select v-model="data.saddle.style_id" placeholder="Select Saddle Model">
                                        <el-option label="Please select Saddle model" value=""></el-option>
                                        <el-option v-for="val in styles"
                                                   :key="val.id"
                                                   :label="val.name"
                                                   :value="val.id"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:8}">
                                <el-form-item label="Saddle Price Paid" prop="price">
                                    <el-input-number v-model="data.saddle.price"></el-input-number>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:8}">
                                <el-form-item label="Saddle Serial #" prop="serial_number">
                                    <el-input v-model="data.saddle.serial_number"></el-input>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:8}">
                                <el-form-item label="Saddle Size" prop="size">
                                    <el-input v-model="data.saddle.size"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Saddle Type" prop="type">
                                    <el-select v-model="data.saddle.type" placeholder="Select Saddle Type">
                                        <el-option label="Select Type" value=""></el-option>
                                        <el-option v-for="val in data.saddle.available_types"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Gullet Size" prop="gullet_size">
                                    <el-select v-model="data.saddle.gullet_size" placeholder="Select Gullet Size">
                                        <el-option label="Select Size" value=""></el-option>
                                        <el-option v-for="val in data.saddle.available_gullet_sizes"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Panel Type" prop="panel_type">
                                    <el-select v-model="data.saddle.panel_type" placeholder="Select Panel Type">
                                        <el-option v-for="val in data.saddle.available_panel_types"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Seat Style" prop="seat_style">
                                    <el-select v-model="data.saddle.seat_style" placeholder="Select Seat Style">
                                        <el-option v-for="val in data.saddle.available_seat_styles"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-form-item label="Date of Purchase" prop="purchased_at">
                            <el-date-picker v-model="data.saddle.purchased_at" format="dd/MM/yyyy" type="date"
                                            placeholder="Date of Purchase"></el-date-picker>
                        </el-form-item>

                        <el-form-item label="Warranty Period" prop="warranty_period">
                            <el-input-number v-model="data.saddle.warranty_period"></el-input-number>
                        </el-form-item>

                        <div class="text-center">
                            <el-button type="primary" @click="gotoSaddleStep(-1)">Previous</el-button>
                            <el-button type="primary" @click="gotoSaddleStep(1)">Next</el-button>
                        </div>

                    </el-form>
                    <!--step 2_0 Saddle Details end-->
                    <!--step 2_1 Saddle Fit-->
                    <el-form v-show="saddleStep==1" ref="step2_1" labelWidth="120px" :model="data.field_data"
                             :rules="rules.data.field_data">

                        <el-form-item label="Saddle Balance" prop="saddle_balance">
                            <el-select v-model="data.field_data.saddle_balance" placeholder="Select Saddle Balance">
                                <el-option v-for="val in selectOptions.saddle_balance"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Pummel Clearance" prop="pommel_clearance">
                            <el-select v-model="data.field_data.pommel_clearance" placeholder="Select Pummel Clearance">
                                <el-option v-for="val in selectOptions.pommel_clearance"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Saddle Length" prop="saddle_length">
                                    <el-select v-model="data.field_data.saddle_length"
                                               placeholder="Select Saddle Length">
                                        <el-option v-for="val in selectOptions.saddle_length"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Tree Match Wither" prop="tree_match_at_wither">
                                    <el-select v-model="data.field_data.tree_match_at_wither"
                                               placeholder="Select Tree Match Wither">
                                        <el-option v-for="val in selectOptions.tree_match_at_wither"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-form-item label="Tree Match with Arc of Spine" prop="tree_match_at_arc_of_spine">
                            <el-select v-model="data.field_data.tree_match_at_arc_of_spine"
                                       placeholder="Select Tree Match with Arc of Spine">
                                <el-option v-for="val in selectOptions.tree_match_at_arc_of_spine"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Channel Depth" prop="channel_depth">
                                    <el-select v-model="data.field_data.channel_depth"
                                               placeholder="Select Channel Depth">
                                        <el-option v-for="val in selectOptions.channel_depth"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Channel Width" prop="channel_width">
                                    <el-select v-model="data.field_data.channel_width"
                                               placeholder="Select Channel Width">
                                        <el-option v-for="val in selectOptions.channel_width"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-form-item label="" prop="saddle_tilt">
                            <el-checkbox v-model="data.field_data.saddle_tilt">
                                Does the saddle tilt to one side when viewed from rear?
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="" prop="saddle_twist">
                            <el-checkbox v-model="data.field_data.saddle_twist">
                                Does the saddle twist when viewed from side?
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="Contours of the Panel" prop="contours_of_panel">
                            <el-select v-model="data.field_data.contours_of_panel"
                                       placeholder="Select Contours of the Panel">
                                <el-option v-for="val in selectOptions.contours_of_panel"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Girth Point Angle" prop="girth_point_angle">
                                    <el-select v-model="data.field_data.girth_point_angle"
                                               placeholder="Select Girth Point Angle">
                                        <el-option v-for="val in selectOptions.girth_point_angle"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Girth Point Positions" prop="girth_point_position">
                                    <el-select v-model="data.field_data.girth_point_position"
                                               placeholder="Select Girth Point Positions">
                                        <el-option v-for="val in selectOptions.girth_point_position"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Girth Type" prop="girth_type">
                                    <el-select v-model="data.field_data.girth_type" placeholder="Select Girth Type">
                                        <el-option v-for="val in selectOptions.girth_type"
                                                   :key="val"
                                                   :label="val"
                                                   :value="val"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <el-col :xs="{span:24}" :sm="{span:12}">
                                <el-form-item label="Girth Size" prop="girth_size">
                                    <div class="input-group">
                                        <el-input-number v-model="data.field_data.girth_size">
                                        </el-input-number>
                                        <div class="input-group-addon measurement-switch">
                                            <el-radio-group v-model="measurement">
                                                <el-radio-button label="CM"></el-radio-button>
                                                <el-radio-button label="Inch"></el-radio-button>
                                            </el-radio-group>
                                        </div>
                                    </div>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <div class="text-center">
                            <el-button type="primary" @click="convertMesaureToCm(); gotoSaddleStep(0)">Previous</el-button>
                            <el-button type="primary" @click="convertMesaureToCm(); gotoSaddleStep(2)">Next</el-button>
                        </div>

                    </el-form>
                    <!--step 2_1 Saddle Fit end-->
                    <!--step 2_2 Rider In Saddle-->
                    <el-form v-show="saddleStep==2" ref="step2_2" labelWidth="120px" :model="data.field_data"
                             :rules="rules.data.field_data">

                        <el-form-item label="Drops Left/Right" prop="drops_to">
                            <el-select v-model="data.field_data.drops_to" placeholder="Select Drops Left/Right">
                                <el-option v-for="val in selectOptions.drops_to"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Sits Off Centre" prop="sits_off_centre">
                            <el-select v-model="data.field_data.sits_off_centre" placeholder="Select Sits Off Centre">
                                <el-option v-for="val in selectOptions.sits_off_centre"
                                           :key="val"
                                           :label="val"
                                           :value="val"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="" prop="sits_upright">
                            <el-checkbox v-model="data.field_data.sits_upright">
                                Sites Upright ?
                            </el-checkbox>
                        </el-form-item>

                        <div class="text-center">
                            <el-button type="primary" @click="gotoSaddleStep(1)">Previous</el-button>
                            <el-button type="primary" @click="gotoSaddleStep(3)">Next</el-button>
                        </div>

                    </el-form>
                    <!--step 2_2 Rider In Saddle end-->
                    <!--step 2_3 Rider In Saddle 2-->
                    <el-form v-show="saddleStep==3" ref="step2_3" labelWidth="120px" :model="data.field_data"
                             :rules="rules.data.field_data">

                        <el-form-item label="" prop="flocking_front">
                            <el-checkbox v-model="data.field_data.flocking_front">
                                Flocking Front
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="" prop="flocking_middle">
                            <el-checkbox v-model="data.field_data.flocking_middle">
                                Flocking Middle
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="" prop="flocking_back">
                            <el-checkbox v-model="data.field_data.flocking_back">
                                Flocking Back
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="Alteration" prop="alterations">
                            <div class="input-group"
                                 v-for="(item, index) in data.field_data.alterations"
                                 :key="index">
                                <input
                                        class="form-control" v-model="data.field_data.alterations[index]">
                                <span class="input-group-btn">
                                        <button
                                                class="btn btn-success" @click.prevent="onRemoveAlteration(index)"><i
                                                class="fa fa-trash"></i></button>
                                    </span>
                            </div>
                            <button class="btn btn-primary dim" @click.prevent="onAddAlteration"><i
                                    class="fa fa-plus"></i></button>
                        </el-form-item>

                        <el-form-item label="Alteration History" prop="history_of_alterations">
                            <div class="input-group"
                                 v-for="(item, index) in data.field_data.history_of_alterations"
                                 :key="index">
                                <input
                                        class="form-control" v-model="data.field_data.history_of_alterations[index]">
                                <span class="input-group-btn">
                                        <button
                                                class="btn btn-success"
                                                @click.prevent="onRemoveAlterationHistory(index)"><i
                                                class="fa fa-trash"></i></button>
                                    </span>
                            </div>
                            <button class="btn btn-primary dim" @click.prevent="onAddAlterationHistory"><i
                                    class="fa fa-plus"></i></button>
                        </el-form-item>

                        <el-form-item label="Recommended Products" prop="recommended_products">
                            <div class="input-group"
                                 v-for="(item, index) in data.field_data.recommended_products"
                                 :key="index">
                                <input
                                        class="form-control" v-model="data.field_data.recommended_products[index]">
                                <span class="input-group-btn">
                                        <button
                                                class="btn btn-success"
                                                @click.prevent="onRemoveRecommendedProducts(index)"><i
                                                class="fa fa-trash"></i></button>
                                    </span>
                            </div>
                            <button class="btn btn-primary dim" @click.prevent="onAddRecommendedProducts"><i
                                    class="fa fa-plus"></i></button>
                        </el-form-item>

                        <div class="text-center">
                            <el-button type="primary" @click="gotoSaddleStep(2)">Previous</el-button>
                            <el-button type="primary" @click="gotoSaddleStep(4)">Next</el-button>
                        </div>

                    </el-form>
                    <!--step 2_3 Rider In Saddle 2 end-->
                </div>
                <!--step 2 Saddle End-->
                <!--step 3 Drawing-->
                <div class="col-md-12" v-show="currentStep==3">
					<el-form ref="step3_0" labelWidth="120px" :model="data.drawing">
                        <div class="step-3-instruction">
                            <p>Instructions:</p>
                            <p>Wither Template:</p>
                            <ol>
                                <li>Using flexi curve, take impression of horses wider 2 fingers behind shoulder.</li>
                                <li>Trace the inside of the curve on an A4 Paper.</li>
                                <li>Using flexi curve, take impression of horses back at the last rib.</li>
                                <li>Trace the inside of the curve on the same A4 paper.</li>
                                <li>Ensure that the drawing is clean and clear.</li>
                            </ol>
                            <p>Note: Scan the A4 Paper Drawing without adjusting or changing the dimensions while scanning. Have it ready to upload in the next step.</p>

                            <el-form-item>
                                <el-checkbox v-model="step_3_agree_tc" label="I Agree" border></el-checkbox>
                            </el-form-item>

                            <el-row id="drawing-uploaded" v-if="data.drawing.filename">
                                <el-col :span="24">
                                    <el-card :body-style="{ padding: '0px' }">
                                        <div style="padding: 14px;">
                                            <span>Uploaded Drawing</span>
                                        </div>
                                        <div class="text-center"><img :src="'/drawings/'+data.drawing.id" class="image"></div>
                                        <div class="text-center">
                                            <el-button type="primary" @click="gotoDrawingStep(1)"
                                                style="margin-bottom: 1em;">Change Drawing</el-button>
                                        </div>
                                    </el-card>
                                </el-col>
                            </el-row>


                            <div v-if="data.drawing.filename" class="text-center">
                                <el-button type="primary" @click="gotoDrawingStep(-1)">Previous</el-button>
                                <el-button type="primary" @click="gotoDrawingStep(2)">Next</el-button>
                            </div>
                            <div v-else class="text-center">
                                <el-button type="primary" @click="gotoDrawingStep(-1)">Previous</el-button>
                                <el-button type="primary" @click="gotoDrawingStep(3)">Skip & Save Draft</el-button>
                                <el-button type="primary" @click="gotoDrawingStep(1)">Next</el-button>
                            </div>
                        </div>

                        <div id="upload-drawing" class="modal fade">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Upload Drawing</h5>
                                    </div>
                                    <div class="modal-body">
                                        <input id="drawing-uploader" type="file" v-on:change="onFileChange" class="form-control"
                                                :model="data.drawing.filename">
                                        <div id="drawing-preview">
                                            <img :src="preview_image" class="img-responsive" />
                                        </div>
                                        Accepted Image Types: .JPEG, .JPG, or .PNG.
                                    </div>
                                    <div class="modal-footer">
                                        <button id="btn-upload-drawing" type="button" class="btn btn-primary" @click="gotoDrawingStep(2)" disabled>Upload</button>
                                        <button type="button" class="btn btn-primary" @click="gotoDrawingStep(3)">Skip & Save Draft</button>
                                        <button type="button" class="btn btn-primary" @click="resetDrawing">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

					</el-form>
                </div>
                <!--step 3 Drawing End-->
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
                currentStep: 0,
                horseStep: 0,
                saddleStep: 0,
	            drawingStep: 0,
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
                },
	            measurement: 'CM',
                preview_image: null,
                step_3_agree_tc: false,
            }
        },
        methods: {
            // Alternation, Alternation history tag input methods.
            onAddAlteration() {
                this.data.field_data.alterations.push('');
            },
            onRemoveAlteration(index) {
                this.data.field_data.alterations.splice(index, 1);
            },

            onAddAlterationHistory() {
                this.data.field_data.history_of_alterations.push('');
            },
            onRemoveAlterationHistory(index) {
                this.data.field_data.history_of_alterations.splice(index, 1);
            },

            onAddRecommendedProducts() {
                this.data.field_data.recommended_products.push('');
            },
            onRemoveRecommendedProducts(index) {
                this.data.field_data.recommended_products.splice(index, 1);
            },

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

                        if (!this.data.drawing) {
                        	this.data.drawing = {
		                        id: 0,
                        		filename: null,
                            }
                        }

                        // Check if the drawing is already uploaded, then the T&C should be agreed previously
	                    this.step_3_agree_tc = (this.data.drawing.filename != null) && (this.data.drawing.filename.length > 0);

                        // Go to step
                        this.gotoStep(this.currentStep);
                        this.gotoHorseStep(this.horseStep);
                        this.gotoSaddleStep(this.saddleStep);
	                    this.gotoDrawingStep(0);
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
            // These are called by [next] buttons. check if it is okay to go to next step.
            gotoStep(step) {
                switch (step) {
                    case 0:
                        // Get Rider details, display.
                        this.currentStep = 0;
                        break;
                    case 1:
                        // Save Rider details, if success, go to step 1
                        this.myAxios.put(this.ridersResourceUrl + '/' + this.data.rider.id, this.data.rider)
                            .then((res) => {
                                this.currentStep = 1;
                                this.displayErrors();
                            })
                            .catch((err) => {
                                console.log(err);
                                this.displayErrors(err);
                                this.showErrorNotify(err);
                            });
                        break;
                    case 2:
                        // Comes from gotoHorsestep, Opens Saddle setup. Do not call this. call gotoHorseStep(6) instead.
                        this.currentStep = 2;
                        break;
                    case 3:
                        this.currentStep = 3;
                        break;
                    case 4:
		                this.$router.push({ name: 'fitchecks-view', params: { id: this.$route.params.id } });
		                break;
                }
            },
            gotoHorseStep(step) {
                switch (step) {
	                case -1:
		                // Back to previous step
		                this.horseStep = 0;
		                this.gotoStep(0);
		                break;
                    case 0:
                        // Get Horse details, display.
                        this.horseStep = 0;
                        break;
                    case 1:
                        // Save Horse details, if success, go to horse step 1
                        // Clone horse object to make date redable by back-end
                        let horseObj = _.cloneDeep(this.data.horse);
                        horseObj.dob = Moment(horseObj.dob).utc().format('DD/MM/YYYY');
                        this.myAxios.put(this.horsesResourceUrl + '/' + horseObj.id, horseObj)
                            .then((res) => {
                                this.horseStep = 1;
                                this.displayErrors();
                            })
                            .catch((err) => {
                                console.log(err);
                                this.displayErrors(err);
                                this.showErrorNotify(err);
                            });
                        break;
                    default: // 2, 3, 4, 5, 6
                        // Save fitcheck data, if success, go to next horse step
                        this.myAxios.put(this.fitchecksResourceUrl + '/' + this.$route.params.id, this.data.field_data)
                            .then((res) => {
                                if (step === 6) {
                                    // Step 6 is dummy state of big step 2
                                    this.horseStep = 0;
                                    this.gotoStep(2);
                                } else {
                                    this.horseStep = step;
                                }
                                this.displayErrors();
                            })
                            .catch((err) => {
                                console.log(err);
                                this.displayErrors(err);
                                this.showErrorNotify(err);
                            });
                        break;
                }
            },
            gotoSaddleStep(step) {
                switch (step) {
	                case -1:
		                // Back to previous step
		                this.horseStep = 5;
		                this.saddleStep = 0;
		                this.gotoStep(1);
		                break;
                    case 0:
                        // Display Saddle details
                        this.saddleStep = 0;
                        break;
                    case 1:
                        // Save Saddle details, if success, go to saddle step 1
                        // Clone Saddle object to make date redable by back-end
                        let saddleObj = _.cloneDeep(this.data.saddle);
                        saddleObj.purchased_at = Moment(saddleObj.purchased_at).utc().format('DD/MM/YYYY');
                        this.myAxios.put(this.saddlesResourceUrl + '/' + saddleObj.id, saddleObj)
                            .then((res) => {
                                this.saddleStep = 1;
                                this.displayErrors();
                            })
                            .catch((err) => {
                                console.log(err);
                                this.displayErrors(err);
                                this.showErrorNotify(err);
                            });
                        break;
                    default: // 2, 3, 4
                        // Save fitcheck data, if success, go to next horse step
                        this.myAxios.put(this.fitchecksResourceUrl + '/' + this.$route.params.id, this.data.field_data)
                            .then((res) => {
                                if (step === 4) {
                                    // Step 4 is dummy state of big step 3
                                    this.saddleStep = 0;
                                    this.gotoStep(3);
                                } else {
                                    this.saddleStep = step;
                                }
                                this.displayErrors();
                            })
                            .catch((err) => {
                                console.log(err);
                                this.displayErrors(err);
                                this.showErrorNotify(err);
                            });
                        break;
                }
            },
	        gotoDrawingStep: function (step) {
		        switch (step) {
			        case -1:
			        	// Back to previous step
				        this.saddleStep = 3;
				        this.drawingStep = 0;
				        this.gotoStep(2);
				        break;
			        case 0:
				        // Display drawing details, nothing to do
				        break;
			        case 1:
				        if (this.step_3_agree_tc) {
					        $('#upload-drawing').modal();
				        } else {
					        this.$notify({
						        type: 'warning',
						        title: 'Warning',
						        message: 'Please agree the instruction',
					        });
				        }
				        break;
			        case 2:
				        $('#upload-drawing').modal('hide');
			        	// Upload the drawing and finish the fit check
				        var data = new FormData();
				        data.append('image', $("#drawing-uploader")[0].files[0]);

				        // Only upload if the image has been selected in the modal
				        if (this.preview_image) {
					        this.myAxios.post(this.drawingsResourceUrl + '/' + this.$route.params.id, data)
						        .then((res) => {
							        if (res.data.success) {
								        this.gotoStep(4);
								        this.displayErrors();
							        } else {
								        this.$notify({
									        type: 'Error',
									        title: 'Error',
									        message: 'Error on uploading image. Please try again.',
								        });
							        }
						        })
						        .catch((err) => {
							        console.log(err);
							        $('.modal-backdrop').removeClass('in');
							        this.displayErrors(err);
							        this.showErrorNotify(err);
						        });
				        } else {
					        this.gotoStep(4);
                        }
				        break;
			        case 3: // Skip the drawing upload and return to view
			        	this.gotoStep(4);
				        break;
                    default: break;
		        }
	        },
            onBrandChange() {
                this.myAxios.get(this.brandsResourceUrl + '/' + this.data.saddle.brand_id)
                    .then((res) => {
                        this.styles = res.data.styles;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
            },
            updateRoute() {
                // This only updates url display, but does not refresh the page.
                this.$router.push({
                    path: this.$route.path,
                    query: {
                        currentStep: this.currentStep,
                        horseStep: this.horseStep,
                        saddleStep: this.saddleStep,
	                    drawingStep: this.drawingStep,
                    }
                });
            },
            displayErrors(errors = null) {
                if (errors) {
                    this.errors.put(errors.response.data);
                } else {
                    this.errors.clearAll();
                }
                this.$refs.step0.validate();
                this.$refs.step1_0.validate();
                this.$refs.step1_1.validate();
                this.$refs.step1_2.validate();
                this.$refs.step1_3.validate();
                this.$refs.step1_4.validate();
                this.$refs.step1_5.validate();
                this.$refs.step2_0.validate();
                this.$refs.step2_1.validate();
                this.$refs.step2_2.validate();
                this.$refs.step2_3.validate();
	            this.$refs.step3_0.validate();
            },
            convertMesaureToCm() {
	            if (this.measurement == 'Inch') {
		            this.measurement = 'CM';
	            }
            },
	        onFileChange(e) {
		        let files = e.target.files || e.dataTransfer.files;
		        if (!files.length)
			        return;
		        this.createImage(files[0]);
		        $("#drawing-uploader").hide();
		        $("#drawing-preview").show();

		        if (($("#drawing-uploader")[0].files.length > 0)) {
			        $('#btn-upload-drawing').prop('disabled', false);
		        } else {
			        $('#btn-upload-drawing').prop('disabled', true);
		        }
	        },
	        createImage(file) {
		        let reader = new FileReader();
		        let vm = this;
		        reader.onload = (e) => {
			        vm.preview_image = e.target.result;
		        };
		        reader.readAsDataURL(file);
	        },
            resetDrawing() {
	            $("#drawing-uploader").val('');
	            this.preview_image = null;
	            $("#drawing-preview").hide();
	            $("#drawing-uploader").show();
	            $('#upload-drawing').modal('hide');
	            $('#btn-upload-drawing').prop('disabled', true);
            }
        },
        created() {
            // Init rule object
            // Rules for rider
            var checkError = (rule, value, callback) => {
                if (this.errors.has(rule.field)) {
                    return callback(new Error(this.errors.get(rule.field)));
                } else {
                    callback();
                }
            };
            this.rules.data = {
                rider: {},
                horse: {},
	            saddle: {},
	            drawing: {},
                field_data: {},
            };
            _.forEach(this.rules.data, (val1, key1) => {
                _.forEach(this.data[key1], (val2, key2) => {
                    this.rules.data[key1][key2] = [{ validator: checkError }];
                });
            });
        },
        mounted() {

            // Get entered step query
            this.currentStep = this.$route.query.currentStep ? Number.parseInt(this.$route.query.currentStep) : 0;
            this.horseStep = this.$route.query.horseStep ? Number.parseInt(this.$route.query.horseStep) : 0;
            this.saddleStep = this.$route.query.saddleStep ? Number.parseInt(this.$route.query.saddleStep) : 0;

            // Get Data from back-end
            this.getData();
        },
        watch: {
            // Change Route when next button is pressed.
            currentStep(to, from) {
                if (to != from) {
                    this.updateRoute();
                }
            },
            horseStep(to, from) {
                if (to != from) {
                    this.updateRoute();
                }
            },
            saddleStep(to, from) {
                if (to != from) {
                    this.updateRoute();
                }
            },
	        drawingStep(to, from) {
		        if (to != from) {
			        this.updateRoute();
		        }
	        },
            '$route'(to, from) {
                if (to.query.currentStep != this.currentStep) {
                    this.currentStep = to.query.currentStep ? to.query.currentStep : 0;
                    this.gotoStep(this.currentStep);
                }
                if (to.query.horseStep != this.horseStep) {
                    this.horseStep = to.query.horseStep ? to.query.horseStep : 0;
                    this.gotoHorseStep(this.horseStep);
                }
                if (to.query.saddleStep != this.saddleStep) {
                    this.saddleStep = to.query.saddleStep ? to.query.saddleStep : 0;
                    this.gotoSaddleStep(this.saddleStep);
                }
            },
            measurement: function() {
            	if (this.measurement == 'Inch') {
            		this.data.field_data.girth_size = Math.round(this.data.field_data.girth_size / 2.54 * 100) / 100;
                } else {
		            this.data.field_data.girth_size = Math.round(this.data.field_data.girth_size * 2.54 * 100) / 100;
                }
            },
        }
    }
</script>

<style lang="scss" scoped>
    .el-input-number, .el-select, .el-date-editor {
        width: 100% !important;
    }
    .input-group-addon.measurement-switch {
        padding: 0 0 0 5px;
        border: 0;
    }
    .step-3-instruction {
        margin: 0 auto;
        text-align: left;
        font-size: 14px;
        font-weight: bold;
    }
    .modal-dialog {
        max-width: 330px;
    }
    #drawing-uploader {
        position: relative;
        height: 13em;
        width: 13em;
        margin: 0 auto;
        visibility: hidden;
    }
    #drawing-uploader:before {
        visibility: visible;
        content: '+';
        color: #EEEEEE;
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        font-size: 13em;
        cursor: pointer;
        line-height: 0.925em;
        text-align: center;
        position: absolute;
        display: block;
        height: 1em;
        width: 1em;
        background-color: #fff;
        top: 0;
        left: 0;
    }
    #drawing-uploader:hover:before {
        color: #1bb394;
        border: 1px dashed #1bb394;
    }
    #drawing-preview {
        display: none;
        position: relative;
        height: 13em;
        width: 13em;
        margin: 0.325em auto;
        overflow: hidden;
        border: 1px solid #d9d9d9;
        border-radius: 6px;
    }
    #drawing-preview img {
        color: #EEEEEE;
        cursor: pointer;
        line-height: 0.925em;
        text-align: center;
        background-color: #fff;
        top: 0;
        left: 0;
    }
    #drawing-uploaded {
        margin-bottom: 2em;
    }
    #drawing-uploaded img {
        max-width: 18em;
        max-height: 15em;
        margin-bottom: 1em;
    }

</style>