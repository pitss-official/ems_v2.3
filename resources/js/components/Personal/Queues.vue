<template>
    <li class="nav-item dropdown mega-dropdown"> <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle text-muted waves-effect waves-dark" data-toggle="dropdown" href=""><i class="mdi mdi-view-grid"></i></a>
        <div class="dropdown-menu scale-up-left">
            <ul class="mega-dropdown-menu row">
                <li class="col-lg-12 m-b-30">
                    <h4 class="card-title">Pending Actions (Queue)</h4>
                    <h6 class="card-subtitle">You are equally responsible for carrying out actions listed in queue approved by you.</h6>
                    <div class="table-responsive" id="queues">
                        <table class="table toggle-circle table-hover" data-page-size="10" id="queue-table">
                            <thead>
                            <tr>
                                <th data-toggle="true">ID</th>
                                <th>From</th>
                                <th data-hide="phone">Action Requested</th>
                                <th data-hide="phone">Level Required</th>
                                <th data-hide="all">Role</th>
                                <th data-hide="all">Remarks</th>
                                <th data-hide="all">Time</th>
                                <th data-hide="phone">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-bind:value="queue.id" v-for="queue in queues">
                                <td>{{queue.id}}</td>
                                <td>{{queue.requestedBy}}</td>
                                <td>{{queue.requesterRemarks}}</td>
                                <td>{{queue.authenticationLevel}}</td>
                                <td>Coordinator</td>
                                <td>{{queue.requesterRemarks}}</td>
                                <td>{{queue.created_at}}</td>
                                <td><button @click="getTransactionDetails(queue)" data-target="#approveRequest" data-toggle="modal">Approve</button><button>Deny</button></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <td colspan="2">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="text-right">
                                                <ul class="pagination"> </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <button class="btn btn-info btn-rounded" data-target="#add-contact" data-toggle="modal" type="button">
                                                View All
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            </tfoot>


                        </table>
                    </div>
                </li>
            </ul>

        </div>
        <!--todo: anu-->
        <!--modal-->

        <div id="approveRequest" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Content is Responsive</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label class="control-label">Request for approval: {{transactionDetails.requesterRemarks}}</label>

                            </div>
                            <div class="form-group">
                                <label class="control-label"> Requested from: {{transactionDetails.requestedBy}}</label>

                            </div>


                            <div class="form-group">
                                <label class="control-label">On: {{transactionDetails.created_at}}</label>

                            </div>
                            <div class="form-group">
                                <!--todo: anu check this not printing amount not fetching-->
                                <label class="control-label">Amount: {{transactionDetails.parameters}}</label>

                            </div>

                            <div class="form-group">
                                <label class="control-label" for="message-text">Remarks for request:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </li>
</template>

<script>
    export default {

        name: "queue",

        data(){

            return{
                queues:[],
               // queueObj: {},
                transactionDetails:[],


            };
        },
        mounted() {
            this.getAll();
        },
        methods:
            {
                //todo: by anu (taking queue array from particular row and assigning its values to modal form attributes)
                getTransactionDetails(queue){


                    this.$data.transactionDetails = queue;


                },

                getAll()
                {
                    axios({
                        method: 'get',
                        url: '/api/fetch/user/queues/pendingActions',
                    })
                        .then((response) => {
                            this.$data.queues = response.data;
                            //     var $i=0;
                            //     for(var $key in response.data){
                            //         if($i<3){
                            //
                            //             this.$data.queues[$key] = response.data[$i];
                            //             $i++;
                            //         }
                            //     }
                            //     console.log(this.$data.queueObj);
                            // // this.$data.queues = response.data;
                            console.log(response.data);


                        });
                    //$('#queue-table').dataTable();
                },
                approve(queue_id)
                {

                },
                deny(queue_id)
                {

                }
            }
    }
</script>

<style scoped>

</style>
