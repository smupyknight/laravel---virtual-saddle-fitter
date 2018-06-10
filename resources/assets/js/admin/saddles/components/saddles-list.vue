<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Saddles</h5>
            <div class="ibox-tools">
                <router-link :to="{ name: 'saddles-create'}" class="btn btn-primary btn-xs">Create a new Saddle
                </router-link>
            </div>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <!--Search box-->
            <div class="row">
                <div class="col-md-12">
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
            </div>
            <!--Search box end-->
            <!--Table-->
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Model</th>
                    <th>Horse</th>
                    <th>Brand</th>
                    <th>Style</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="saddle in saddles">
                    <td>{{ saddle.id }}</td>
                    <td>{{ saddle.name }}</td>
                    <td>{{ saddle.horse.stable_name }}</td>
                    <td>{{ saddle.brand.name }}</td>
                    <td>{{ saddle.style.name }}</td>
                    <td>{{ saddle.type }}</td>
                    <td>
                        <router-link :to="{ name: 'saddles-view', params: { id: saddle.id } }"
                                     class="btn btn-info btn-xs"><i
                                class="fa fa-eye"></i></router-link>
                        <router-link :to="{ name: 'saddles-edit', params: { id: saddle.id } }"
                                     class="btn btn-primary btn-xs"><i class="fa fa-pencil-square"></i>
                        </router-link>
                        <button @click="onDelete(saddle.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
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
            saddlesResourceUrl: '',
            horsesResourceUrl: '',
        },
        data() {
            return {
                saddles: [],
                horses: [],
                horseQuery: '',
                // Pagination variables.
                pageNumber: 0,
                pageNumbers: [],
                pageRange: 3,
                lastPage: 0,
            }
        },
        methods: {
            // Main function to display list of users.
            getData() {
                this.myAxios.get(this.saddlesResourceUrl, {
                        params: {
                            horse: this.horseQuery,
                            page: this.pageNumber
                        }
                    })
                    .then((response) => {
                        this.saddles = response.data.data;
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
                            name: 'saddles-list',
                            query: {
                                horse: this.horseQuery,
                                page: this.pageNumber,
                            }
                        });
                    })
                    .catch((error) => {
                        console.log(error);
                        this.showErrorNotify(error);
                    });
            },
            getHorses() {
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
            },
            onGoToPage(pageNumber) {
                if (pageNumber <= this.lastPage && pageNumber > 0) {
                    this.pageNumber = pageNumber;
                } else {
                    this.pageNumber = this.lastPage;
                }

                // Update Url display.
                this.$router.push({
                    name: 'saddles-list',
                    query: {
                        page: this.pageNumber,
                        horse: this.horseQuery,
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
                            this.myAxios.delete(this.saddlesResourceUrl + '/' + id)
                                .then((response) => {
                                    this.showElementNotify('Saddle Deleted', 'Saddle deleted successfully!');
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
            // Get pre-entered pageNumber, nameQuery.
            this.pageNumber = this.$route.query.page ? this.$route.query.page : 0;
            this.horseQuery = this.$route.query.horse ? this.$route.query.horse : '';

            // Get list from server.
            this.getData();
            this.getHorses();
        }
    }
</script>

<style>
    .pagination {
        text-align: center;
        display: block;
    }
</style>