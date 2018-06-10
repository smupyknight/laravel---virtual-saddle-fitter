<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Clients</h5>
            <div class="ibox-tools">
                <router-link :to="{ name: 'clients-create'}" class="btn btn-primary btn-xs">Create a new Client
                </router-link>
            </div>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <!--Search box-->
            <div class="input-group">
                <input @keyup.enter="getData()" v-model="nameQuery" class="form-control">
                <span class="input-group-btn">
                    <button @click="getData()" type="button" class="btn btn-primary">Search</button>
                </span>
            </div>
            <!--Search box end-->
            <!--Table-->
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Suburb</th>
                    <th>Postcode</th>
                    <th>State</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="client in clients">
                    <td>{{ client.id }}</td>
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.suburb }}</td>
                    <td>{{ client.postcode }}</td>
                    <td>{{ client.state }}</td>
                    <td>
                        <router-link :to="{ name: 'clients-view', params: { id: client.id } }"
                                     class="btn btn-info btn-xs"><i
                                class="fa fa-eye"></i></router-link>
                        <router-link :to="{ name: 'clients-edit', params: { id: client.id } }"
                                     class="btn btn-primary btn-xs"><i class="fa fa-pencil-square"></i>
                        </router-link>
                        <button @click="onDelete(client.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
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
            clientsResourceUrl: '',
        },
        data() {
            return {
                clients: [],
                nameQuery: '',
                // Pagination variables.
                pageNumber: 0,
                pageNumbers: [],
                pageRange: 3,
                lastPage: 0,
            }
        },
        methods: {
            // Main function to display list of clients.
            getData() {
                this.myAxios.get(this.clientsResourceUrl, {
                        params: {
                            search: this.nameQuery,
                            page: this.pageNumber
                        }
                    })
                    .then((response) => {
                        this.clients = response.data.data;
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
                            name: 'clients-list',
                            query: {
                                page: this.pageNumber,
                                name: this.nameQuery
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
                    name: 'clients-list',
                    query: {
                        page: this.pageNumber,
                        name: this.nameQuery
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
                            this.myAxios.delete(this.clientsResourceUrl + '/' + id)
                                .then((response) => {
                                    this.showElementNotify('Client Deleted', 'Client deleted successfully!');
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
            this.nameQuery = this.$route.query.name ? this.$route.query.name : '';

            // Get Clients list from server.
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