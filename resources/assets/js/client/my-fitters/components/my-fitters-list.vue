<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Manage my Fitters</h5>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <!--Search box-->
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group m-b">
                        <span class="input-group-addon">Related?</span>
                        <select class="form-control" v-model="relatedQuery" @change="getData()">
                            <option value="true">Show Related Fitters</option>
                            <option value="false" selected="selected">Show All Fitters</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input @keyup.enter="getData()" v-model="nameQuery" class="form-control">
                        <span class="input-group-btn">
                            <button @click="getData()" type="button" class="btn btn-primary">Search</button>
                        </span>
                    </div>
                </div>
            </div>
            <!--Search box end-->
            <!--Table-->
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="myFitter in myFitters">
                    <td>{{ myFitter.id }}</td>
                    <td>{{ myFitter.name }}</td>
                    <td>{{ myFitter.phone }}</td>
                    <td>{{ myFitter.email }}</td>
                    <td>
                        <span v-if="myFitter.related" class="label label-primary"><i class="fa fa-check"></i>Related</span>
                        <span v-if="!myFitter.related" class="label label-warning"><i class="fa fa-times"></i>Not Related</span>
                    </td>
                    <td>
                        <button v-if="myFitter.related" @click="onRemove(myFitter.id)" class="btn btn-danger btn-xs">
                            <i class="fa fa-unlink"></i>
                        </button>
                        <button v-if="!myFitter.related" @click="onAdd(myFitter.id)" class="btn btn-success btn-xs">
                            <i class="fa fa-link"></i>
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
            myFittersResourceUrl: '',
        },
        data() {
            return {
                myFitters: [],
                nameQuery: '',
                relatedQuery: 'false',
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
                this.myAxios.get(this.myFittersResourceUrl, {
                        params: {
                            search: this.nameQuery,
                            related: this.relatedQuery,
                            page: this.pageNumber
                        }
                    })
                    .then((response) => {
                        this.myFitters = response.data.data;
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
                            name: 'my-fitters-list',
                            query: {
                                search: this.nameQuery,
                                related: this.relatedQuery,
                                page: this.pageNumber
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
                    name: 'my-fitters-list',
                    query: {
                        search: this.nameQuery,
                        related: this.relatedQuery,
                        page: this.pageNumber
                    }
                });
                // Do real get.
                this.getData();
            },
            // Add, remove relation
            onAdd(id) {
                this.myAxios.post(this.myFittersResourceUrl + '/' + id)
                    .then((res) => {
                        this.showElementNotify('Add Successful', 'Fitter #' + id + ' Added to My Fitters');
                        this.getData();
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    })
            },
            onRemove(id) {
                this.myAxios.delete(this.myFittersResourceUrl + '/' + id)
                    .then((res) => {
                        this.showElementNotify('Remove Successful', 'Fitter #' + id + ' Removed from My Fitters');
                        this.getData();
                    })
                    .catch((err) => {
                        console.log(err);
                        this.showErrorNotify(err);
                    })
            },
        },
        mounted() {
            // Get pre-entered pageNumber, nameQuery.
            this.pageNumber = this.$route.query.page ? this.$route.query.page : 0;
            this.nameQuery = this.$route.query.search ? this.$route.query.search : '';
            this.relatedQuery = this.$route.query.related ? this.$route.query.related : 'false';

            // Get Horses list from server.
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