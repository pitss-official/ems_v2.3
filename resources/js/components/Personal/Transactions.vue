<template>
    <div id="transactions-controller">
        <div id="transactions-main">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive m-t-40">
                                <table cellspacing="0" class="display nowrap table table-hover table-striped table-bordered" id="transactions-table" width="100%" >
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Transaction ID</th>
                                        <th>Sender</th>
                                        <th>Description</th>
                                        <th>Reciever</th>
                                        <th>Date and Time</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                <tr>
                                    <th>Serial</th>
                                    <th>Transaction ID</th>
                                    <th>Sender</th>
                                    <th>Description</th>
                                    <th>Reciever</th>
                                    <th>Date and Time</th>
                                    <th>Amount</th>
                                </tr>
                                </tfoot>
                                    <tbody>
                                    <!--<tr v-for="(transaction,index) in transactions" v-bind:value="transaction.id">-->
                                        <!--<td>{{index+1}}</td>-->
                                        <!--<td>{{parseInt(transaction.id)}}</td>-->
                                        <!--<td>{{parseInt(transaction.sender)}}</td>-->
                                        <!--<td>{{transaction.description}}</td>-->
                                        <!--<td>{{parseInt(transaction.receiver)}}</td>-->
                                        <!--<td>{{transaction.created_at}}</td>-->
                                        <!--<td>{{parseFloat(transaction.amount)}}</td>-->
                                    <!--</tr>-->
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                transactions: [],
                i:0
            }
        },
        methods:
            {
                getTransactions()
                {
                    var results;
                    axios(
                        {
                            method:'get',
                            url:'/api/fetch/user/account/transactions'
                        }
                    ).then((response)=>{
                        this.$data.transactions=response.data;
                        var dataSet=[];
                        for(var j=0;j<=response.data.length;j++)
                        {
                            if(response.data[j].sender==currentUserID)
                            {
                                response.data[j].sender='You';
                                response.data[j].description=response.data[j].description.replace(currentUserID,'you');
                            }
                            dataSet.push([j+1,response.data[j].id,response.data[j].sender,response.data[j].description,response.data[j].receiver,response.data[j].created_at,response.data[j].amount]);
                            if(j==response.data.length-1){
                                $('#transactions-table').DataTable({
                                    data:dataSet,
                                    "order": [[ 0, "desc" ]],
                                    buttons: [
                                        'copy', 'excel', 'pdf'
                                    ],
                                });

                            }
                        }

                    }).catch(()=>{

                    });
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
</style>
