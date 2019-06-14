<template>
    <div id="money-transfer">
        <div id="money-transfer-main">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Add New Team</h4>
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
                                                <label class="control-label">Team Name</label>
                                                <input v-model="form.teamName" name="teamName" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('teamName') }">
                                                <small class="form-control-feedback">Write team name</small>
                                                <has-error :form="form" field="teamName"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->


                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Event</label>
                                                <select type="text" name="eventID" v-model="form.eventID" class="form-control" :class="{ 'is-invalid': form.errors.has('eventID') }">
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Description</label>
                                            <textarea  id="description" v-model="form.description" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                                            <has-error :form="form" field="description"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button class="btn btn-success" id="sub" type="submit"> <i class="fa fa-check"></i> Create Team</button>
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
        data(){
            return{
            eventList: [],

            form: new Form({
                teamName: '',
                eventID: '',
                description: '',
            })
            }
        },

        methods: {
            sendForm() {
                // Submit the form via a POST request
                //todo: reset form
                this.form.post('/api/forms/events/team').then(response => {
                    console.log(response);
                    swal.fire({
                        title: 'Bravo!',
                        html: 'You have successfully registered team <b>' + this.form.teamName + '</b>',
                        type: 'success',
                        backdrop: 'rgba(0, 0, 123, 0.4)',
                    })
                });
            },
        },
        //todo: anu create function for filtering non teaming events
        mounted(){
            axios({
                method: 'post',
                url: '/api/events/find/teamable/',
            }).then((response)=> {
                console.log(response);
                this.$data.eventList = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
        }
    }
</script>
