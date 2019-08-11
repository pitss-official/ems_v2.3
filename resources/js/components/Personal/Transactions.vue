<template>
    <div id="transactions-controller">
        <div id="transactions-main">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">My Transactions</h4>
                            <h6 class="card-subtitle">All enrollments, transfers and incentives etc will be listed here</h6>
                            <div>
                            <div class="table-responsive m-t-40">
                                <div></div>
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
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DataTable from "datatables.net-bs";
     // import "datatables.net-autofill-bs/js/autoFill.bootstrap";
    import "datatables.net-buttons-bs";
    import "datatables.net-colreorder-bs"
    import "datatables.net-fixedcolumns-bs"
    import "datatables.net-fixedheader-bs"
    import "datatables.net-keytable-bs"
    import "datatables.net-responsive-bs"
    import "datatables.net-rowgroup-bs"
    import "datatables.net-rowreorder-bs"
    import "datatables.net-scroller-bs"
    import "datatables.net-select-bs";
    import "datatables.net-buttons-bs"
    import "datatables.net-buttons/js/buttons.colVis.js"
    import "datatables.net-buttons/js/buttons.print.js"
    import "datatables.net-buttons/js/buttons.html5.js"
    import "datatables.net-buttons/js/buttons.flash.js"
    import pdfMake from "pdfmake/build/pdfmake.js"
    import pdfFonts from "pdfmake/build/vfs_fonts.js"
    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    export default {
        data() {
            return {
                transactions: [],
                i: 0
            }
        },
        methods:
            {
                getTransactions() {
                    var results;
                    axios(
                        {
                            method: 'get',
                            url: '/api/fetch/user/account/transactions'
                        }
                    ).then((response) => {

                        this.$data.transactions = response.data;
                        var dataSet = [];
                        for (let j = 0; j < response.data.length; j++) {
                            if (response.data[j].sender == currentUserID) {
                                response.data[j].sender = 'You';
                                response.data[j].description = response.data[j].description.replace(currentUserID, 'you');
                            }
                            dataSet.push([j + 1, response.data[j].id, response.data[j].sender, response.data[j].description, response.data[j].receiver, response.data[j].created_at, '₹'+response.data[j].amount]);
                            if (j == response.data.length - 1) {
                                $('#transactions-table').DataTable({
                                    responsive:true,
                                    data: dataSet,
                                    dom:'Bform',
                                    "order": [[0, "desc"]],
                                    buttons: [
                                        {extend:'pdf',className:'btn btn-themecolor waves-effect waves-dark'},
                                        {extend:'csv',className:'btn btn-themecolor waves-effect waves-dark'},
                                        {extend:'print',className:'btn btn-themecolor waves-effect waves-dark'},
                                        {extend:'colvis',className:'btn btn-themecolor waves-effect waves-dark'},
                                        {extend: 'copy', className: 'btn btn-themecolor waves-effect waves-dark' },
                                        {extend: 'excel', className: 'btn btn-themecolor waves-effect waves-dark' }
                                    ],
                                    select: true,
                                    paging:true,
                                    pagingType:'simple',
                                });

                            }
                        }
                    }).catch(reason => console.log(reason));
                }
            },
        mounted() {
            this.getTransactions();
        }

    }
</script>

<style scoped>
    table#transactions-table.dataTable tbody tr:hover {
        background-color: #ffa;
    }

    table#transactions-table.dataTable tbody tr:hover > .sorting_1 {
        background-color: #ffa;
    }
    table.dataTable th,
    table.dataTable td {
        white-space: nowrap;
    }
</style>
