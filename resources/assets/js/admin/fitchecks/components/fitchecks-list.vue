<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Fit Checks</h5>
            <div class="ibox-tools">
                <router-link :to="{ name: 'fitchecks-create'}" class="btn btn-primary btn-xs">Do a Fit Check
                </router-link>
            </div>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <!--Search box-->
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group m-b">
                        <span class="input-group-addon">Rider</span>
                        <select @change="getData()" v-model="riderQuery" class="form-control">
                            <option value="">-</option>
                            <option v-for="rider in riders"
                                    :value="rider.id">
                                {{ rider.first_name + ' ' + rider.last_name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group m-b">
                        <span class="input-group-addon">Horse</span>
                        <select @change="getData()" v-model="horseQuery" class="form-control">
                            <option value="">-</option>
                            <option v-for="horse in horses"
                                    :value="horse.id">
                                {{ horse.stable_name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group m-b">
                        <span class="input-group-addon">Checked by</span>
                        <select @change="getData()" v-model="userQuery" class="form-control">
                            <option value="">-</option>
                            <option v-for="user in users"
                                    :value="user.id">
                                {{ user.first_name + ' ' + user.last_name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <!--Search box end-->
            <!--Table-->
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Rider</th>
                    <th>Horse</th>
                    <th>Saddle</th>
                    <th>Checked by</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="fitcheck in fitchecks">
                    <td>{{ fitcheck.id }}</td>
                    <td>{{ fitcheck.rider.first_name + ' ' + fitcheck.rider.last_name }}</td>
                    <td>{{ fitcheck.horse.stable_name }}</td>
                    <td>{{ fitcheck.saddle.name }}</td>
                    <td>{{ fitcheck.user.first_name + ' ' + fitcheck.user.last_name }}</td>
                    <td>{{ fitcheck.created_at }}</td>
                    <td>
                        <router-link :to="{ name: 'fitchecks-view', params: { id: fitcheck.id } }"
                                     class="btn btn-info btn-xs"><i
                                class="fa fa-eye"></i></router-link>
                        <router-link :to="{ name: 'fitchecks-edit', params: { id: fitcheck.id } }"
                                     class="btn btn-primary btn-xs"><i class="fa fa-pencil-square"></i>
                        </router-link>
                        <button @click="onDelete(fitcheck.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--Table end-->
            <!--Pagination-->
            <div class="pagination">
                <div class="btn-group">
                    <button @click.prevent="onGoToPage(pageNumber - 1)" :disabled="pageNumber <= 1" type="button"
                            class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
                    <button v-show="pageNumbers[0] != 1" disabled="disabled" type="button" class="btn btn-white"> ...
                    </button>
                    <button v-for="pageNum in pageNumbers" @click.prevent="onGoToPage(pageNum)" class="btn btn-white"
                            :class="{'active': pageNum == pageNumber}">
                        {{ pageNum }}
                    </button>
                    <button v-show="pageNumbers[pageNumbers.length - 1] != lastPage" disabled="disabled" type="button"
                            class="btn btn-white"> ...
                    </button>
                    <button @click.prevent="onGoToPage(pageNumber + 1)" :disabled="pageNumber >= lastPage" type="button"
                            class="btn btn-white"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
            <!--Pagination end-->
        </div>
    </div>
</template>

<script>
    export default {
        mixins: [MyAxios, FormErrors],
        props: {
            fitchecksResourceUrl: '',
            ridersResourceUrl: '',
            horsesResourceUrl: '',
            fittersResourceUrl: '',
        },
        data() {
            return {
                fitchecks: [],
                riders: [],
                horses: [],
                users: [],
                riderQuery: '',
                horseQuery: '',
                userQuery: '',
                // Pagination variables.
                pageNumber: 0,
                pageNumbers: [],
                pageRange: 3,
                lastPage: 0,
            }
        },
        methods: {
            // Get riders, users, horses for query.
            getQueryData() {
                this.myAxios.get(this.ridersResourceUrl, {
                        params: {
                            per_page: Number.MAX_SAFE_INTEGER,
                        }
                    })
                    .then((res) => {
                        this.riders = res.data.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });

                this.myAxios.get(this.horsesResourceUrl, {
                        params: {
                            per_page: Number.MAX_SAFE_INTEGER,
                        }
                    })
                    .then((res) => {
                        this.horses = res.data.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });

                this.myAxios.get(this.fittersResourceUrl + '/my-users-all')
                    .then((res) => {
                        this.users = res.data.data;
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    });
            },
            // Main function to display list of fitchecks.
            getData() {
                this.myAxios.get(this.fitchecksResourceUrl, {
                        params: {
                            horse: this.horseQuery,
                            rider: this.riderQuery,
                            user: this.userQuery,
                            page: this.pageNumber
                        }
                    })
                    .then((response) => {
                        this.fitchecks = response.data.data;
                        this.pageNumber = response.data.current_page;
                        this.lastPage = response.data.last_page;

                        if (this.pageNumber > this.lastPage && this.lastPage > 0) {
                            this.pageNumber = this.lastPage;
                            this.getData();
                        }

                        // Update pagination numbers.
                        var newNumbers = [];
                        for (let i = this.pageNumber - this.pageRange; i < this.pageNumber + this.pageRange; i++) {
                            if (i > 0 && i <= this.lastPage) {
                                newNumbers.push(i);
                            }
                        }

                        this.pageNumbers = newNumbers;

                        // Update Url display.
                        this.$router.push({
                            name: 'fitchecks-list',
                            query: {
                                horse: this.horseQuery,
                                rider: this.riderQuery,
                                user: this.userQuery,
                                page: this.pageNumber,
                            }
                        });
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
            },
            onGoToPage(pageNumber) {
                if (pageNumber <= this.lastPage && pageNumber > 0) {
                    this.pageNumber = pageNumber;
                } else {
                    this.pageNumber = this.lastPage;
                }

                // Update Url display.
                this.$router.push({
                    name: 'fitchecks-list',
                    query: {
                        horse: this.horseQuery,
                        rider: this.riderQuery,
                        user: this.userQuery,
                        page: this.pageNumber
                    }
                });
                // Do real get.
                this.getData();
            },
            onDelete(id) {
                swal({
                    title: 'Warning?',
                    text: 'Are you sure to delete?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                    .then((value) => {
                        if (value) {
                            this.myAxios.delete(this.fitchecksResourceUrl + '/' + id)
                                .then((response) => {
                                    this.showElementNotify('Fit Check Deleted', 'Fit Check deleted successfully!');
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
            // Get query data.
            this.getQueryData();

            // Get pre-entered pageNumber and queries.
            this.pageNumber = this.$route.query.page ? this.$route.query.page : 0;
            this.riderQuery = this.$route.query.rider ? this.$route.query.rider : '';
            this.horseQuery = this.$route.query.horse ? this.$route.query.horse : '';
            this.userQuery = this.$route.query.user ? this.$route.query.user : '';

            // Get Fit checks list from server.
            this.getData();
        }
    }
</script>

<style>
    .pagination {
        text-align: center;
        display: block;
    }
</style>