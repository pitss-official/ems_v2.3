<template>
    <div id="enrollment-fees">
        <div id="enrollment-fees-card">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Receive Money from Student</h4>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="deposit" class="form-material">
                                <div class="form-body">
                                    <h3 class="card-title">Enter Student Details</h3>
                                    <hr>
                                    <alert-errors :form="student"></alert-errors>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Registration Number</label>
                                                <input @change="find" @tab="find" autofocus class="form-control" id="regNo" name="RegistrationNumber" placeholder="" required type="number" v-model="student.collegeUID"  v-validate="'required|numeric|digits:8'">
                                                <small class="form-control-feedback">Press TAB to fetch name</small> </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <!--				form-group has-danger/has-success									form-control-danger-->
                                                <input class="form-control" id="name" placeholder="Enter Registration Number to Fetch" readonly type="text" v-model="student.name">
                                                <small class="form-control-feedback"><div class="label label-light-danger" v-show="student.balance"><p style="font-size: 140% !important;" v-text="student.balance"></p></div></small></div>
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
                                            <input class="form-control" id="mobile" placeholder="" type="text" v-model="student.mobile">
                                            <small class="form-control-feedback">Registered Mobile</small> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Amount</label>
                                            <input class="form-control" id="amount" onChange='$("#sub").focus()' placeholder="₹" required type="number" v-model="student.amount" v-validate="'required|min:1'" value="0.00">
                                            <small class="form-control-feedback">Currently Supported ₹,$</small> </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button class="btn waves btn-success" id="sub" type="submit"> <i class="fa fa-check"></i> Create Request</button>
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
    //import Select from "vue-select/src/components/Select";
    import AlertErrors from "vform/src/components/AlertErrors";

    export default {

        components: {AlertErrors},
        data () {
            return {
                naive:{
                    filled:false,
                },
                // Create a new form instance
                student: new Form({
                    collegeUID: null,
                    name: null,
                    amount:0,
                    mobile:null,
                    balance:null,
                }),
                selectedEvent:null,
                events:[],
                teams:[]
            };
        },
        methods:
            {
                find()
                {
                    if(this.student.collegeUID.length==8){
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

                            });axios({
                            method: 'get',
                            url: '/api/members/find/pendingBalance/' + this.$data.student.collegeUID,
                        })
                            .then((response) => {
                                if(response.data) {
                                    this.student.balance='Rs. '+response.data.balance;
                                }
                            })
                            .catch((response)=> {

                            });

                    }
                },
                deposit()
                {
                    this.$validator.validateAll();
                    swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Deposit'
                    }).then((result) => {
                        if (result.value) {
                            this.student.post('/api/forms/fees/enrollment/pluckPendingBalance').then((response)=> {
                                console.log(response
                                )
                                if(typeof response.data == "number"){
                                swal.fire(
                                    'Transferred!',
                                    'Money Transfer Request Completed Successfully. <b>TransactionID: '+response.data+'</b>',
                                    'success'
                                );
                                this.student.reset();
                                    $('#regNo').focus();
                                }
                                else if(response.data.irata)
                                {
                                    swal.fire('Invalid Target Account','You cant send money to yourself','error')
                                }
                        }).catch((response)=>{swal.fire('Truncated','Transaction failed because of errors. Amount credited back to your account','error')});
                        }
                });
            }}
    }
</script>
