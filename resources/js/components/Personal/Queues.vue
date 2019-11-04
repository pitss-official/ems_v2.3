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
                                <td v-if="queue.requestedBy != currentUser">
                                    <button alt="Approve Request" :data-queue="JSON.stringify(queue)"  @click="selectQueue">Approve</button>
                                    <button alt="Deny Request" data-toggle="modal" data-target="#queueActionModal" :data-queue="JSON.stringify(queue)" @click="selectQueue">Deny</button>
                                </td>

                                <td v-else>No Permissible Action</td>
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
                                    </div>
                                </div>
                            </td>
                            </tfoot>
                        </table>
                    </div>
                </li>
            </ul>

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
                queues:[],
                transactionDetails:[],
                selectedQueue:null,
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
                        });
                },
                selectQueue(event){
                    let q=JSON.parse(event.target.dataset.queue)
                    let r=q.requestedBy;
                    if(q.requestedBy==currentUserID)
                        r='You';
                    else{
                        axios.post('/members/find/name/'+q.requestedBy).then(res=>{r= res.data}).catch(res=>{
                            r=q.requestedBy;
                        });
                    }
                    swal.fire({
                        html:'<h1>'+event.target.innerHTML+' Request'+'</h1>'+
                            '<h3>Queue ID: <b>'+q.id+'</b></h3>'+
                            '<h3>Requested By: <b>'+r+'</b></h3>'+
                            '<h3>Value: <b>'+q.parameters+'</b></h3>'+
                            '<h3>Created At: <b>'+q.created_at+'</b></h3>'+
                            '<h3>Type Message: <b>'+q.typeMessage+'</b></h3>'+
                            '<h3>Queue Level: <b>'+q.authenticationLevel+'</b></h3>',
                        showCancelButton:true,
                        input:'text',
                        type:"question",
                        backdrop: `rgba(0, 0, 123, 0.4)`,
                        confirmButtonText: event.target.innerHTML,
                        showLoaderOnConfirm: true,
                        preConfirm: (text) => {
                            if(text.length==0){
                                Swal.showValidationMessage(
                                    `Enter a message to approve the request`
                                )
                            }
                            else {
                                if (event.target.innerHTML=="Approve")
                                axios.post('/api/approve/user/queues/approvePendingActions', {id:q.id,approvalRemarks:text})
                                    .then( response => {
                                        if(isNaN(response.data.id))
                                            swal.fire("Error",response.data.id.error,"error")
                                        else{
                                            swal.fire({
                                                title: 'Approved successfully',
                                                text: 'You have successfully approved request created by ' + this.$data.transactionDetails.requestedBy,
                                                type: response.data.result,
                                                backdrop: `rgba(0, 0, 123, 0.4)`
                                            });}
                                    }).catch (error => {
                                        swal.fire({
                                            title: 'Error Processing',
                                            text: error.response.statusText,
                                            type: "error",
                                            backdrop: `rgba(0, 0, 123, 0.4)`
                                        });
                                    });
                                else
                                    axios.post('/api/deny/user/queues/denyPendingActions', {id:q.id,approvalRemarks:text})
                                        .then( response => {
                                            if(isNaN(response.data.id))
                                                swal.fire("Error",response.data.id.error,"error")
                                            else{
                                                swal.fire({
                                                    title: 'Denied successfully',
                                                    text: 'You have successfully denied request created by ' + this.$data.transactionDetails.requestedBy,
                                                    type: 'success',
                                                    backdrop: `rgba(0, 0, 123, 0.4)`
                                                });}
                                        }).catch (error => {
                                        swal.fire({
                                            title: 'Error Processing',
                                            text: error.response.statusText,
                                            type: "error",
                                            backdrop: `rgba(0, 0, 123, 0.4)`
                                        });
                                    });
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then(res=>{
                    })
                    $('.nav-item.dropdown.mega-dropdown.show').click();
                }

        }
    }
</script>

<style>
    .modal-backdrop.fade.show{
        /*z-index:0 !important;*/
    }
</style>
