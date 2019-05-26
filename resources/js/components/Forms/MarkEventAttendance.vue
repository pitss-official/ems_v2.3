<template>
    <div id="eventAttendance" class="studentAttendanceView">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-info" id="mains">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Student Attendance Form</h4>
                    </div>
                    <div class="card-body">
        <div class="row">
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
                <div class="pull-right">
                    <div><b>Select Event</b>
                    </div>
                <select name="selectEvent" id="eventSelect" @change="findMembers" v-model="selectedEvent" >
                    <option v-for="event in events" v-bind:value="event.id">
                        {{ event.name }}
                    </option>
                </select>
                </div>
            </div>
        </div>
                        <table id="students-table" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        </table>
    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MarkEventAttendance",
        data()
        {
            return {
                naive:{
                    filled:false,
                },
                selectedEvent:null,
                events:[],
                teams:[],
                students:[],
                dataSet:[],
            };
        },
        methods:
            {
                getEvents() {
                    axios({
                        method: 'post',
                        url: '/api/basic/events/today',
                    }).then((response) => {
                            this.$data.events = response.data
                        }).catch((response)=> {
                            swal.fire( 'Server Error', 'Kindly Contact the Server Admin','error');
                        });
                },
                findMembers()
                {
                  this.getStudents();
                  // this.getCoordinators();
                },
                getStudents() {
                    axios({
                        method: 'post',
                        url: '/api/basic/'+this.$data.selectedEvent+'/participants',
                    }).then((response) => {
                            this.$data.students = response.data;
                            this.$data.dataSet=[];
                            var usableDataSet=[];
                            console.log(response.data)
                            for(var j=0;j<response.data.length;j++)
                            {
                                var dt=response.data[j];
                                var link="<td id='"+dt[1]+"'><input type='checkbox' class='js-switch' data-color='#26c6da' data-secondary-color='#f62d51'/></td>";
                                usableDataSet.push([dt[0],dt[1],dt[2],link]);
                            }
                            console.log(usableDataSet)
                            $('#students-table').DataTable({
                                data: usableDataSet,
                                "columnDefs": [ {
                                    "orderable": false,
                                    "targets": 1
                                } ],
                                "order": [[ 0, "asc" ]],
                                fixedHeader: {
                                    header: false,
                                    footer: false
                                },
                                columns: [
                                    { title: "Serial" },
                                    { title: "Registration Number"},
                                    { title: "Name" },
                                    { title: "Action"},
                                ]
                            })
                        })
                },
                getCoordinators() {
                    axios({
                        method: 'post',
                        url: '/api/basic/events/today',
                    })
                        .then((response) => {
                            this.$data.events = response.data
                        })
                        .catch(function (response) {
                            swal.fire( 'Server Error', 'Kindly Contact the Server Admin','error');
                        });
                },
                markAttendence()
                {

                }
            },
        mounted() {
            this.getEvents();
        }
    }
</script>

<style scoped>

</style>