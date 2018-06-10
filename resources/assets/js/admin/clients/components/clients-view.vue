<template>
    <div class="client-information">
        <div class="row" v-loading="XHRCount">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Details of Client: {{ data.client.name }}</h5>
                        <div class="ibox-tools">
                            <a href="javascript:history.back()" class="btn btn-xs btn-default">Back</a>
                            <router-link :to="{ name: 'clients-edit', params: { id: data.client.id } }"
                                         class="btn btn-primary btn-xs">Edit
                            </router-link>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            <div class="form-group">

                                <label class="col-md-2 control-label">Name :</label>
                                <div class="col-md-4">
                                    <p class="form-control-static"> {{ data.client.name }}</p>
                                </div>

                                <label class="col-md-2 control-label">Email:</label>
                                <div class="col-md-4">
                                    <p class="form-control-static"> {{ data.client.email }}</p>
                                </div>

                                <label class="col-md-2 control-label">Address :</label>
                                <div class="col-md-4">
                                    <p class="form-control-static"> {{ data.client.address }}</p>
                                </div>

                                <label class="col-md-2 control-label">Post Code:</label>
                                <div class="col-md-4">
                                    <p class="form-control-static"> {{ data.client.postcode }}</p>
                                </div>

                                <label class="col-md-2 control-label">Suburb :</label>
                                <div class="col-md-4">
                                    <p class="form-control-static"> {{ data.client.suburb }}</p>
                                </div>

                                <label class="col-md-2 control-label">State:</label>
                                <div class="col-md-4">
                                    <p class="form-control-static"> {{ data.client.state }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Manage Riders</h5>
                        <div class="ibox-tools">
                            <a :href="'/admin/riders#/create?client_id='+this.$route.params.id" class="btn btn-primary btn-xs">Create Rider</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table_body">
                                    <tr v-for="rider in riders">
                                        <td>{{ rider.first_name + ' ' + rider.last_name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown"
                                                        class="btn btn-default btn-xs dropdown-toggle">
                                                    Action
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a :href="'/admin/riders#/edit/' + rider.id">Edit</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="#" @click.prevent="onDeleteRider(rider.id)">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Manage Horses</h5>
                        <div class="ibox-tools">
                            <a :href="'/admin/horses#/create?client_id='+this.$route.params.id" class="btn btn-primary btn-xs">Create Horse</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Stable Name</th>
                                        <th>Breed</th>
                                        <th>Colour</th>
                                        <th>Discipline</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table_body">
                                    <tr v-for="horse in horses">
                                        <td>{{ horse.stable_name }}</td>
                                        <td>Unknown</td>
                                        <td>{{ horse.colour }}</td>
                                        <td>{{ horse.discipline }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown"
                                                        class="btn btn-default btn-xs dropdown-toggle">
                                                    Action
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a :href="'/admin/horses#/edit/' + horse.id">Edit</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="#" @click.prevent="onDeleteHorse(horse.id)">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Manage Saddles</h5>
                        <div class="ibox-tools">
                            <a :href="'/admin/saddles#/create/?client_id='+this.$route.params.id" class="btn btn-primary btn-xs">Create Saddle</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Serial Number</th>
                                        <th>Rider</th>
                                        <th>Horse</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table_body">
                                    <tr v-for="saddle in saddles">
                                        <td>{{ saddle.brand_name}}</td>
                                        <td>{{ saddle.model }}</td>
                                        <td>{{ saddle.serial_number }}</td>
                                        <td>{{ saddle.rider }}</td>
                                        <td>{{ saddle.horse_name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown"
                                                        class="btn btn-default btn-xs dropdown-toggle">
                                                    Action
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a :href="'/admin/saddles#/edit/' + saddle.id">Edit</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="#"
                                                           @click.prevent="onDeleteSaddle(saddle.id)">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Manage Users</h5>
                        <div class="ibox-tools">
                            <a href="#" @click.prevent="onInviteUser()" class="btn btn-primary btn-xs">Invite User</a>
                            <a href="#" @click.prevent="onCreateUser()" class="btn btn-primary btn-xs">Create User</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table_body">
                                    <tr v-for="user in users">
                                        <td>{{ user.first_name + ' ' + user.last_name}}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.status }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown"
                                                        class="btn btn-default btn-xs dropdown-toggle">
                                                    Action
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" @click.prevent="onEditUser(user.id)">Edit</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="#" @click.prevent="onDeleteUser(user.id)">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Invite element dialog -->
        <el-dialog title="Invite User" :visible.sync="isInviteUserDlgVisible" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form :model="inviteUserData" :rules="inviteUserDataRules" ref="formInviteUser">
                <el-form-item label="First name" prop="first_name">
                    <el-input v-model="inviteUserData.first_name"></el-input>
                </el-form-item>

                <el-form-item label="Last name" prop="last_name">
                    <el-input v-model="inviteUserData.last_name"></el-input>
                </el-form-item>

                <el-form-item label="Email" prop="email">
                    <el-input v-model="inviteUserData.email"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="isInviteUserDlgVisible = false">Cancel</el-button>
                <el-button type="primary" @click="postInviteUser()" :loading="isInXHR">Invite</el-button>
            </span>
        </el-dialog>
        <!-- Invite element dialog end -->
        <!-- Create element dialog -->
        <el-dialog title="Create User" :visible.sync="isCreateUserDlgVisible" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form :model="createUserData" :rules="createUserDataRules" ref="formCreateUser">
                <el-form-item label="First name" prop="first_name">
                    <el-input v-model="createUserData.first_name"></el-input>
                </el-form-item>

                <el-form-item label="Last name" prop="last_name">
                    <el-input v-model="createUserData.last_name"></el-input>
                </el-form-item>

                <el-form-item label="Email" prop="email">
                    <el-input v-model="createUserData.email"></el-input>
                </el-form-item>

                <el-form-item label="Password" prop="password">
                    <el-input type="password" v-model="createUserData.password"></el-input>
                </el-form-item>

                <el-form-item label="Password Confirmation" prop="password_confirmation">
                    <el-input type="password" v-model="createUserData.password_confirmation"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="isCreateUserDlgVisible = false">Cancel</el-button>
                <el-button type="primary" @click="postCreateUser()" :loading="isInXHR">Create</el-button>
            </span>
        </el-dialog>
        <!-- Create element dialog end -->
        <!-- Edit element dialog -->
        <el-dialog title="Edit User" :visible.sync="isEditUserDlgVisible" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form :model="editUserData" ref="formEditUser">
                <el-form-item label="First name" prop="first_name">
                    <el-input v-model="editUserData.first_name"></el-input>
                </el-form-item>

                <el-form-item label="Last name" prop="last_name">
                    <el-input v-model="editUserData.last_name"></el-input>
                </el-form-item>

                <el-form-item label="Email" prop="email">
                    <el-input v-model="editUserData.email"></el-input>
                </el-form-item>

                <el-form-item label="Password" prop="password">
                    <el-input type="password" v-model="editUserData.password"></el-input>
                </el-form-item>

                <el-form-item label="Password Confirmation" prop="password_confirmation">
                    <el-input type="password" v-model="editUserData.password_confirmation"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="isEditUserDlgVisible = false">Cancel</el-button>
                <el-button type="primary" @click="postEditUser()" :loading="isInXHR">Update</el-button>
            </span>
        </el-dialog>
        <!-- Update element dialog end -->
    </div>
</template>

<script>
    export default {
        mixins: [FormErrors, MyAxios],
        props: {
            clientsResourceUrl: '',
            riderResourceUrl: '',
            horseResourceUrl: '',
            saddleResourceUrl: '',
        },
        data() {
            var validatePass = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('Please input the password'));
                } else {
                    if (this.createUserData.password_confirmation !== '') {
                        this.$refs.formCreateUser.validateField('password_confirmation');
                    }
                    callback();
                }
            };
            var validatePass2 = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('Please input the password again'));
                } else if (value !== this.createUserData.password) {
                    callback(new Error('Two inputs don\'t match!'));
                } else {
                    callback();
                }
            };
            return {
                data: {
                    client: {
                        id: 0,
                        name: '',
                        email: '',
                        address: '',
                        postcode: '',
                        suburb: '',
                        state: '',
                    },
                },
                riders: [],
                horses: [],
                saddles: [],
                users: [],
                inviteUserData: {
                    first_name: '',
                    last_name: '',
                    email: ''
                },
                inviteUserDataRules: {
                    first_name: [
                        {
                            required: true,
                            message: 'Please enter first name',
                            trigger: 'blur'
                        },
                        {
                            min: 3,
                            max: 255,
                            message: 'Length should be 3 to 255',
                            trigger: 'blur'
                        }
                    ],
                    last_name: [
                        {
                            required: true,
                            message: 'Please enter last name',
                            trigger: 'blur'
                        },
                        {
                            min: 3,
                            max: 255,
                            message: 'Length should be 3 to 255',
                            trigger: 'blur'
                        }
                    ],
                    email: [
                        {
                            required: true,
                            message: 'Please enter email',
                            trigger: 'blur'
                        },
                        {
                            min: 3,
                            max: 255,
                            message: 'Length should be 3 to 255',
                            trigger: 'blur'
                        },
                        {
                            type: 'email',
                            message: 'Please enter correct email format',
                            trigger: 'blur'
                        }
                    ]
                },
                createUserData: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                createUserDataRules: {
                    first_name: [
                        {
                            required: true,
                            message: 'Please enter first name',
                            trigger: 'blur'
                        },
                        {
                            min: 3,
                            max: 255,
                            message: 'Length should be 3 to 255',
                            trigger: 'blur'
                        }
                    ],
                    last_name: [
                        {
                            required: true,
                            message: 'Please enter last name',
                            trigger: 'blur'
                        },
                        {
                            min: 3,
                            max: 255,
                            message: 'Length should be 3 to 255',
                            trigger: 'blur'
                        }
                    ],
                    email: [
                        {
                            required: true,
                            message: 'Please enter email',
                            trigger: 'blur'
                        },
                        {
                            min: 3,
                            max: 255,
                            message: 'Length should be 3 to 255',
                            trigger: 'blur'
                        },
                        {
                            type: 'email',
                            message: 'Please enter correct email format',
                            trigger: 'blur'
                        }
                    ],
                    password: [
                        {
                            required: true,
                            message: 'Please enter password',
                            trigger: 'blur'
                        },
                        {
                            min: 6,
                            max: 255,
                            message: 'Length should be 6 to 255',
                            trigger: 'blur'
                        },
                        {
                            validator: validatePass,
                            trigger: 'blur'
                        }
                    ],
                    password_confirmation: [
                        {
                            required: true,
                            message: 'Please confirm your password',
                            trigger: 'blur'
                        },
                        {
                            validator: validatePass2,
                            trigger: 'blur'
                        }
                    ]
                },
                editUserData: {
                    id: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                isInviteUserDlgVisible: false,
                isCreateUserDlgVisible: false,
                isEditUserDlgVisible: false,
            }
        },
        methods: {
            getData() {
                this.myAxios.get(this.clientsResourceUrl + '/' + this.$route.params.id)
                    .then((response) => {
                        this.data.client = response.data.client;
                        this.riders = response.data.riders;
                        this.horses = response.data.horses;
                        this.saddles = response.data.saddles;
                        this.users = response.data.users;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
            },
            onDeleteRider(id) {
                swal({
                    title: 'Warning?',
                    text: 'Are you sure to delete this rider?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                    .then((value) => {
                        if (value) {
                            this.myAxios.delete(this.riderResourceUrl + '/' + id)
                                .then((response) => {
                                    this.getData();
                                })
                                .catch((error) => {
                                    console.log(error);
                                    this.showErrorNotify(error);
                                });
                        }
                    });
            },
            onDeleteHorse(id) {
                swal({
                    title: 'Warning?',
                    text: 'Are you sure to delete this horse?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                    .then((value) => {
                        if (value) {
                            this.myAxios.delete(this.horseResourceUrl + '/' + id)
                                .then((response) => {
                                    this.getData();
                                })
                                .catch((error) => {
                                    console.log(error);
                                    this.showErrorNotify(error);
                                });
                        }
                    });
            },
            onDeleteSaddle(id) {
                swal({
                    title: 'Warning?',
                    text: 'Are you sure to delete this saddle?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                    .then((value) => {
                        if (value) {
                            this.myAxios.delete(this.saddleResourceUrl + '/' + id)
                                .then((response) => {
                                    this.getData();
                                })
                                .catch((error) => {
                                    console.log(error);
                                    this.showErrorNotify(error);
                                });
                        }
                    });
            },
            onInviteUser() {
                this.isInviteUserDlgVisible = true;
            },
            postInviteUser() {
                this.$refs.formInviteUser.validate((isValid) => {
                    if (isValid) {
                        this.myAxios.post(this.clientsResourceUrl + '/' + this.$route.params.id + '/invite-user', this.inviteUserData)
                            .then((res) => {
                                this.$notify({
                                    type: 'success',
                                    message: 'Invitation email sent to: ' + res.data.email,
                                    title: 'User Invited'
                                });
                                this.isInviteUserDlgVisible = false;
                                this.getData();
                            })
                            .catch((err) => {
                                console.log(err);
                                this.showErrorNotify(err);
                            });
                    }
                });
            },
            onCreateUser() {
                this.isCreateUserDlgVisible = true;
            },
            postCreateUser() {
                this.$refs.formCreateUser.validate((isValid) => {
                    if (isValid) {
                        this.myAxios.post(this.clientsResourceUrl + '/' + this.$route.params.id + '/create-user', this.createUserData)
                            .then((res) => {
                                this.$notify({
                                    type: 'success',
                                    message: 'Client User created successfully!',
                                    title: 'User Created'
                                });
                                this.isCreateUserDlgVisible = false;
                                this.getData();
                            })
                            .catch((err) => {
                                console.log(err);
                                this.showErrorNotify(err);
                            });
                    }
                });
            },
            onEditUser(id) {
                this.myAxios.get(this.clientsResourceUrl + '/' + this.$route.params.id + '/get-user/' + id)
                    .then((res) => {
                        this.editUserData = res.data;
                        this.isEditUserDlgVisible = true;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
            },
            postEditUser() {
                this.myAxios.put(this.clientsResourceUrl + '/' + this.$route.params.id + '/put-user/' + this.editUserData.id, this.editUserData)
                    .then((res) => {
                        this.isEditUserDlgVisible = false;
                        this.showElementNotify('User edited', 'User information updated successfully');
                        this.getData();
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
            },
            onDeleteUser(id) {
                swal({
                    title: 'Warning?',
                    text: 'Are you sure to delete this user?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                    .then((value) => {
                        if (value) {
                            this.myAxios.delete(this.clientsResourceUrl + '/' + this.$route.params.id + '/delete-user/' + id)
                                .then((response) => {
                                    this.showElementNotify('User deleted', 'User deleted successfully');
                                    this.getData();
                                })
                                .catch((error) => {
                                    console.log(error);
                                    this.showErrorNotify(error);
                                });
                        }
                    });
            }
        },
        mounted() {
            this.getData();
        },
    }
</script>

<style lang="scss">

</style>