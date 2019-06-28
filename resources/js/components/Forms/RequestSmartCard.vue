<template>
    <div id="request-smart-card">
        <div id="request-smart-card-main">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Add New Team</h4>
                        </div>

                        <div class="card-body">
                            <form @submit.prevent="sendForm" class="form-material">
                                <div class="form-body">
                                    <h3 class="card-title">Enter Your Choices</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <!--row1-->
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Enter number of passes</label>
                                                <input v-model="form.numberPasses" name="numberPasses" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('numberPasses') }">

                                                <has-error :form="form" field="numberPasses"></has-error>
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
                                            <label class="control-label">Value of each pass (₹)</label>
                                            <input  id="description" v-model="form.value" class="form-control" :class="{ 'is-invalid': form.errors.has('value') }"></input>
                                            <small v-if="form.eventID>0" class="form-control-feedback">The value should be less than or equal to <b>₹{{eventList.find(event=>event.id==form.eventID)['ticketPrice']}}</b></small>
                                            <has-error :form="form" field="value"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button class="btn btn-success" id="sub" type="submit"> <i class="fa fa-check"></i> Create Pass</button>
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
        name: "request-smart-card",
        data(){
            return{
                eventList: [],
                selectedEvent:'',

                form: new Form({
                    numberPasses: '',
                    eventID: '',
                    value: '',
                })
            }
        },

        methods: {
            sendForm() {
                // Submit the form via a POST request
                //todo: reset form
                this.form.post('/api/forms/generate/smartCards').then(response => {
                    let rows=[['Sr.No.','Card-ID','Secret Key']];
                    response.data.forEach((card,serial)=>rows.push([serial+1,card.id,card.code]));
                    console.log(rows);
                    var CsvString = "";
                    rows.forEach((RowItem, RowIndex)=>{
                        RowItem.forEach((ColItem, ColIndex)=>CsvString += ColItem + ',');
                        CsvString += "\r\n";
                    });
                    CsvString = "data:application/csv," + encodeURIComponent(CsvString);
                    var x = document.createElement("A");
                    x.setAttribute("href", CsvString );
                    x.setAttribute("download","cards.csv");
                    document.body.appendChild(x);
                    x.click();
                    swal.fire({
                        title: 'Bravo!',
                        html: 'You have successfully generated cards. Please download the attached file for activation',
                        type: 'success',
                        backdrop: 'rgba(0, 0, 123, 0.4)',
                    });
                    this.$data.form.reset();
                });
            },
        },
        //todo: anu create function for filtering non teaming events
        mounted(){
            axios({
                method: 'post',
                url: '/api/events/find/enrollable/',
            }).then((response)=> {

                this.$data.eventList = response.data;

            })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
</script>

<style scoped>

</style>
