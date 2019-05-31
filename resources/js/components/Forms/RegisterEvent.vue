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
                            <form  method="post" class="form-material">
                                <div class="form-body">
                                    <h3 class="card-title">Basic Information</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input class="form-control" id="eventName" placeholder="XYZ Event"
                                                       required type="text">
                                                <small class="form-control-feedback">Proposed Name of the Event</small>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Start Date</label>
                                                <!--				form-group has-danger/has-success									form-control-danger-->
                                                <div class="input-daterange input-group" id="event-dates">
                                                    <input class="form-control" id="start_date" name="start" required
                                                           type="datetime-local"><span
                                                    class="input-group-addon bg-info b-0 text-white">to</span><input
                                                    class="form-control" id="end_date" name="end" type="datetime-local">
                                                </div>
                                                <small class="form-control-feedback">Proposed Span of the Event</small>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">Seats</label>
                                                <input class="form-control" id="maxseats" placeholder="100" required
                                                       type="number" value="100">
                                                <small class="form-control-feedback"> Define maximum seats for the
                                                    event
                                                </small>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Ticket Price</label>
                                                <div class="input-group bootstrap-touchspin"><span
                                                    class="input-group-addon bootstrap-touchspin-prefix">₹</span><input
                                                    class="form-control" id="tch2" required type="text"></div>
                                                <small class="form-control-feedback"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Support Mobile Number</label>
                                            <input class="form-control" id="mobile" placeholder="" required type="text">
                                            <small class="form-control-feedback">It will be sent to the participants for
                                                queries
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Seat Reservation Charges</label>
                                            <div class="input-group bootstrap-touchspin"><input class="form-control"
                                                                                                id="minimumTicketPricePercentage"
                                                                                                placeholder="100%"
                                                                                                value="100"><span
                                                class="input-group-addon bootstrap-touchspin-prefix">%</span></div>
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
                                                    <input checked="" id="approverFillingStatus" type="checkbox"><span
                                                        class="lever"></span>Done</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label>Approval Date</label>
                                            <input class="form-control bootstrapMaterialDatePicker" type="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" id="approverName" type="number">
                                            <small class="form-control-feedback"> Name of Approving Authority</small>

                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mobile Number</label>
                                            <input class="form-control" id="approverMobile" type="number">
                                            <small class="form-control-feedback"> Mobile Number of Approving Authority
                                                required in case of any problem during event
                                            </small>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" id="approverEmail" type="email">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input class="form-control" id="approverAddress" type="textarea">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <h3 class="box-title m-t-40">Schedule of Event</h3>
                                <hr>
                                <div id="date_list"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-info" id="genrate_dates_button" onClick="genrate_dates()"
                                                type="button">Fetch Dates for Scheduling
                                        </button>
                                    </div>

                                </div>

                                <h3 class="box-title m-t-40">Details and Description</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" id="description" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>

                                <div class="form-actions">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Save
                                    </button>
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
        data() {
            return
            {

            }
        },
        methods:
            {

            },
        mounted() {

        }
    }
</script>

<style scoped>

</style>
