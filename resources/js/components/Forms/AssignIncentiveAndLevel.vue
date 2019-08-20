<template>
        <div id="user-auth-assignment">
            <div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">User Incentive and Authority</h4>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="send" class="form-material">
                                    <div class="form-body">
                                        <h3 class="card-title">Enter User Details</h3>
                                        <hr>
                                        <alert-errors :form="student"></alert-errors>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Registration Number</label>
                                                    <input @change="find" @tab="find" autofocus class="form-control" name="RegistrationNumber" placeholder="" ref="regNo" required type="number" v-model="student.collegeUID" v-validate="'required|numeric|digits:8'">
                                                    <small class="form-control-feedback">Press TAB to fetch name</small> </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input class="form-control" disabled name="name" placeholder="Enter Registration Number to Fetch" readonly type="text" v-model="student.name">
                                                    <small class="form-control-feedback"></small> </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Power</label>
                                                <input class="form-control" name="mobile" placeholder="" type="text" v-model="student.power">
                                                <small class="form-control-feedback">DANGER</small> </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Incentive Rate</label>
                                                <input class="form-control" name="amount" onChange='$("#sub").focus()' placeholder="₹" required type="number" v-model="student.incentiveRate" value="0.00">
                                                <small class="form-control-feedback">Rate of Incentives in Percentage 0-100</small> </div>
                                        </div>
                                    </div><div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="control-label">Login</label>
                                            <input v-model="student.active" type="checkbox" class="attendance-checkbox-default">
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <label class="control-label">Request text(Message for receiver)</label>
                                            <input class="form-control" placeholder="Authority escalation required for ..." type="text" v-model="student.narration">
                                            <small class="form-control-feedback">Write a small message for the receiver to recognise your request</small>
                                        </div>
                                    </div>
                                </div>
                                    <div class="form-actions">
                                        <button class="btn btn-success" id="sub" type="submit"> <i class="fa fa-check"></i> Create Request</button>
                                        <button class="btn btn-danger" type="reset">Cancel</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script>
        export default {
            data()
            {
                return{
                    naive:
                        {
                            filled:false,
                        },
                    student: new Form({
                        collegeUID: null,
                        name: null,
                        power: null,
                        narration:null,
                        amount:null,
                        active:false,
                    })
                }

            },
            methods:
                {
                    find()
                    {
                        if(this._self.fields.RegistrationNumber.valid){
                            if(this.$data.student.collegeUID==currentUserID)
                            {
                                this.$data.student.name=currentUserFullName;
                                return;
                            }
                            axios({
                                method: 'post',
                                url: '/api/members/find/name/' + this.$data.student.collegeUID,
                            })
                                .then((response) => {
                                    if(response.data) {
                                        this.$data.student.name=response.data.firstName;
                                        if(response.data.middleName!="null")this.$data.student.name+' '+ response.data.middleName;
                                        if(response.data.lastName!="null")this.$data.student.name+' ' +response.data.lastName;
                                        this.$data.naive.filled=true;
                                    }
                                    else
                                    {
                                        this.$refs.regNo.focus();
                                        this.$data.student.name='Please enter a Valid Registration Number';
                                        this.$data.naive.filled=false;
                                    }

                                })
                                .catch((response)=> {

                                });

                        }
                    },
                    send()
                    {
                        if(this.$data.student.collegeUID==currentUserID)
                        {
                            swal.fire("Invalid Data","You cannot alter authorities for yourself","error");
                            return;
                        }
                        this.student.delete('/api/put/user/var/update-delete')
                            .then(response => {
                                if(response.data.result=="success")
                                {
                                    // this.$broadcast('newQueueAdded');
                                    swal.fire({
                                        title: 'Request Sent!',
                                        html: "Authentication Altered for <b>" + this.$data.student.name + "</b><br>Request ID:<b>" + response.data.id + '</b>',
                                        type: 'success',
                                        backdrop: 'rgba(0, 0, 123, 0.4)',
                                    })
                                    this.student.clear()
                                }
                                else
                                {
                                    swal.fire("Server Error","Some error occurred while processing your request. Transaction truncated","error");
                                }
                            }).catch(reason => {swal("Server Unreachable",reason,"error")});
                    }
                },
            mounted()
            {
                $('.attendance-checkbox-default').bootstrapSwitch({
                    animate: true,
                    onInit: function (event, state) {

                    },
                    onText: 'ALLOWED',
                    offText: 'BANNED',
                    onColor: 'success',
                    offColor: 'danger'
                });
                $('.attendance-checkbox-default').on('switchChange.bootstrapSwitch', (res,st)=>this.$data.student.active=st);
            },
            name: "auth-assignment-request"
        }
    </script>
<style scoped>

</style>
