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
                    <form method="post" @submit.prevent="save">
                        <div class="form-body">
                            <h3 class="card-title">Basic Information</h3>
                            <hr>
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Venue Name</label>
                                        <input v-model="venue.name" type="text" id="eventName" class="form-control" placeholder="Block 14 Lecture Hall 1" required>
                                        <small class="form-control-feedback">Name of the Venue for Identification</small> </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Maximum Capacity</label>
                                        <input v-model="venue.capacity" type="number" id="maximumCapacity" class="form-control" required placeholder="100" value="100">
                                        <small class="form-control-feedback"> Define maximum seats for the event </small> </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Coordinators Required</label>
                                        <input v-model="venue.coordinatorsRequired" type="number" id="coordinatorsRequired" class="form-control" required placeholder="1" value="1">
                                        <small class="form-control-feedback">Coordinators Required to Handle the Venue </small> </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Booking Price</label>
                                        <div class="input-group bootstrap-touchspin"><span class="input-group-addon bootstrap-touchspin-prefix">₹</span><input v-model="venue.price" id="tch2" type="text" class="form-control" required  ></div><small class="form-control-feedback">By Default cost of the venue is 0</small></div></div></div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <h3 class="box-title m-t-40">Venue Details</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label>Venue Type</label>
                                    <select required class="form-control" id="venueTypeList" v-model="venue.type">
                                        <option value="1" selected>Normal Classroom</option>
                                        <option value="2">BYOD</option>
                                    </select><small>Choose the appropriate type of the Venue</small>
                                </div>
                            </div><div class="col-md-6 ">
                            <div class="form-group">
                                <label>Location Line 1</label>
                                <input type="text" id="locationLine1" class="form-control" v-model="venue.primaryAddressLine"><small>This will be sent to the Participants</small>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location Line 2</label>
                                    <input type="text" class="form-control" id="locationLine2" v-model="venue.secondaryAddressLine">
                                    <small class="form-control-feedback"></small>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location Line 3</label>
                                    <input type="text" id="locationLine3" class="form-control" v-model="venue.tertiaryAddressLine">
                                    <small class="form-control-feedback"></small>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Short Address</label>
                                    <input type="text" class="form-control" id="shortAddress" v-model="venue.shortAddress">
                                    <small class="form-control-feedback"></small>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <button type="reset" class="btn btn-inverse">Cancel</button>
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