<template>
    <li class="nav-item dropdown mega-dropdown"> <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-view-grid"></i></a>
        <div class="dropdown-menu scale-up-left">
            <ul class="mega-dropdown-menu row">
                <li class="col-lg-12 m-b-30">
                    <h4 class="card-title">Pending Actions (Queue)</h4>
                    <h6 class="card-subtitle">You are equally responsible for carrying out actions listed in queue approved by you.</h6>
                    <div class="table-responsive" id="queues">
                        <table id="queue-table" class="table toggle-circle table-hover" data-page-size="10">
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
                            <tr v-for="queue in queues" v-bind:value="queue.id">
                                <td>{{queue.id}}</td>
                                <td>{{queue.requestedBy}}</td>
                                <td>{{queue.requesterRemarks}}</td>
                                <td>{{queue.authenticationLevel}}</td>
                                <td>Coordinator</td>
                                <td>{{queue.requesterRemarks}}</td>
                                <td>{{queue.created_at}}</td>
                                <td><button>Approve</button><button>Deny</button></td>
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
                                            <button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#add-contact">View All</button>

                                        </div>
                                    </div>
                                </div></td>
                            </tfoot>
                        </table>
                    </div>
                </li>
            </ul>
        </div>
    </li>
</template>

<script>
    export default {

        name: "queue",
        data(){
            return{
                queues:[]
            };
        },
        mounted() {
            this.getAll();
        },
        methods:
            {
                getAll()
                {
                    axios({
                        method: 'get',
                        url: '/api/user/actions/queue',
                    })
                        .then((response) => {
                            this.$data.queues = response.data;
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