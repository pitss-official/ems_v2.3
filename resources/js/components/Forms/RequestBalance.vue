<template>
    <div id="money-transfer">
        <div id="money-transfer-main">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Request Money (Balance)</h4>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="send" class="form-material">
                                <div class="form-body">
                                    <h3 class="card-title">Enter Indented Sender Details</h3>
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
                                            <label class="control-label">Mobile Number (Optional)</label>
                                            <input class="form-control" name="mobile" placeholder="" type="text" v-model="student.mobile">
                                            <small class="form-control-feedback">Registered Mobile</small> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Amount</label>
                                            <input class="form-control" name="amount" onChange='$("#sub").focus()' placeholder="₹" required type="number" value="0.00" v-model="student.amount">
                                            <small class="form-control-feedback">Currently Supported ₹,$</small> </div>
                                    </div>
                                </div><div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label">Request text(Message for sender)</label>
                                        <input class="form-control" placeholder="eg. Send me balance in exchange of cash currency" type="text" v-model="student.narration">
                                        <small class="form-control-feedback">Write a small message for the sender to recognise your request</small>
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
                    mobile: null,
                    narration:null,
                    amount:null,
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
                        swal.fire("Invalid Data","You cannot initiate money send request to yourself","error");
                        return;
                    }
                    this.student.post('/api/put/user/queues/balanceRequest/newRequest')
                        .then(response => {
                            console.log(response);
                            if(response.data.result=="success")
                            {
                                this.$broadcast('newQueueAdded')
                                swal.fire({
                                    title: 'Request Sent!',
                                    html: "Money transfer request sent to <b>" + this.$data.student.name + "</b><br>Request ID:<b>" + response.data.id + '</b>',
                                    type: 'success',
                                    backdrop: 'rgba(0, 0, 123, 0.4)',
                                })
                            }
                            else
                            {
                                swal.fire("Server Error","Some error occurred while processing your request. Transaction truncated","error");
                            }
                        }).catch(reason => {swal("Server Unreachable",reason,"error")});
                }
            },
        name: "money-transfer"
    }
</script>
