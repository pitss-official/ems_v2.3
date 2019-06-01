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
                            <alert-errors :form="event"></alert-errors>
                            <form class="form-material" @submit.prevent="save">
                                <div class="form-body">
                                    <h3 class="card-title">Basic Information</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input class="form-control" id="eventName" placeholder="XYZ Event"
                                                       required type="text" v-model="event.eventName">
                                                <small class="form-control-feedback">Proposed Name of the Event</small>
                                                <has-error :form="event" field="eventName"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Start Date</label>
                                                <!--				form-group has-danger/has-success									form-control-danger-->
                                                <div class="input-daterange input-group" id="event-dates">
                                                    <input class="form-control" id="start_date" name="start" required
                                                           type="date" @change="date_change" v-model="event.startDate"><span
                                                    class="input-group-addon bg-info b-0 text-white">to</span><input
                                                    class="form-control" id="end_date" @change="date_change" name="end" v-model="event.endDate" type="date">
                                                </div>
                                                <small class="form-control-feedback">Proposed Span of the Event</small>
                                                <has-error :form="event" field="startDate"></has-error><has-error :form="event" field="endDate"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label class="control-label">Seats</label>
                                                <input class="form-control" id="maxseats" v-model="event.seats" placeholder="100" required
                                                       type="number" value="100">
                                                <small class="form-control-feedback"> Define maximum seats for the event</small>
                                                <has-error :form="event" field="seats"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Ticket Price</label>
                                                <div class="input-group bootstrap-touchspin"><span
                                                    class="input-group-addon bootstrap-touchspin-prefix">₹</span><input
                                                    class="form-control" id="tch2" required type="text" v-model="event.ticketPrice"></div>
                                                <small class="form-control-feedback"></small>
                                                <has-error :form="event" field="ticketPrice"></has-error>
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
                                            <input class="form-control" id="mobile" placeholder="" required type="text" v-model="event.mobile">
                                            <small class="form-control-feedback">It will be sent to the participants for
                                                queries
                                            </small><has-error :form="event" field="mobile"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Seat Reservation Charges</label>
                                            <div class="input-group bootstrap-touchspin"><input class="form-control"
                                                                                                id="minimumTicketPricePercentage"
                                                                                                placeholder="100%" v-model="event.reservationCharges"
                                                                                                value="100"><span
                                                class="input-group-addon bootstrap-touchspin-prefix">%</span></div>
                                            <small class="form-control-feedback">In Percentage</small>
                                            <has-error :form="event" field="reservationCharges"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="datePannel">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Schedule of Event</h4>
                                                <h6 class="card-subtitle">Plan the event dates</h6>
                                                <hr>
                                                <!-- Nav tabs -->
                                                <div class="vtabs">
                                                    <ul class="nav nav-tabs tabs-vertical" role="tablist" id="computed_1">
                                                        <li class="nav-item" v-for="item in dates">
                                                            <a class="nav-link" :class="{'active': item.id==1}" data-toggle="tab" v-bind:href="'#t'+item.id" role="tab">
                                                                <span class="hidden-sm-up"><i class="ti-home"></i></span>
                                                                <span class="hidden-xs-down">{{item.date.format('ddd, MMM DD')}}</span> </a>
                                                        </li>
                                                    </ul>
                                                    <!-- Tab panes -->
                                                    <div class="tab-content" id="computed_2">
                                                        <div class="tab-pane" :class="{'active': item.id==1}" v-bind:id="'t'+item.id" v-for="item in dates" role="tabpanel">
                                                            <h3>{{item.date.format('dddd, MMMM DD, YYYY')}}</h3>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Enter a title or Subject for day of event</label>
                                                                        <input type="text" placeholder="" class="form-control">
                                                                        <small class="form-control-feedback">Motive of the day</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="time" class="form-control">
                                                                    <small class="form-control-feedback">Start Time</small>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="time" class="form-control">
                                                                    <small class="form-control-feedback">End Time</small>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <textarea type="text" cols="2" placeholder="" class="form-control date-discription"></textarea>
                                                                    <small class="form-control-feedback">Description of the day</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-info" id="genrate_dates_button"
                                                @click.prevent="genrate_dates"
                                                type="button">Fetch Dates for Scheduling
                                        </button>
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
                                                    <input checked="" v-model="event.approvalFiling" id="approverFillingStatus" type="checkbox"><span
                                                        class="lever"></span>Done</label>
                                                <has-error :form="event" field="approvalFiling"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label>Approval Date</label>
                                            <input v-model="event.approvalDate" class="form-control bootstrapMaterialDatePicker" type="date">
                                            <has-error :form="event" field="approvalDate"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" v-model="event.approverName" id="approverName" type="text">
                                            <small class="form-control-feedback"> Name of Approving Authority</small>
                                            <has-error :form="event" field="approverName"></has-error>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mobile Number</label>
                                            <input class="form-control" id="approverMobile" v-model="event.approverMobile" type="number">
                                            <small class="form-control-feedback"> Mobile Number of Approving Authority
                                                required in case of any problem during event
                                            </small>
                                            <has-error :form="event" field="approverMobile"></has-error>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" id="approverEmail" v-model="event.approverEmail" type="email">
                                            <has-error :form="event" field="approverEmail"></has-error>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input class="form-control" id="approverAddress" type="textarea" v-model="event.approverAddress">
                                            <has-error :form="event" field="approverAddress"></has-error>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <h3 class="box-title m-t-40">Details and Description</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" id="description" rows="10" v-model="event.description"></textarea>
                                            <has-error :form="event" field="description"></has-error>
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
            return {
                dates: [],
                event:new Form({
                    eventName:'',
                    startDate:'',
                    endDate:'',
                    description: '',
                    seats:'',
                    ticketPrice:'',
                    supportMobile:'',
                    reservationCharges:'',
                    approvalFiling:'',
                    approvalDate:'',
                    approverName:'',
                    approverMobile:'',
                    approverAddress:'',
                    approverEmail:'',
                    dates:[],
                    }),
            }
        },
        methods:
            {
                save()
                {
                    console.log(this.$data.event);
                    console.log(this.$data.dates);
                    this.$data.event.dates=this.$data.dates;
                    this.event.post('/api/forms/events/').then(response => {
                        console.log(response);
                    });
                },

                date_change()
                {
                    $("#datePannel").hide();
                },
                genrate_dates() {
                    //TODO:TIME PRECISION REQ. DAYWISE WITH VARIABLE SLOTS
                    $("#computed_1").html("");
                    $("#computed_2").html("");
                    if ($("#start_date").val() == "") {
                        swal.fire('Empty Event Dates', 'Please choose the event start and end dates before fetching the inbetween dates for scheduling', 'error');
                        return;
                    }
                    var start = new Date($("#start_date").val()),
                        end = new Date($("#end_date").val()),
                        currentDate = new Date(start), total = 0;
                    if(end<currentDate) {
                        Swal.fire("Invalid Event Dates", "Correct the event dates and try again", "error");
                        return;
                    }
                    $("#datePannel").show();
                    while (currentDate <= end) {
                        total++;
                        this.$data.dates.push({
                            id: total,
                            date: moment(new Date(currentDate)),
                            startTime: '',
                            endTime: '',
                            motive: '',
                            description: '',
                        });
                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    //todo:enrollement should show errors and runtime warnings
                    Toast.fire({
                        title: "Done",
                        type: 'success',
                        position: 'top-end',
                        timer: 2500,
                    });
                    // $('input[type=text], textarea').autogrow();
                }
            },
        mounted() {
            $("#datePannel").hide();
        },
        beforeMount() {

        }
    }
</script>
<style scoped>
    .date-discription {
        white-space: pre-wrap;
    }
</style>
