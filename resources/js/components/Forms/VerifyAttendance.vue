<template>
    <div class="verifyStudentAttendanceView" id="verifyEventAttendance">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-info" id="mains">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Pending Attendance Verification</h4>
                    </div>
                        <div class="card-body">
                            <div class="form-body">

                        <div id="verify-attendance" class=" table-responsive">
                            <table class="table toggle-circle table-hover" data-page-size="10" id="attendance-queue-table">
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
                                    <td ><button v-if="queue.requestedBy != currentUser" @click="getTransactionDetails(queue); getVerifiableStudents(); enableButton()">Approve</button>
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

                                        </div>
                                    </div>
                                </td>
                                </tfoot>


                            </table>
                        </div>
                                <div id="verify-students-table-div">
                                <table id="verify-students-table" class="display table table-hover table-striped table-bordered"
                                       cellspacing="0" width="100%">
                                </table>
                                </div>
                                <div class="form-actions">
                                    <button class="btn btn-success" id="verify-attendance-btn" type="submit" @click="verify"> <i class="fa fa-check"></i> Verify</button>
                                    <button class="btn btn-danger" id="not-verify-attendance-btn" type="submit" @click="notVerify"> <i class="fa fa-close"></i>Reject</button>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>


</template>

<script>
    import "footable"
    export default {
        name:"pending-attendance",
        data(){
            return{
                toggleApproveDeny: false,
                approvalRemarks: '',
                queues:[],
                transactionDetails:[],
            };
        },
        mounted() {
            this.getAll();
            document.getElementById("verify-attendance-btn").style.visibility  = "hidden";
            document.getElementById("not-verify-attendance-btn").style.visibility  = "hidden";
            setTimeout(()=>$('#attendance-queue-table').footable({"empty": "There are no pending actions",}),100);
        },
        methods:
            {
                //todo: by anu (taking queue(in html) array from particular row and assigning its values to modal form attributes)
                getTransactionDetails(queue){
                    this.$data.transactionDetails = queue;



                },

                enableButton(){
                    document.getElementById("verify-attendance-btn").style.visibility  = "visible";
                    document.getElementById("not-verify-attendance-btn").style.visibility  = "visible";
                },

                getAll()
                {
                    axios({
                        method: 'get',
                        url: '/api/fetch/user/queues/pendingAttendance',
                    }).then((response) => {
                            this.$data.queues = response.data;

                            if(response.data.length==0){
                                $("#verify-attendance").html('<label>There are no pending actions.</label>');
                            }
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


                getVerifiableStudents() {
                    axios({
                        method: 'get',
                        url: '/api/events/' + this.$data.transactionDetails.parameters + '/find/verifiable/participants',
                    }).then((response) => {
                        console.log(response.data);
                        let usableDataSet = [];
                        let schools = {
                            A: 'Lovely School of Architectuware and Design',
                            B: 'School of Bio Engineering and Bio Sciences',
                            C: 'School of Civil Engineering',
                            D: 'School of Computer Application',
                            E: 'School of Electronics and Electrical Engineering',
                            F: 'School of Journalism, Films & Creative Arts',
                            G: 'School of Chemical Engineering and Physical Sciences',
                            K: 'School of Computer Science and Engineering',
                            L: 'School of Law',
                            M: 'School of Mechanical Engineering',
                            P: 'School of Professional Enhancement',
                            Q: 'School of Business',
                            R: 'School of Hotel Management and Tourism',
                            S: 'School of Fashion Design',
                            U: 'School of Arts and Languages',
                            Y: 'LIT (Pharmacy)/Department of Pharmaceutical Sciences',
                            Z: 'School of Physiotherapy & Paramedical',
                        };
                        let rowArr = response.data;
                        for (let j = 0; j < response.data.length; j++) {
                            let name = rowArr[j].firstName;
                            let state = '';
                            if (rowArr[j].middleName != null)
                                name += ' ' + rowArr[j].middleName;
                            if (rowArr[j].lastName != null)
                                name += ' ' + rowArr[j].lastName;
                            let buttonType ="";
                            let buttonText = "";
                            if(parseInt(rowArr[j].balance)<0){
                                buttonType = "badge-warning";
                                buttonText="Blocked";
                            }
                            else if((rowArr[j].attendanceID == null) &&(rowArr[j].balance>=0)){
                                buttonType = "badge-danger";
                                buttonText="Absent";
                            }
                            else{
                                buttonType = "badge-primary";
                                buttonText="Present";
                            }

                        let btn='<span class="badge '+buttonType+'"'+'>'+buttonText+'</span>';
                            usableDataSet.push([j + 1, rowArr[j].collegeUID, name, schools[rowArr[j].school] + ', ' + rowArr[j].branch, rowArr[j].balance, btn]);
                        }
                        var Table=$('#verify-students-table').DataTable({
                            data: usableDataSet,
                            responsive: true,
                            dom: 'Bform',
                            buttons: [
                                {
                                    extend: 'pdf',
                                    className: 'btn btn-themecolor waves-effect waves-dark'
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn btn-themecolor waves-effect waves-dark'
                                },
                                {
                                    extend: 'print',
                                    className: 'btn btn-themecolor waves-effect waves-dark'
                                },
                                {
                                    extend: 'colvis',
                                    className: 'btn btn-themecolor waves-effect waves-dark',
                                    collectionLayout: 'fixed two-column'
                                },
                                {
                                    extend: 'copy',
                                    className: 'btn btn-themecolor waves-effect waves-dark'
                                },
                                {
                                    extend: 'excel',
                                    className: 'btn btn-themecolor waves-effect waves-dark'
                                }
                            ],
                            select: true,
                            paging: true,
                            pagingType: 'simple',
                            "columnDefs": [
                                {
                                    "orderable": false,
                                    "targets": [0, 1, 3]
                                },
                                {
                                    render: function (data, type, full, meta) {
                                        return "<div class='text-wrap width-100'>" + data + "</div>";
                                    },
                                    targets: 3
                                }
                            ],
                            "order": [[0, "asc"]],
                            fixedHeader: {
                                header: true,
                            },
                            columns: [
                                {title: "Sr.", responsivePriority: 5, targets: 0},
                                {title: "Registration Number", responsivePriority: 5},
                                {title: "Name", responsivePriority: 5},
                                {title: "School and Branch", responsivePriority: 10},
                                {title: "Balance", responsivePriority: 10},
                                {title: "Action", responsivePriority: 1},
                            ],
                        });


                        $("#actions").show();
                    });

                },

                verify(){
                    axios.post('/api/verify/student/attendance',{id:this.$data.transactionDetails.id})
                        .then(response=> {
                            if (response.data.result == "success") {
                                swal.fire('Success', 'Attendance Verified', 'success');
                                $("#verify-students-table-div").html('');
                                $("#verify-attendance-btn").hide();
                                $("#not-verify-attendance-btn").hide();
                                this.getAll();
                            }
                            else
                            {swal.fire('Server Error','Some error occurred while processing.','error')}
                            }).catch(error=>swal.fire('Error','Some error occurred. '+error,'error'))
                },

                notVerify(){
                    axios.post('/api/reject/student/attendance', {queueID: this.$data.transactionDetails.id})
                        .then(response =>{
                            if (response.data.result == "success") {
                                swal.fire('Success', 'Attendance Rejected', 'success');
                                $("#verify-students-table-div").html('');
                                $("#verify-attendance-btn").hide();
                                $("#not-verify-attendance-btn").hide();
                                this.getAll();
                            }
                            else
                            {swal.fire('Server Error','Some error occurred while processing.','error')}
                        }).catch(error=>swal.fire('Error','Some error occurred. '+error,'error'))



                }

            }
    }
</script>

<style scoped>

</style>
