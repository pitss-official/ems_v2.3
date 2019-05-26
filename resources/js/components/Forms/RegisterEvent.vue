<template>
    <div id="register-event">
        <div id="register-event-card">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info" id="mains">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Add New Event</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="javascript:addEvent();">
                                <div class="form-body">
                                    <h3 class="card-title">Basic Information</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input type="text" id="eventName" class="form-control" placeholder="XYZ Event" required>
                                                <small class="form-control-feedback">Proposed Name of the Event</small> </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label class="control-label">Start Date</label>
                                                <!--				form-group has-danger/has-success									form-control-danger-->
                                                <div class="input-daterange input-group" id="date-range"><input type="datetime" id="start_date" class="form-control" name="start" required><span class="input-group-addon bg-info b-0 text-white">to</span><input class="form-control" id="end_date" name="end"></div>
                                                <small class="form-control-feedback">Proposed Span of the Event</small> </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">Seats</label>
                                                <input type="number" id="maxseats" class="form-control" required placeholder="100" value="100">
                                                <small class="form-control-feedback"> Define maximum seats for the event </small> </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Ticket Price</label>
                                                <div class="input-group bootstrap-touchspin"><span class="input-group-addon bootstrap-touchspin-prefix">₹</span><input id="tch2" type="text" class="form-control" required  ></div>
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Support Mobile Number</label>
                                            <input type="text" id="mobile" class="form-control" placeholder="" required>
                                            <small class="form-control-feedback">It will be sent to the participants for queries</small> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Seat Reservation Charges</label>
                                            <div class="input-group bootstrap-touchspin"><input class="form-control" id="minimumTicketPricePercentage" placeholder="100%" value="100"><span class="input-group-addon bootstrap-touchspin-prefix">%</span></div>
                                            <small class="form-control-feedback">In Percentage</small>
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                                <h3 class="box-title m-t-40">Approval Details (Optional)</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label>Approval Filling</label>
                                            <div class="switch">
                                                <label>Check if the Proposal is filed in the approval department
                                                    <input type="checkbox" checked="" id="approverFillingStatus"><span class="lever"></span>Done</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label>Approval Date</label>
                                            <input type="text" id="date-format" class="form-control bootstrapMaterialDatePicker">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="number" class="form-control" id="approverName">
                                            <small class="form-control-feedback"> Name of Approving Authority </small>

                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mobile Number</label>
                                            <input type="number" id="approverMobile" class="form-control" >
                                            <small class="form-control-feedback"> Mobile Number of Approving Authority required in case of any problem during event </small>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div><div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="approverEmail">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="textarea" class="form-control" id="approverAddress">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                                <!--/row-->
                                <h3 class="box-title m-t-40">Schedule of Event</h3>
                                <hr>
                                <div id="date_list"></div>
                                <div class="row">
                                    <div class="col-md-12"><button type="button" class="btn btn-info" id="genrate_dates_button" onClick="genrate_dates()">Fetch Dates for Scheduling</button></div>

                                </div>

                                <h3 class="box-title m-t-40">Details and Description</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea rows="10" class="form-control" id="description"></textarea>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>

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
        data()
        {
            return
            {

            }
        },
        methods:
            {

            },
        name: "register-event"
    }
</script>

<style scoped>

</style>