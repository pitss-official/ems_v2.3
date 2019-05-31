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
                            <form class="form-material" method="post">
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
                                                           type="date"><span
                                                    class="input-group-addon bg-info b-0 text-white">to</span><input
                                                    class="form-control" id="end_date" name="end" type="date">
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
                                        <button class="btn btn-info" id="genrate_dates_button" @click="genrate_dates"
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
    import moment from 'moment';
    export default {
        data() {
            return
            {

            }
        },
        methods:
            {
                genrate_dates(){
        if ($("#start_date").val() == "") {
            swal.fire('Empty Event Dates', 'Please choose the event start and end dates before fetching the inbetween dates for scheduling', 'error');
            return;
        }
        var start = $("#start_date").getDate(),
            end = $("#end_date").getDate(),
            currentDate = new Date(start),
            between = '<div class="row">', total = 0;
        console.log(start,end);

        while (currentDate <= end) {
            total++;
            var datee = new Date(currentDate);
            datee = moment(datee);
            between += '<div class="col-md-3"><div class="form-group"><input disabled readonly class="form-control" value="' + datee.format("dddd, MMMM Do YYYY") + '"><input value="' + datee.format("YYYY-MM-DD") + '" id="sc_dt_' + total + '" type="text" style="display:none" disabled readonly></div></div><div class="col-md-2"><div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true"><input placeholder="Start Time" type="text" id="sc_start_' + total + '" class="form-control"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span></div></div><div class="col-md-2"><div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true"><input type="text" placeholder="End Time" id="sc_end_' + total + '" class="form-control"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span></div></div><div class="col-md-5"><div class="form-group"><textarea rows="1" id="sc_desc_' + total + '" class="form-control" placeholder="Description of the day"></textarea></div></div>';
            currentDate.setDate(currentDate.getDate() + 1);
        }
        between += '</div>';
        $('#date_list').html(between);
        $('input[type=text], textarea').autogrow();
        // Clock pickers
        $('#single-input').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });
        $('.clockpicker').clockpicker({
            donetext: 'Done',
        }).find('input').change(function () {
            console.log(this.value);
        });
        $('#check-minutes').click(function (e) {
            // Have to stop propagation here
            e.stopPropagation();
            input.clockpicker('show').clockpicker('toggleView', 'minutes');
        });
    }
    },
    mounted()
    {

    }
    }
</script>

<style scoped>

</style>
