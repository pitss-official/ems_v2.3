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
                                                <input :class="{ 'form-has-error': student.errors.has('collegeUID') }"
                                                       @change="find" @tab="find" autofocus class="form-control"
                                                       id="regNo" name="RegistrationNumber" placeholder="" required
                                                       type="number" v-model="student.collegeUID"
                                                       v-validate="'required|numeric|digits:8'">

                                                <small class="form-control-feedback"><span
                                                    v-show="!errors.has('RegistrationNumber')">Press TAB to check if the student is already enrolled</span>
                                                    <span class="form-has-error-span"
                                                          v-if="errors.first('RegistrationNumber')">{{ errors.first('RegistrationNumber') }}</span>
                                                </small>
                                                <has-error :form="student" class="form-has-error-span"
                                                           field="collegeUID"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">First Name</label>
                                                <input :class="{ 'is-invalid': student.errors.has('firstName') }"
                                                       :disabled="naive.filled" :readonly="naive.filled"
                                                       class="form-control" name="firstName" ref="firstName" required
                                                       type="text" v-model="student.firstName">
                                                <small class="form-control-feedback"></small>
                                                <has-error :form="student" field="firstName"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Middle Name</label>
                                                <input :disabled="naive.filled" :readonly="naive.filled"
                                                       class="form-control" name="middleName" type="text"
                                                       v-model="student.middleName">
                                                <small class="form-control-feedback"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Last Name</label>
                                                <input :disabled="naive.filled" :readonly="naive.filled"
                                                       class="form-control" name="lastName" type="text"
                                                       v-model="student.lastName">
                                                <small class="form-control-feedback"></small>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">Gender</label>
                                                <select :class="{ 'is-invalid': student.errors.has('gender') }"
                                                        :disabled="naive.filled" :readonly="naive.filled"
                                                        class="form-control custom-select" name="gender" required
                                                        v-model="student.gender">
                                                    <option selected value="1">Male</option>
                                                    <option value="2">Female</option>
                                                    <option value="0">Others or Not Defined</option>
                                                </select>
                                                <small class="form-control-feedback"> Select your gender</small>
                                                <has-error :form="student" field="gender"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <!--				form-group has-danger/has-success									form-control-danger-->
                                                <input :class="{ 'is-invalid': student.errors.has('email') }"
                                                       :disabled="naive.filled" :readonly="naive.filled"
                                                       class="form-control" name="email" placeholder="abc@xyz.com"
                                                       required type="email" v-model="student.email">
                                                <small class="form-control-feedback"></small>
                                                <has-error :form="student" field="email"></has-error>
                                            </div>
                                        </div>
                                    </div><!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">School</label>
                                                <select :class="{ 'is-invalid': student.errors.has('school') }"
                                                        :disabled="naive.filled" :readonly="naive.filled"
                                                        class="form-control custom-select" name="school" required
                                                        v-model="student.school">
                                                    <option value="A">Lovely School of Architecture and Design</option>
                                                    <option value="B">School of Bio Engineering and Bio Sciences</option>
                                                    <option value="C">School of Civil Engineering</option>
                                                    <option value="D">School of Computer Application</option>
                                                    <option value="E">School of Electronics and Electrical Engineering</option>
                                                    <option value="F">School of Journalism, Films & Creative Arts</option>
                                                    <option value="G">School of Chemical Engineering and Physical Sciences</option>
                                                    <option value="K">School of Computer Science and Engineering</option>
                                                    <option value="L">School of Law</option>
                                                    <option value="M">School of Mechanical Engineering</option>
                                                    <option value="P">School of Professional Enhancement</option>
                                                    <option value="Q">School of Business</option>
                                                    <option value="R">School of Hotel Management and Tourism</option>
                                                    <option value="S">School of Fashion Design</option>
                                                    <option value="U">School of Arts and Languages</option>
                                                    <option value="Y">LIT (Pharmacy)/Department of Pharmaceutical Sciences</option>
                                                    <option value="Z">School of Physiotherapy & Paramedical</option>
                                                </select>
                                                <small class="form-control-feedback"> Select your gender</small>
                                                <has-error :form="student" field="school"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Course</label>
                                                <!--				form-group has-danger/has-success									form-control-danger-->
                                                <input :class="{ 'is-invalid': student.errors.has('course') }"
                                                       :disabled="naive.filled" :readonly="naive.filled"
                                                       class="form-control" name="course" placeholder="Eg. Computer Science and Engineering"
                                                       required type="text" v-model="student.course">
                                                <small class="form-control-feedback"></small>
                                                <has-error :form="student" field="course"></has-error>
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
                                            <input :class="{ 'is-invalid': student.errors.has('collegeUID') }"
                                                   :disabled="naive.filled" :readonly="naive.filled"
                                                   class="form-control" data-mask="9999999999" name="mobile"
                                                   placeholder="" required type="number" v-model="student.mobile">
                                            <small class="form-control-feedback">Confirmation of Seat and Pass details
                                                will be sent on this number
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Event Selection</label>
                                            <select :class="{ 'is-invalid': student.errors.has('collegeUID') }"
                                                    @change="readyData(student.teamID)"
                                                    class="form-control custom-select" id="eventID" required
                                                    v-model="student.eventID">
                                                <option v-bind:value="event.id" v-for="event in events">
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
                                            <input :disabled="naive.filled" :readonly="naive.filled"
                                                   class="form-control" name="fathersName" type="text"
                                                   v-model="student.fathersName">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Birthday</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled"
                                                   class="form-control" type="date" v-model="student.birthday">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Blood Group</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled"
                                                   class="form-control" type="text" v-model="student.bloodGroup">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Nationality</label>
                                            <select class="form-control" type="text" v-model="student.nationality">
                                                <option selected value="IN">Indian</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Team ID</label>
                                            <select class="form-control" type="number" v-model="student.team">
                                                <option v-bind:value="team.id" v-for="team in teams">{{ team.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea :disabled="naive.filled" :readonly="naive.filled"
                                                      class="form-control" id="address" rows="5"
                                                      v-model="student.address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Alternate Mobile</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled"
                                                   class="form-control" data-mask="9999999999" id="alt-mobile"
                                                   type="text" v-model="student.altMobile">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Group ID</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled"
                                                   class="form-control" id="group" readonly type="number" value="">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->


                                <div class="form-actions">
                                    <button :disabled="student.busy" @click="enrollWithFullPayment"
                                            class="btn btn-primary" id="btn-fullpay" type="submit"><i
                                        class="fa fa-check"></i> Enroll and Pay Now
                                    </button>
                                    <button :disabled="student.busy" @click="partialPay" class="btn btn-info"
                                            id="btn-partpay" type="button"><i class="fa fa-check"></i> Enroll and
                                        Paritial Pay Now
                                    </button>
                                    <button class="btn btn-danger" onClick="reset()" type="button">Cancel</button>
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
    // import Select from "vue-select/src/components/Select";
    import
        AlertErrors from "vform/src/components/AlertErrors";

    export default {
        components: {AlertErrors},
        data() {
            return {
                naive: {
                    filled: false,
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
                    birthday: null,
                    team: 0,
                    amount: 0,
                    school:null,
                    course:null,
                    remember: false,
                }),
                selectedEvent: null,
                events: [],
                teams: []
            };
        },
        methods: {
            find() {
                if (this._self.fields.RegistrationNumber.valid) {
                    axios({
                        method: 'post',
                        url: '/api/members/find/name/' + this.$data.student.collegeUID,
                    })
                        .then((response) => {
                            if (response.data) {
                                this.$data.student.firstName = response.data.firstName;
                                this.$data.student.lastName = response.data.lastName;
                                this.$data.student.middleName = response.data.middleName;
                                this.$data.naive.filled = true;
                            } else {
                                this.$refs.firstName.focus();
                                this.$data.student.firstName = null;
                                this.$data.student.lastName = null;
                                this.$data.student.middleName = null;
                                this.$data.naive.filled = false;
                            }

                        })
                        .catch((response) => {
                            swal.fire('Error', 'Kindly Contact Service Administrator', 'error');
                        });

                }
            },
            partialPay() {
                var flag = 0;
                if (this.selectedEvent.minimumPayment == 100) {
                    swal.fire({
                        title: 'Not Allowed',
                        text: 'This event is not allowed for reservation of seats via partial payment',
                        type: 'error',
                        backdrop: `rgba(123, 10, 0, 0.4)`
                    });
                    return;
                }
                this.$validator.validateAll().then(() => {
                    swal.fire({
                        title: 'Enter Amount',
                        input: 'number',
                        type: 'question',
                        text: 'Minimum Allowed Amount for this event is Rs. ' + this.selectedEvent.ticketPrice * this.selectedEvent.minimumPayment / 100,
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Book Now',
                        showLoaderOnConfirm: true,
                        preConfirm: (value) => {
                            console.log(value)
                            this.student.amount = value;
                            return this.student.post('/api/forms/events/enroll/student')
                                .then(response => {
                                    return response;
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(
                                        `You have some validation errors`
                                    )
                                })
                        },
                        allowOutsideClick: () => false
                    }).then((result) => {
                        if (result.value) {
                            if (result.value.data.error) {
                                swal.fire(result.value.data.error, result.value.data.message, "error");
                                return;
                            } else {
                                axios({
                                    method: 'post',
                                    url: '/api/verify/enrollment/' + result.value.data,
                                }).then(resp => {
                                        console.log(resp);
                                        if(isNaN(resp.data))
                                            swal.fire("Error","Server Error","error");
                                        swal.fire({
                                            title: 'Enrollment ID: ' + result.value.data,
                                            text: 'You have successfully enrolled ' + this.student.firstName,
                                            type: 'success',
                                            backdrop: `rgba(0, 0, 123, 0.4)`
                                        });
                                        this.student.reset();
                                    }).catch()
                                {
                                    swal("Enrollment Failed", "Some error occurred during enrollment", "error")
                                }
                            }

                        }
                    });
                }).catch()
                {
                    swal("Invalid Inputs", "Your form has multiple errors", "error");
                }
            },
            getEvents() {
                axios({
                    method: 'post',
                    url: '/api/events/find/enrollable/',
                })
                    .then((response) => {
                        this.$data.events = response.data
                    })
                    .catch(function (response) {
                        swal.fire('Server Error', 'Kindly Contact the Server Admin', 'error');
                    });
            },
            readyData() {
                for (var j = 0; j < this.events.length; j++) {
                    if (this.student.eventID == this.events[j].id)
                        this.selectedEvent = this.events[j];
                }

                axios({
                    method: 'get',
                    url: '/api/events/find/enrollable/' + this.$data.student.eventID+'/teams/',
                }).then((response) => {
                        this.$data.teams = response.data;
                    })
                    .catch(function (response) {
                        swal.fire('Server Error', 'Kindly Contact the Server Admin', 'error');
                    });
            },
            enrollWithFullPayment() {
                this.$validator.validateAll().then(() => {
                    this.student.amount = this.selectedEvent.ticketPrice;
                    this.student.mobile = parseInt(this.student.mobile);
                    this.student.post('/api/forms/events/enroll/student')
                        .then((response) => {
                            var data = response.data;
                            if(data.result=="success") {
                                swal.fire({
                                    title: 'Enrollment ID: ' + data.id,
                                    text: 'You have successfully enrolled ' + this.student.firstName,
                                    type: 'success',
                                    backdrop: `rgba(0, 0, 123, 0.4)`
                                });
                                this.student.reset();
                                $('#regNo').focus();
                            }else {
                                swal.fire("Error 505","Internal Server Error","error")
                            }
                        });
                }).catch()
                {
                    swal("Invalid Inputs", "Your form has multiple errors", "error");
                }
            },
        },
        mounted() {
            this.getEvents();
        }
    }
</script>
