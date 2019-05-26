<template>
    <div id="enrollment">
        <div id="enrollment-main">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info" id="mains">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Student Registration Form</h4>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="enrollWithFullPayment" class="form-material">
                                <div class="form-body">
                                    <h3 class="card-title">Student Details</h3>
                                    <hr>
                                    <alert-errors :form="student"></alert-errors>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Registration Number</label>
                                                <input id="regNo" v-validate="'required|numeric|digits:8'" v-model="student.collegeUID" @change="find" @tab="find" type="number" required placeholder="" name="RegistrationNumber" autofocus class="form-control" :class="{ 'form-has-error': student.errors.has('collegeUID') }">

                                                <small class="form-control-feedback"><span v-show="!errors.has('RegistrationNumber')">Press TAB to check if the student is already enrolled</span>
                                                <span class="form-has-error-span" v-if="errors.first('RegistrationNumber')">{{ errors.first('RegistrationNumber') }}</span>
                                                </small><has-error class="form-has-error-span" :form="student" field="collegeUID"></has-error></div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">First Name</label>
                                                <input ref="firstName" :disabled="naive.filled" :readonly="naive.filled" :class="{ 'is-invalid': student.errors.has('firstName') }" type="text" v-model="student.firstName" name="firstName" class="form-control" required>
                                                <small class="form-control-feedback"></small>
                                                <has-error :form="student" field="firstName"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Middle Name</label>
                                                <input :disabled="naive.filled" :readonly="naive.filled" type="text" name="middleName" v-model="student.middleName" class="form-control">
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Last Name</label>
                                                <input :disabled="naive.filled" :readonly="naive.filled" type="text" name="lastName" v-model="student.lastName" class="form-control">
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">Gender</label>
                                                <select :disabled="naive.filled" :readonly="naive.filled" :class="{ 'is-invalid': student.errors.has('gender') }" v-model="student.gender" name="gender" class="form-control custom-select" required>
                                                    <option value="1" selected>Male</option>
                                                    <option value="2">Female</option>
                                                    <option value="0">Others or Not Defined</option>
                                                </select>
                                                <small class="form-control-feedback"> Select your gender </small>
                                                <has-error :form="student" field="gender"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <!--				form-group has-danger/has-success									form-control-danger-->
                                                <input :disabled="naive.filled" :readonly="naive.filled" v-model="student.email" :class="{ 'is-invalid': student.errors.has('email') }" type="email" name="email" class="form-control" required placeholder="abc@xyz.com">
                                                <small class="form-control-feedback"></small>
                                                <has-error :form="student" field="email"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Mobile Number</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled" type="number" v-model="student.mobile" :class="{ 'is-invalid': student.errors.has('collegeUID') }" name="mobile" class="form-control" placeholder="" required data-mask="9999999999">
                                            <small class="form-control-feedback">Confirmation of Seat and Pass details will be sent on this number</small> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Event Selection</label>
                                            <select :disabled="naive.filled" @change="readyData(student.teamID)" :readonly="naive.filled" :class="{ 'is-invalid': student.errors.has('collegeUID') }" v-model="student.eventID" id="eventID" class="form-control custom-select" required>
                                                <option v-for="event in events" v-bind:value="event.id">
                                                    {{ event.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                                <h3 class="box-title m-t-40">Personal Details (Optional)</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Father's Name</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled" type="text" name="fathersName" v-model="student.fathersName" class="form-control">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Birthday</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled" type="date" v-model="student.birthday" class="form-control">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div><div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Blood Group</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled" type="text" v-model="student.bloodGroup" class="form-control">
                                        </div>
                                    </div><div class="col-md-3">
                                        <div class="form-group">
                                            <label>Nationality</label>
                                            <select type="text" v-model="student.nationality" class="form-control">
                                                <option value="IN" selected>Indian</option>
                                                </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Team ID</label>
                                            <select type="number" v-model="student.team" class="form-control">
                                                <option v-for="team in teams" v-bind:value="team.id">{{ team.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea :disabled="naive.filled" :readonly="naive.filled" v-model="student.address" id="address" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Alternate Mobile</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled" v-model="student.altMobile" type="text" id="alt-mobile" class="form-control" data-mask="9999999999">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Group ID</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled" readonly type="number" id="group" class="form-control" value="">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->


                                <div class="form-actions">
                                    <button type="submit" :disabled="student.busy" @click="enrollWithFullPayment" id="btn-fullpay" class="btn btn-primary"> <i class="fa fa-check"></i> Enroll and Pay Now</button>
                                    <button type="button" :disabled="student.busy" @click="partialPay" id="btn-partpay" class="btn btn-info"> <i class="fa fa-check"></i> Enroll and Paritial Pay Now</button>
                                    <button type="button" class="btn btn-danger" onClick="reset()">Cancel</button>
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
    import Select from "vue-select/src/components/Select";
    import AlertErrors from "vform/src/components/AlertErrors";

    export default {
        components: {AlertErrors, Select},
        data () {
            return {
                naive:{
                  filled:false,
                },
                // Create a new form instance
                student: new Form({
                    collegeUID: null,
                    firstName: null,
                    middleName: null,
                    lastName: null,
                    fathersName: null,
                    gender: 1,
                    address: null,
                    mobile: null,
                    altMobile: null,
                    email: null,
                    eventID: null,
                    nationality: null,
                    bloodGroup: null,
                    birthday:null,
                    team:0,
                    amount:0,
                    remember: false,
                }),
                selectedEvent:null,
                events:[],
                teams:[]
            };
        },
        methods: {
            find() {
                if(this._self.fields.RegistrationNumber.valid){
                axios({
                    method: 'post',
                    url: '/api/basic/Names/' + this.$data.student.collegeUID,
                })
                    .then((response) => {
                        if(response.data) {
                            this.$data.student.firstName=response.data.firstName;
                            this.$data.student.lastName=response.data.lastName;
                            this.$data.student.middleName=response.data.middleName;
                            this.$data.naive.filled=true;
                        }
                        else
                        {
                            this.$refs.firstName.focus();
                                this.$data.student.firstName=null;
                                this.$data.student.lastName=null;
                                this.$data.student.middleName=null;
                                this.$data.naive.filled=false;
                        }

                    })
                    .catch((response)=> {
swal.fire('Error','Kindly Contact Service Administrator','error');
                    });

                }
            },
            partialPay() {
                var flag=0;
                this.$validator.validateAll();
                if(this.selectedEvent.minimumPayment==100)
                {
                    swal.fire({title:'Not Allowed',text:'This event is not allowed for reservation of seats via partial payment',type:'error',backdrop: `rgba(123,10,0,0.4)`});
                    return;
                }
                var Swal=swal;
                Swal.fire({
                    title: 'Enter Amount',
                    input: 'number',
                    type:'question',
                    text: 'Minimum Allowed Amount for this event is Rs. '+this.selectedEvent.ticketPrice*this.selectedEvent.minimumPayment/100,
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Book Now',
                    showLoaderOnConfirm: true,
                    preConfirm: (value) => {
                        console.log(value)
                        this.student.amount=value;
                        return this.student.post('/api/enroll/student')
                            .then(response => {
                                return response;
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `You have some validation errors`
                                )
                            })
                    },
                    allowOutsideClick: () => flase
                }).then((result) => {
                    if (result.value) {
                        console.log(result)
                        swal.fire({
                            title:'Enrollment ID: '+result.value.data,
                            text:'You have successfully enrolled '+this.student.firstName,
                            type:'success',
                            backdrop: `rgba(0,0,123,0.4)`
                        });
                        this.student.reset();
                    }
                });
            },
            getEvents() {
                axios({
                    method: 'post',
                    url: '/api/basic/events/all',
                })
                    .then((response) => {
                        this.$data.events = response.data
                    })
                    .catch(function (response) {
                        swal.fire( 'Server Error', 'Kindly Contact the Server Admin','error');
                    });
            },
            readyData()
            {
                for (var j=0;j<this.events.length;j++)
                {
                    if(this.student.eventID==this.events[j].id)
                    this.selectedEvent=this.events[j];
                }

                axios({
                    method: 'post',
                    url: '/api/basic/teams/'+this.$data.student.eventID,
                })
                    .then((response) => {
                        this.$data.teams = response.data;
                    })
                    .catch(function (response) {
                        swal.fire( 'Server Error', 'Kindly Contact the Server Admin','error');
                    });
            },
            enrollWithFullPayment() {
                this.$validator.validateAll();
                    this.student.amount=this.selectedEvent.ticketPrice;
                    this.student.mobile=parseInt(this.student.mobile);
                    this.student.post('/api/enroll/student')
                        .then((response) => {
                            var data=response.data;

                            swal.fire({
                                title:'Enrollment ID: '+data,
                                text:'You have successfully enrolled '+this.student.firstName,
                                type:'success',
                                backdrop: `rgba(0,0,123,0.4)`
                            });
                            this.student.reset();
                            $('#regNo').focus();
                        });
            },
        },
        mounted() {
            this.getEvents();
        }
    }
</script>
