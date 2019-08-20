<template>
    <div>
        <div id="add-org">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info" id="mains">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Add User to Organization</h4>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="addUser" class="form-material">
                                <div class="form-body">
                                    <h3 class="card-title">Student Details</h3>
                                    <hr>
                                    <alert-errors :form="student"></alert-errors>
                                    <div class="row p-t-20">
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Middle Name</label>
                                                <input :disabled="naive.filled" :readonly="naive.filled"
                                                       class="form-control" name="middleName" type="text"
                                                       v-model="student.middleName">
                                                <small class="form-control-feedback"></small>
                                                <has-error :form="student" field="middleName"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Last Name</label>
                                                <input :disabled="naive.filled" :readonly="naive.filled"
                                                       class="form-control" name="lastName" type="text"
                                                       v-model="student.lastName">
                                                <small class="form-control-feedback"></small>
                                                <has-error :form="student" field="lastName"></has-error>
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
                                                <label class="control-label">Branch</label>
                                                <!--				form-group has-danger/has-success									form-control-danger-->
                                                <input :class="{ 'is-invalid': student.errors.has('branch') }"
                                                       :disabled="naive.filled" :readonly="naive.filled"
                                                       class="form-control" name="course" placeholder="Eg. Bachelor of Technology (Hons.)"
                                                       required type="text" v-model="student.branch">
                                                <small class="form-control-feedback"></small>
                                                <has-error :form="student" field="branch"></has-error>
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
                                            </small><has-error :form="student" field="mobile"></has-error>
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
                                            <has-error :form="student" field="fathersName"></has-error>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Birthday</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled"
                                                   class="form-control" type="date" v-model="student.birthday">
                                            <has-error :form="student" field="birthday"></has-error>
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
                                            <has-error :form="student" field="bloodGroup"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Nationality</label>
                                            <select class="form-control" type="text" v-model="student.nationality">
                                                <option selected value="IN">Indian</option>
                                            </select>
                                            <has-error :form="student" field="nationality"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea :disabled="naive.filled" :readonly="naive.filled"
                                                      class="form-control" id="address" rows="5"
                                                      v-model="student.address"></textarea>
                                            <has-error :form="student" field="address"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Whatsapp Number</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled"
                                                   class="form-control" data-mask="9999999999" id="alt-mobile"
                                                   type="text" v-model="student.altMobile">
                                            <has-error :form="student" field="altMobile"></has-error>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Group ID</label>
                                            <input :disabled="naive.filled" :readonly="naive.filled"
                                                   class="form-control" id="group" readonly type="number" value="">
                                            <has-error :form="student" field="group"></has-error>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <div class="form-actions">
                                    <button :disabled="student.busy" @click="addUser"
                                            class="btn btn-primary" id="btn-fullpay" type="submit"><i
                                        class="fa fa-check"></i> Add Now
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
    import {
        Form,
        HasError,
        AlertError,
        AlertErrors,
        AlertSuccess
    } from 'vform';
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
                    nationality: null,
                    bloodGroup: null,
                    birthday: null,
                    school:null,
                    branch:null,
                    remember: false,
                }),
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
            addUser()
            {
                this.student.delete('/api/put/user/var/add-delete').then(res=>{
                    if(res.data.result=='success')
                    {
                        swal.fire('Success','Enrollment into the Organization Successful','success');
                    }
                    else swal.fire('Error','Error Processing your data','error');
                })
            }
        },
        mounted() {
        }
    }
</script>
<style>
    .invalid-feedback{
        display: list-item;
    }
</style>
