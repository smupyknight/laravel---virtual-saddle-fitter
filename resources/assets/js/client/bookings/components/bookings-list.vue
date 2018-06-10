<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Bookings</h5>
            <div class="ibox-tools">
                <router-link :to="{ name: 'bookings-create'}" class="btn btn-primary btn-xs">Create a new Booking
                </router-link>
            </div>
        </div>
        <div class="ibox-content" v-loading="XHRCount">
            <!--Search box-->
            <div class="form-group">
                <select class="form-control" v-model="bookingStatusQuery" id="bookingStatusQuery" @change="getData();">
                    <option value="" selected="selected">All Bookings</option>
                    <option value="upcoming">Upcoming Bookings</option>
                    <option value="completed">Completed Bookings</option>
                </select>
            </div>
            <!--Search box end-->
            <!--Table-->
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Fitter</th>
                    <th>Horse</th>
                    <th>Rider</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="booking in bookings">
                    <td>{{ booking.id }}</td>
                    <td>{{ booking.fitter.name }}</td>
                    <td>{{ booking.horse.stable_name }}</td>
                    <td>{{ booking.rider.first_name }} {{ booking.rider.last_name }}</td>
                    <td>{{ booking.date }}</td>
                    <td>
                        <router-link :to="{ name: 'bookings-view', params: { id: booking.id } }"
                                     class="btn btn-info btn-xs"><i
                                class="fa fa-eye"></i></router-link>
                        <router-link :to="{ name: 'bookings-edit', params: { id: booking.id } }"
                                     class="btn btn-primary btn-xs"><i class="fa fa-pencil-square"></i>
                        </router-link>
                        <button @click="onDelete(booking.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
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
            bookingsResourceUrl: '',
        },
        data() {
            return {
                bookings: [],
                bookingStatusQuery: '',
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
                this.myAxios.get(this.bookingsResourceUrl, {
                        params: {
                            booking_status: this.bookingStatusQuery,
                            page: this.pageNumber
                        }
                    })
                    .then((response) => {
                        this.bookings = response.data.data;
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
                            name: 'bookings-list',
                            query: {
                                booking_status: this.bookingStatusQuery,
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
                    name: 'bookings-list',
                    query: {
                        page: this.pageNumber,
                        booking_status: this.bookingStatusQuery,
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
                            this.myAxios.delete(this.bookingsResourceUrl + '/' + id)
                                .then((response) => {
                                    this.showElementNotify('Booking Deleted', 'Booking deleted successfully!');
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
            this.bookingStatusQuery = this.$route.query.booking_status ? this.$route.query.booking_status : '';

            // Get list from server.
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