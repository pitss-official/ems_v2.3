<template>
    <div id="search-transaction">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Search Transactions</h4>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="findTransactions" class="form-material">
                            <div class="form-body">
                                <h3 class="card-title" @click="toggleSearchOptions">Transaction Details
                                    <div class="pull-right" id="search-trans-plus-button" >
                                        <button class="btn btn-themecolor"
                                                id="trans-trigger-btn" type="button"><i class="fa fa-plus"></i></button>
                                    </div>
                                </h3>
                                <hr>
                                <div id="trans-search-options">
                                    <div class="row p-t-20">
                                        <div class="col-md-4">
                                            <div class="form-group"><label class="control-label">Registration Number</label>
                                                <input autofocus class="form-control" placeholder="eg. 11711709"
                                                       type="number" v-model="collegeUID">
                                                <small class="form-control-feedback">Enter receiver or Sender college
                                                    ID
                                                </small>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input class="form-control" placeholder="Eg. Raman Mishra" type="text"
                                                       v-model="name">
                                                <small class="form-control-feedback">Enter name of the engaged student
                                                </small>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Transaction ID</label>
                                                <input class="form-control" placeholder="eg. 55" type="number"
                                                       v-model="transactionID">
                                                <small class="form-control-feedback">Registered Mobile</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Queue ID</label>
                                                <input class="form-control" placeholder="eg. 590" type="number"
                                                       v-model="queueID">
                                                <small class="form-control-feedback">Queue associated with the transaction</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Amount</label>
                                                <input class="form-control" placeholder="eg. 500" type="number" v-model="amount" value="0.00">
                                                <small class="form-control-feedback">Amount associated with the
                                                    transaction
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Account number</label>
                                                <input class="form-control" placeholder="eg. 99887766" type="number"
                                                       v-model="accountNumber">
                                                <small class="form-control-feedback">Account number of sender or
                                                    receiver
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Initiator</label>
                                                <input class="form-control" placeholder="eg. 99887766" type="number"
                                                       v-model="initBy">
                                                <small class="form-control-feedback">College ID of transaction initiator
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Date</label>
                                                <input class="form-control" type="datetime-local" v-model="transDate">
                                                <small class="form-control-feedback">Date of Transaction</small>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Description</label>
                                                <input class="form-control" placeholder="eg. Cash Transfer" type="text"
                                                       v-model="description">
                                                <small class="form-control-feedback">description associated with
                                                    transaction
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button class="btn waves btn-themecolor" id="sub" type="submit"><i
                                                class="fa fa-search"></i>
                                            Search
                                        </button>
                                        <button class="btn btn-danger" type="reset" onClick="history.back()">Cancel & Back</button>
                                    </div>
                                </div>
                                <div id="search-results">
                                    <table id="transactions-table"
                                           class="display nowrap table table-hover table-striped table-bordered"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Transaction ID</th>
                                            <th>Sent By</th>
                                            <th>Description</th>
                                            <th>Recieved By</th>
                                            <th>DateTime</th>
                                            <th>Amount</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Transaction ID</th>
                                            <th>Sent By</th>
                                            <th>Description</th>
                                            <th>Recieved By</th>
                                            <th>DateTime</th>
                                            <th>Amount</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchTransaction",
        data() {
            return {
                transactionID: null,
                collegeUID: null,
                accountNumber: null,
                amount: null,
                queueID: null,
                transDate: null,
                description: null,
                initBy: null,
                name: null,
            }
        },
        methods: {
            findTransactions() {
                $('#search-results').html('<table id="transactions-table" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%"><thead><tr><th>Sr.</th><th>Transaction ID</th><th>Initiator</th><th>Sent By</th><th>Description</th><th>Recieved By</th><th>DateTime</th><th>Amount</th></tr></thead><tfoot><tr><th>Sr.</th><th>Transaction ID</th><th>Initiator</th><th>Sent By</th><th>Description</th><th>Recieved By</th><th>DateTime</th><th>Amount</th></tr></tfoot><tbody></tbody></table>');
                this.toggleSearchOptions();
                axios.post('/api/search/transactions/by-data/',this.$data).then(response=>{
                    this.$data.transactions = response.data;
                    var dataSet = [];
                    // for (let j = 0; j < response.data.length; j++) {
                    //     if (response.data[j].sender == currentUserID) {
                    //         response.data[j].sender = 'You';
                    //         response.data[j].description = response.data[j].description.replace(currentUserID, 'you');
                    //     }
                    //     dataSet.push([j + 1,response.data[j].id, response.data[j].initBy, response.data[j].sender, response.data[j].description, response.data[j].receiver, response.data[j].created_at, '₹'+response.data[j].amount]);
                    //     if (j == response.data.length - 1) {
                    //         $('#transactions-table').DataTable({
                    //             responsive:true,
                    //             data: dataSet,
                    //             dom:'Bform',
                    //             "order": [[0, "desc"]],
                    //             buttons: [
                    //                 {extend:'pdf',className:'btn btn-themecolor waves-effect waves-dark'},
                    //                 {extend:'csv',className:'btn btn-themecolor waves-effect waves-dark'},
                    //                 {extend:'print',className:'btn btn-themecolor waves-effect waves-dark'},
                    //                 {extend:'colvis',className:'btn btn-themecolor waves-effect waves-dark'},
                    //                 {extend: 'copy', className: 'btn btn-themecolor waves-effect waves-dark' },
                    //                 {extend: 'excel', className: 'btn btn-themecolor waves-effect waves-dark' }
                    //             ],
                    //             select: true,
                    //             paging:true,
                    //             pagingType:'simple',
                    //         });
                    //
                    //     }
                    // }
                }).catch(e=>console.log(e));
            },
            toggleSearchOptions() {
                $('#search-trans-plus-button').show();
                if ($("#trans-search-options").is(":hidden") === true) {
                    $("#trans-search-options").show();
                    $('#search-results').hide();
                    $('#trans-trigger-btn').html('<i class="fa fa-minus"></i>');
                } else {
                    $("#trans-search-options").hide();
                    $('#search-results').show();
                    $('#trans-trigger-btn').html('<i class="fa fa-plus"></i>');
                }
            }
        },
        mounted() {
            $('#search-trans-plus-button').hide();
            $('#search-results').hide();

        }
    }
</script>
