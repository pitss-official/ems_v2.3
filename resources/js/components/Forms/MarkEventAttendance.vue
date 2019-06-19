<template>
    <div class="studentAttendanceView" id="eventAttendance">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-info" id="mains">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Student Attendance Form</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="pull-left">
                                    <label>Date</label>
                                    <input @change="getEvents" type="date" v-model="selectedDate"/>
                                </div>
                                <div class="pull-left">
                                    <label>Event</label>
                                    <select @change="findMembers" id="eventSelect" name="selectEvent"
                                            v-model="selectedEvent">
                                        <option v-bind:value="event.eventID" v-for="event in events">
                                            {{ event.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                        <table id="students-table" class="display table table-hover table-striped table-bordered"
                               cellspacing="0" width="100%">
                        </table>
                        <div class="row" id="actions">
                            <div class="col-lg-6">
                            <button class="btn btn-themecolor waves waves-dark" @click="markAttendance">Mark Attendance</button>
                            <button class="btn btn-inverse" onclick="location.reload()">Refresh Page</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    let presentStudents = [];
    export default {
        name: "MarkEventAttendance",
        data() {
            return {
                selectedDate: moment().format('YYYY-MM-DD'),
                selectedEvent: null,
                events: [],
            };
        },
        methods:
            {
                getEvents() {
                    axios({
                        method: 'get',
                        url: '/api/events/all/onDate/' + this.$data.selectedDate,
                    }).then((response) => {
                        this.$data.events = response.data
                    }).catch((response) => {
                        swal.fire('Server Error', 'Kindly Contact the Server Admin', 'error');
                    });
                },
                findMembers() {
                    if(this.$data.selectedEvent===null)
                        return;
                    this.getStudents();
                },
                getStudents() {
                    axios({
                        method: 'get',
                        url: '/api/events/' + this.$data.selectedEvent + '/find/participants',
                    }).then((response) => {
                        let usableDataSet = [];
                        let schools = {
                            A: 'Lovely School of Architecture and Design',
                            B: 'School of Bio Engineering and Bio Sciences',
                            C: 'School of Civil Engineering',
                            D: 'School of Computer Application',
                            E: 'School of Electronics and Electrical Engineering',
                            F: 'School of Journalism, Films & Creative Arts',
                            G: 'School of Chemical Engineering and Physical Sciences',
                            K: 'School of Computer Science and Engineering',
                            L: 'School of Law',
                            M: 'School of Mechanical Engineering',
                            P: 'School of Professional Enhancement',
                            Q: 'School of Business',
                            R: 'School of Hotel Management and Tourism',
                            S: 'School of Fashion Design',
                            U: 'School of Arts and Languages',
                            Y: 'LIT (Pharmacy)/Department of Pharmaceutical Sciences',
                            Z: 'School of Physiotherapy & Paramedical',
                        };
                        let rowArr = response.data;
                        for (let j = 0; j < response.data.length; j++) {
                            let name = rowArr[j].firstName;
                            let state = '';
                            if (rowArr[j].middleName != null)
                                name += ' ' + rowArr[j].middleName;
                            if (rowArr[j].lastName != null)
                                name += ' ' + rowArr[j].lastName;
                            if (parseFloat(rowArr[j].balance) < 0)
                                state = 'disabled="disabled" readonly="readonly" class="attendance-checkbox-disabled"';
                            else state = 'class="attendance-checkbox-default'
                            let btn = '<input type="checkbox" ' + state + ' data-switch-id="' + j + '" data-collegeID="' + rowArr[j].collegeUID + '" data-enrollmentID="'+rowArr[j].id+'">';
                            usableDataSet.push([j + 1, rowArr[j].collegeUID, name, schools[rowArr[j].school] + ', ' + rowArr[j].branch,rowArr[j].teamName, rowArr[j].balance, btn]);
                        }
                        var table=$('#students-table').DataTable({
                            data: usableDataSet,
                            responsive: true,
                            dom: 'Bform',
                            buttons: [
                                {
                                    extend: 'pdf',
                                    className: 'btn btn-themecolor waves-effect waves-dark'
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn btn-themecolor waves-effect waves-dark'
                                },
                                {
                                    extend: 'print',
                                    className: 'btn btn-themecolor waves-effect waves-dark'
                                },
                                {
                                    extend: 'colvis',
                                    className: 'btn btn-themecolor waves-effect waves-dark',
                                    collectionLayout: 'fixed two-column'
                                },
                                {
                                    extend: 'copy',
                                    className: 'btn btn-themecolor waves-effect waves-dark'
                                },
                                {
                                    extend: 'excel',
                                    className: 'btn btn-themecolor waves-effect waves-dark'
                                }
                            ],
                            "drawCallback": function ( settings ) {
                                var api = this.api();
                                var rows = api.rows( {page:'current'} ).nodes();
                                var last=null;

                                api.column(4, {page:'current'} ).data().each( function ( group, i ) {
                                    if ( last !== group ) {
                                        $(rows).eq( i ).before(
                                            '<tr class="group"><td colspan="6" class="list-group-item-secondary">'+group+'</td></tr>'
                                        );

                                        last = group;
                                    }
                                } );
                            },
                            select: true,
                            paging: true,
                            pagingType: 'simple',
                            "columnDefs": [
                                {
                                    "orderable": false,
                                    "targets": [0, 1, 3]
                                },
                                { "visible": false, "targets": 4 },
                                {
                                    render: function (data, type, full, meta) {
                                        return "<div class='text-wrap width-100'>" + data + "</div>";
                                    },
                                    targets: 3
                                }
                            ],
                            "order": [[0, "asc"]],
                            fixedHeader: {
                                header: true,
                            },
                            columns: [
                                {title: "Sr.", responsivePriority: 5, targets: 0},
                                {title: "Registration Number", responsivePriority: 5},
                                {title: "Name", responsivePriority: 5},
                                {title: "School and Branch", responsivePriority: 10},
                                {title: "Team", responsivePriority: 10},
                                {title: "Balance", responsivePriority: 10},
                                {title: "Action", responsivePriority: 1},
                            ],
                        });
                        $('#students-table tbody').on( 'click', 'tr.group', function () {
                            var currentOrder = table.order()[0];
                            if ( currentOrder[0] === 4 && currentOrder[1] === 'asc' ) {
                                table.order( [ 4, 'desc' ] ).draw();
                            }
                            else {
                                table.order( [ 4, 'asc' ] ).draw();
                            }
                        } );
                        $('.attendance-checkbox-default').bootstrapSwitch({
                            animate: true,
                            onInit: function (event, state) {

                            },
                            onSwitchChange: function (event, state) {
                                if (state === true) {
                                    if (presentStudents.filter(student => student.collegeUID === event.delegateTarget.dataset.collegeid).length === 0) {
                                        presentStudents.push({collegeUID: event.delegateTarget.dataset.collegeid,enrollmentID:event.delegateTarget.dataset.enrollmentid})
                                    }
                                } else {
                                    presentStudents = presentStudents.filter(student => student.collegeUID != event.delegateTarget.dataset.collegeid);
                                }
                            },
                            onText: 'PRESENT',
                            offText: 'ABSENT',
                            onColor: 'success',
                            offColor: 'danger'
                        });
                        $('.attendance-checkbox-disabled').bootstrapSwitch(
                            {
                                onColor: 'danger',
                                offColor: 'warning',
                                onText: 'Blocked',
                                offText: 'Blocked',
                                disabled: true,
                                readonly: true,
                            }
                        );
                        $("#actions").show();
                    });
                },
                markAttendance() {
                    swal.fire({
                        title: 'Head Count',
                        input: 'number',
                        type: 'question',
                        text: 'Kindly perform head count manually and enter the number of present students',
                        inputAttributes: {
                            type:'number',
                            autocapitalize: 'on'
                        },
                        showCancelButton: true,
                        allowOutsideClick: () => false,
                        confirmButtonText: 'I Confirm',
                        showLoaderOnConfirm: true,
                        preConfirm: (value) => {
                            return axios.post('/api/events/put/attendance/request', {
                                headcount: value,
                                event: this.$data.selectedEvent,
                                dateid:this.$data.events.find(event=>event.eventID===this.$data.selectedEvent)['id'],
                                students: presentStudents
                            }).then(response => {
                                return response;
                            })
                                .catch(error => {
                                    Swal.showValidationMessage(
                                        error.response.data.message
                                    )
                                });
                            return value;
                        },
                    }).then(value=>{
                        let data=value.value.data;
                        if(data.result=="success")
                        {
                            swal.fire("Attendance Marked","Attendance has been successfully mapped for verification",'success').then();
                        }
                    })
                }
            },
        mounted() {
            $("#actions").hide();
            this.getEvents();
        },
        beforeMount()
        {
        }
    }
</script>
<style scoped>
    .text-wrap {
        white-space: normal;
    }

    .width-100 {
        width: 100px;
    }
    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
    }
</style>