<template>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Change Team</h4>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="sendForm" class="form-material" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)">
                                <div class="form-body">
                                    <h3 class="card-title">Enter Team Details</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <!--row1-->
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Registration Number</label>
                                                <input v-model="regNo" @change="findEvent" @tab="findEvent" name="regNo" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('regNo') }">

                                                <has-error :form="form" field="regNo"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->


                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select Event</label>
                                                <select type="text" @change="findTeam" @tab="findTeam" name="eventID" v-model="form.eventID" class="form-control" :class="{ 'is-invalid': form.errors.has('eventID') }">
                                                    <option v-bind:value="event.id" v-for="event in eventList">
                                                        {{ event.name }}
                                                    </option>

                                                </select>
                                                <has-error :form="form" field="eventID"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->

                                        <!--row1-->



                                    </div>
                                    <!--/row-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Current Team : {{currentTeamName}}</label>
                                            <!--<textarea  id="description" v-model="form.description" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>-->
                                            <!--<has-error :form="form" field="description"></has-error>-->
                                        </div>
                                    </div>


                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Team</label>
                                            <select type="text" name="newTeamID" v-model="form.newTeamID" class="form-control" :class="{ 'is-invalid': form.errors.has('newTeamID') }">
                                                <option v-bind:value="team.id" v-for="team in teamList">
                                                    {{ team.name }}
                                                </option>

                                            </select>
                                            <has-error :form="form" field="newTeamID"></has-error>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>


                                <div class="form-actions">
                                    <button class="btn btn-success" id="sub" type="submit"> <i class="fa fa-check"></i> Change Team</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

</template>

<script>
    export default {
        data(){
            return{
                eventList: [],
                teamList: [],
                currentTeamName: '',
                regNo: '',

                form: new Form({

                    eventID: '',

                    newTeamID: '',
                })
            }
        },

        methods: {
            sendForm() {
                // Submit the form via a POST request
                //todo: reset form
                this.form.post('/api/put/user/data/newTeam').then(response => {
                    console.log(response);
                    swal.fire({
                        title: 'Bravo!',
                        html: 'You have successfully changed team to<b>' + this.form.newTeamName + '</b>',
                        type: 'success',
                        backdrop: 'rgba(0, 0, 123, 0.4)',
                    })
                });
            },


            findEvent(){
                axios.post('/api/events/enrollment/find/events', {regNo:this.$data.regNo})
                    .then((response)=>{
                            this.$data.eventList = response.data;


                        },
                        error=>{});

            },

            findTeam(){
                axios.post('/api/find/enrolled/teams', {regNo : this.$data.form.regNo, eventID: this.$data.form.eventID})
                    .then(response=>{
                            this.$data.teamList = response.data;


                        },
                        error=>{});

            },



        },
        //todo: anu create function for filtering non teaming events
        mounted(){
            // axios({
            //     method: 'post',
            //     url: '/api/events/find/teamable/',
            // }).then((response)=> {
            //     console.log(response);
            //     this.$data.eventList = response.data;
            // })
            //     .catch((error) => {
            //         console.log(error);
            //     });
        }
    }
</script>
