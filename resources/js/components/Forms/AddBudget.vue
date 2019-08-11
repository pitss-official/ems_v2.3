<template>
    <div id="add-budget">
        <div id="add-budget-main">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Add Event Budget</h4>
                        </div>

                        <div class="card-body">
                            <form @submit.prevent="sendForm" class="form-material">
                                <div class="form-body">
                                    <h3 class="card-title">Prepare Event Budget</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <!--row1-->
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Budget Name</label>
                                                <input v-model="form.budgetName" name="budgetName" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('budgetName') }">
                                                <small class="form-control-feedback">Write budget name</small>
                                                <has-error :form="form" field="budgetName"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->


                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Associated Event</label>
                                                <select v-model="form.eventID" type="text" name="eventID" class="form-control" :class="{ 'is-invalid': form.errors.has('eventID') }">
                                                    <option v-bind:value="event.id" v-for="event in events">
                                                        {{ event.name }}
                                                    </option>
                                                </select>
                                                <has-error :form="form" field="eventID"></has-error>
                                            </div>
                                        </div>
                                        <!--/span-->

                                        <!--row1-->



                                    </div>
                                    <div class="row"><div class="col-md-4">
                                        <div class="form-group">
                                            <label>Percentage/Value</label>
                                            <div class="switch">
                                                <label>Check if Amount is in Percentage
                                                    <input v-model="form.isPercentage" checked=""
                                                           type="checkbox"><span
                                                        class="lever"></span>Yes</label>
                                                <has-error :form="form" field="isPercentage"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label class="control-label">Debit Account Number</label>
                                        <input v-model="form.account" name="value" type="number" class="form-control" :class="{ 'is-invalid': form.errors.has('account') }">
                                        <small class="form-control-feedback">Debit account number associated with this budget</small>
                                        <has-error :form="form" field="account"></has-error>
                                    </div>
                                    </div><div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Budget Value</label>
                                                <input v-model="form.value" name="value" type="number" class="form-control" :class="{ 'is-invalid': form.errors.has('value') }">
                                                <small class="form-control-feedback">Total value of this budget</small>
                                                <has-error :form="form" field="value"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                </div>
                                <div class="form-actions">
                                    <button class="btn btn-success" id="sub" type="submit"> <i class="fa fa-check"></i> Finalize Budget</button>
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
        name: "Budget",
        data() {
            return {
                events:null,
                form:new Form({
                    eventID:null,
                    budgetName:null,
                    value:null,
                    isPercentage:0,
                    account:null
                }),
            }
        },methods: {
            sendForm() {
                this.form.post('/api/put/events/budget/newBudget').then(response => {
                    // swal.fire({
                    //     title: 'Bravo!',
                    //     html: 'You have successfully registered team <b>' + this.form.teamName + '</b>',
                    //     type: 'success',
                    //     backdrop: 'rgba(0, 0, 123, 0.4)',
                    // })
                });
            },
        },
        //todo: anu create function for filtering non teaming events
        mounted(){
            axios({
                method: 'post',
                url: '/api/events/find/enrollable/',
            }).then((response)=> {
                this.$data.events = response.data;
            }).catch((error) => {
                    swal.fire('Server Error','Error fetching events',"error");
                });
        }
    }
</script>

<style scoped>

</style>
