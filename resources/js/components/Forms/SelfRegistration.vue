<template>
    <form-wizard @on-complete="onComplete" transition="bounce" slot="step" class="wizard" shape="tab"
                         color="#3490dc">
                <h2 slot="title"></h2>
                <tab-content title="Event details" :before-change="validateStep1" icon="mdi mdi-golf">
                    <h2></h2>
                    <section>

                        <div class="card-body">
                            <form class="form-material">
                                <div class="form-body">
                                    <h3 class="card-title">Event Details</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <!--row1-->
                                        <!--/span-->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Choose event</label>
                                                <select type="text" v-model="form.event" id="eventsList" @change="selectEvent" class="form-control" :class="{ 'is-invalid': form.errors.has('event') }">
                                                    <option selected>Loading...</option>
                                                    <option v-bind:value="event.id" v-for="event in events">
                                                        {{ event.name }}
                                                    </option>

                                                </select>
                                                <has-error :form="form" field="event"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </section>
                </tab-content>

        <!--tab starts-->
        <tab-content title="Personal details" :before-change="validateStep1" icon="mdi mdi-golf">
            <h2></h2>
            <section>

                <div class="card-body">
                    <form class="form-material">
                        <div class="form-body">
                            <h3 class="card-title">Personal Details</h3>
                            <hr>
                            <div class="row p-t-20">
                                <!--row1-->

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">First Name</label>
                                        <input v-model="form.firstName" name="firstName" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('firstName') }">
                                        <has-error :form="form" field="firstName"></has-error>
                                    </div>
                                </div>
                                <!--/span-->

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Middle Name</label>
                                        <input v-model="form.middleName" name="middleName" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('middleName') }">
                                        <has-error :form="form" field="middleName"></has-error>
                                    </div>
                                </div>
                                <!--/span-->
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Last Name</label>
                                        <input v-model="form.lastName" name="lastName" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('lastName') }">
                                        <has-error :form="form" field="lastName"></has-error>
                                    </div>
                                </div>
                                <!--/span-->

                                <!--row1 ends-->


                                    <!--row2 ends-->

                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Father's Name</label>
                                            <input v-model="form.fathersName" name="fathersName" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('fathersName') }">
                                            <has-error :form="form" field="fathersName"></has-error>
                                        </div>
                                    </div>
                                    <!--/span-->

                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Registration Number</label>
                                            <input v-model="form.regid" name="regid" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('regid') }">
                                            <has-error :form="form" field="regid"></has-error>
                                        </div>
                                    </div>
                                    <!--/span-->

                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Gender</label>
                                            <select type="text" name="gender" class="form-control" v-model="form.gender" :class="{ 'is-invalid': form.errors.has('gender') }">
                                                <option value="0">Male</option>
                                                <option value="1">Female</option>
                                                <option value="2">Other</option>
                                            </select>
                                            <has-error :form="form" field="gender"></has-error>
                                        </div>
                                    </div>
                                    <!--/span-->

                            </div>
                        </div>
                    </form>
                </div>


            </section>
        </tab-content>

        <!--tab ends-->








        <!--tab starts-->
        <tab-content title="Other details" :before-change="validateStep1" icon="mdi mdi-golf">
            <h2></h2>
            <section>

                <div class="card-body">
                    <form class="form-material">
                        <div class="form-body">
                            <h3 class="card-title">Other Details</h3>
                            <hr>
                            <div class="row p-t-20">
                                <!--row1-->

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Email address</label>
                                        <input v-model="form.email" name="email" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                        <has-error :form="form" field="email"></has-error>
                                    </div>
                                </div>
                                <!--/span-->

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Mobile Number</label>
                                        <input v-model="form.mobile" name="mobile" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                                        <has-error :form="form" field="mobile"></has-error>
                                    </div>
                                </div>
                                <!--/span-->
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Whatsapp Number</label>
                                        <input v-model="form.whatsapp" name="whatsapp" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('whatsapp') }">
                                        <has-error :form="form" field="whatsapp"></has-error>
                                    </div>
                                </div>
                                <!--/span-->

                                <!--row1 ends-->


                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">School</label>
                                        <select type="text" name="school" class="form-control" v-model="form.school" :class="{ 'is-invalid': form.errors.has('school') }">
                                            <option value="A">Lovely School of Architecture and Design</option> <option value="B">School of Bio Engineering and Bio Sciences</option> <option value="C">School of Civil Engineering</option> <option value="D">School of Computer Application</option> <option value="E">School of Electronics and Electrical Engineering</option> <option value="F">School of Journalism, Films &amp; Creative Arts</option> <option value="G">School of Chemical Engineering and Physical Sciences</option> <option value="K">School of Computer Science and Engineering</option> <option value="L">School of Law</option> <option value="M">School of Mechanical Engineering</option> <option value="P">School of Professional Enhancement</option> <option value="Q">School of Business</option> <option value="R">School of Hotel Management and Tourism</option> <option value="S">School of Fashion Design</option> <option value="U">School of Arts and Languages</option> <option value="Y">LIT (Pharmacy)/Department of Pharmaceutical Sciences</option> <option value="Z">School of Physiotherapy &amp; Paramedical</option>

                                        </select>
                                        <has-error :form="form" field="gender"></has-error>
                                    </div>
                                </div>
                                <!--/span-->

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Course</label>
                                        <input v-model="form.course" name="course" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('course') }">
                                        <has-error :form="form" field="course"></has-error>
                                    </div>
                                </div>
                                <!--/span-->

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Team Name</label>
                                        <input v-model="form.teamName" name="teamName" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('teamName') }">
                                        <has-error :form="form" field="teamName"></has-error>
                                    </div>
                                </div>
                                <!--/span-->

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Payment Mode</label>
                                        <select v-model="form.smartMode" name="smartMode" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('smartMode') }">
                                        <option value="0">Smart Code</option>
                                        <option value="1">Google Pay</option>
                                        <option value="2">Paytm</option>
                                        </select><has-error :form="form" field="smartMode"></has-error>
                                    </div>
                                </div>
                                <!--/span-->



                            </div>
                        </div>
                    </form>
                </div>


            </section>
        </tab-content>

        <!--tab ends-->


















                <tab-content title="Payment Info" icon="mdi mdi-account-box" v-if="selectedEvent.ticketPrice>0" :before-change="validateStep5">
                    <!-- SECTION 1 -->
                    <section>
                        <div class="inner">
                            <div class="image-holder">
                                <img src="/images/reg/1.jpg" alt="">
                            </div>
                            <div class="form-content" v-if="form.smartMode==0">
                                <p><label>Smart Card Details</label></p>
                                <div class="form-row">
                                    <div class="form-holder" style="width: 20%">
                                        <input type="text" v-model="form.smartCode.A" placeholder="AAAAA" class="form-control">
                                    </div><div class="form-holder" style="width: 20%">
                                    <input type="text" v-model="form.smartCode.B" placeholder="AAAAA" class="form-control">
                                </div><div class="form-holder" style="width: 20%">
                                    <input type="text" v-model="form.smartCode.C" placeholder="AAAAA" class="form-control">
                                </div><div class="form-holder" style="width: 20%">
                                    <input type="text" v-model="form.smartCode.D" placeholder="AAAAA" class="form-control">
                                </div><div class="form-holder" style="width: 20%">
                                    <input type="text" v-model="form.smartCode.E" placeholder="AAAAA" class="form-control">
                                </div>
                                </div>
                            </div>
                            <div class="form-content" v-if="form.smartMode==1">
                                <p><label>Google Pay</label></p>
                                <div class="form-row">
                                    <img src="/payment/gpay.png" height="50px" width="50px">
                                </div>
                                <p><b>Rs. {{selectedEvent.ticketPrice}}</b></p>
                                <div class="form-row" >
                                    <div class="form-holder" style="width: 100%">
                                        <input type="number"  v-model="form.txCode" placeholder="Transaction Number*" class="form-control">
                                    </div>
                                </div>
                            </div><div class="form-content" v-if="form.smartMode==2">
                            <p><label>Paytm</label></p>
                            <div class="form-row">
                                <img src="/payment/paytm.png" height="50px" width="50px">
                            </div>
                            <p><b>Rs. {{selectedEvent.ticketPrice}}</b></p>
                            <div class="form-row" >
                                <div class="form-holder" style="width: 100%">
                                    <input type="number"  v-model="form.txCode" placeholder="Transaction Number*" class="form-control">
                                </div>
                            </div>
                        </div>
                        </div>
                    </section>
                </tab-content>
            </form-wizard>
</template>
<script>
    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'
    import '@mdi/font/css/materialdesignicons.min.css'
    export default {
        name: "SelfRegistration",
        data(){
            return{
                events:[],
                selectedEvent:{teaming:0},
                form: new Form({
                    firstName:null,
                    middleName:null,
                    lastName:null,
                    fathersName: null,
                    event:null,
                    email:null,
                    mobile:null,
                    whatsapp:null,
                    teamName:null,
                    regid:null,
                    gender:null,
                    school:null,
                    course:null,
                    country:'IN',
                    smartMode:null,
                    smartCode:{
                        A:null,
                        B:null,
                        C:null,
                        D:null,
                        E:null,
                    },
                    txCode:null,
                })
            }
        },
        methods:{
            validateStep1() {
                return new Promise((resolve, reject) => {
                    if(this.$data.form.event)
                    resolve(true);
                    else reject();
                })

            },validateStep2() {
                return new Promise((resolve, reject) => {
                    resolve(true);
                })

            },validateStep3() {
                return new Promise((resolve, reject) => {
                    resolve(true);
                })

            },validateStep4() {
                return new Promise((resolve, reject) => {
                    resolve(true);
                })

            },validateStep5() {
                return new Promise((resolve, reject) => {
                    resolve(true);
                })

            },
            selectEvent()
            {
                this.$data.selectedEvent=this.$data.events.find(event=>{return event.id==this.$data.form.event});
            },
            onComplete()
            {
                this.$data.form.post('/api/guest/register/self').then(res=>console.log(res.data))
                    .catch(res=>{swal.fire('Error Occurred',res.message,'error')});
            },
            fetchEvents(){
              axios.get('/api/guest/register/fetch/events')
                  .then(res=>{
                      if(res.data.length==0)
                          $('#eventsList').html('<option>No Events Available</option>');
                      else $('#eventsList').html('');
                      this.$data.events=res.data;
                  }).catch(res=>{$('#eventsList').html('<option>Error Fetching</option>');swal.fire('Error Occurred',res.message,'error')});

            },
        },
        mounted() {
            this.fetchEvents();
        }
    }
</script>
<style scoped>
</style>
