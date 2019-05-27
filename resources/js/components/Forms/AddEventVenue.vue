<template>
    <div id="add-venue">
        <div id="add-venue-main">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info" id="mains">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Add New Venue</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="save" method="post">
                        <div class="form-body">
                            <h3 class="card-title">Basic Information</h3>
                            <hr>
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Venue Name</label>
                                        <input class="form-control" id="eventName" placeholder="Block 14 Lecture Hall 1" required type="text" v-model="venue.name">
                                        <small class="form-control-feedback">Name of the Venue for Identification</small> </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Maximum Capacity</label>
                                        <input class="form-control" id="maximumCapacity" placeholder="100" required type="number" v-model="venue.capacity" value="100">
                                        <small class="form-control-feedback"> Define maximum seats for the event </small> </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Coordinators Required</label>
                                        <input class="form-control" id="coordinatorsRequired" placeholder="1" required type="number" v-model="venue.coordinatorsRequired" value="1">
                                        <small class="form-control-feedback">Coordinators Required to Handle the Venue </small> </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Booking Price</label>
                                        <div class="input-group bootstrap-touchspin"><span class="input-group-addon bootstrap-touchspin-prefix">₹</span><input class="form-control" id="tch2" required type="text" v-model="venue.price"  ></div><small class="form-control-feedback">By Default cost of the venue is 0</small></div></div></div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <h3 class="box-title m-t-40">Venue Details</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label>Venue Type</label>
                                    <select class="form-control" id="venueTypeList" required v-model="venue.type">
                                        <option selected value="1">Normal Classroom</option>
                                        <option value="2">BYOD</option>
                                    </select><small>Choose the appropriate type of the Venue</small>
                                </div>
                            </div><div class="col-md-6 ">
                            <div class="form-group">
                                <label>Location Line 1</label>
                                <input class="form-control" id="locationLine1" type="text" v-model="venue.primaryAddressLine"><small>This will be sent to the Participants</small>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location Line 2</label>
                                    <input class="form-control" id="locationLine2" type="text" v-model="venue.secondaryAddressLine">
                                    <small class="form-control-feedback"></small>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location Line 3</label>
                                    <input class="form-control" id="locationLine3" type="text" v-model="venue.tertiaryAddressLine">
                                    <small class="form-control-feedback"></small>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Short Address</label>
                                    <input class="form-control" id="shortAddress" type="text" v-model="venue.shortAddress">
                                    <small class="form-control-feedback"></small>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="form-actions">
                            <button class="btn btn-success" type="submit"> <i class="fa fa-check"></i> Save</button>
                            <button class="btn btn-inverse" type="reset">Cancel</button>
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
                venue : new Form({
                    type: null,
                    name:null,
                    primaryAddressLine: null,
                    secondaryAddressLine: null,
                    tertiaryAddressLine: null,
                    shortAddress: null,
                    capacity: null,
                    price: 0.0,
                    coordinatorsRequired: 1,
                }),
            }
        },

        methods:{
            save(){
                this.venue.post('/api/venue').then((data)=>
                {
                    console.log(data);
                })
                //()=>{}
            }
        }
    }
</script>

<style scoped>

</style>
