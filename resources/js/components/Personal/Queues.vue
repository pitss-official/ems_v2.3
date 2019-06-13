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
                                <td v-if="queue.requestedBy!=currentUser">{{queue.requestedBy}}</td>
                                <td v-else>You</td>
                                <td>{{queue.typeMessage}}</td>
                                <td>{{queue.authenticationLevel}}</td>
                                <td>Coordinator</td>
                                <td>{{queue.requesterRemarks}}</td>
                                <td>{{queue.created_at}}</td>
                                <td ><button v-if="queue.requestedBy != currentUser" @click="getTransactionDetails(queue)" data-target="#approveRequest" data-toggle="modal">Approve</button>
                                    <button @click="deny(transactionDetails)">Deny</button>
                                </td>
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

        <div class="modal fade" id="approveRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Request for approval</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label class="control-label"><b>{{transactionDetails.requesterRemarks}}</b></label>

                            </div>
                            <div class="form-group">
                                <label class="control-label"> Requested By: {{transactionDetails.requestedBy}}</label>

                            </div>


                            <div class="form-group">
                                <label class="control-label">On: {{transactionDetails.created_at}}</label>

                            </div>
                            <div class="form-group">
                                <!--todo: anu check this not printing amount not fetching-->
                                <label class="control-label">Amount: {{transactionDetails.parameters}}</label>

                            </div>

                            <div class="form-group">
                                <label class="control-label" name="approvalRemarks" for="message-text">Remarks for request:</label>
                                <textarea class="form-control" v-model="approvalRemarks" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect">Cancel</button>
                        <button type="submit" class="btn btn-primary" @click="approve(transactionDetails)" v-if="toggleApproveDeny == true">Approve</button>
                        <button type="submit" class="btn btn-primary" @click="deny(transactionDetails)" v-if="toggleApproveDeny == false">Deny</button>
                    </div>
                </div>
            </div>
        </div>

    </li>
</template>

<script>
    import "footable"
    export default {
        name:"queue",
        data(){

            return{
                toggleApproveDeny: false,
                currentUser: '',
                approvalRemarks: '',
                queues:[],
               // queueObj: {},
                transactionDetails:[],


            };
        },
        mounted() {
            setInterval(()=>$('#queue-table').footable({"empty": "There are no pending actions",}),1500);
            setInterval(()=>this.getAll(),30000);
        },
        beforeMount()
        {
            this.getAll();
        },
        methods:
            {
                //todo: by anu (taking queue(in html) array from particular row and assigning its values to modal form attributes)
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
                            this.$data.currentUser = currentUserID;

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



                        });
                },
                approve(transactionDetails)
                {
                    this.$data.toggleApproveDeny = true;
                    $('#approveRequest').modal('show');
                    if(transactionDetails.requestedBy==currentUserID)
                    {
                        swal.fire("Error","You cannot approve your own request","error");
                        return;
                    }
                    axios.post('/api/approve/user/queues/approvePendingActions', {id:this.$data.transactionDetails.id,approvalRemarks:this.$data.approvalRemarks})
                        .then( response => {
                            $('#approveRequest').modal('hide');
                            if(isNaN(response.data.id))
                                swal.fire("Error",response.data.id.error,"error")
                            else{
                            swal.fire({
                                title: 'Approved successfully',
                                text: 'You have successfully approved request created by ' + this.$data.transactionDetails.requestedBy,
                                type: 'success',
                                backdrop: `rgba(0, 0, 123, 0.4)`
                            });}
                        }, error => {
                            // Handle error response
                        });

                },
                deny(transactionDetails)
                {
                    this.$data.toggleApproveDeny = false;
                    $('#approveRequest').modal('show');

                    axios.post('/api/deny/user/queues/denyPendingActions', {id:this.$data.transactionDetails.id,approvalRemarks:this.$data.approvalRemarks})
                        .then( response => {
                            $('#approveRequest').modal('hide');
                            if(this.$data.transactionDetails.requestedBy == currentUserID){
                                this.$data.transactionDetails.requestedBy == "you"}
                            if(isNaN(response.data.id))
                                swal.fire("Error",response.data.id.error,"error")
                            else{
                                swal.fire({
                                    title: 'Denied successfully',
                                    text: 'You have successfully denied request created by ' + this.$data.transactionDetails.requestedBy,
                                    type: 'success',
                                    backdrop: `rgba(0, 0, 123, 0.4)`
                                });}
                        }, error => {
                            // Handle error response
                        });

                },

        }
    }
</script>

<style scoped>

</style>
