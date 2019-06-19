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
                            <form @submit.prevent="" class="form-material">
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
                                            <label class="control-label">Value of each pass ()</label>
                                            <textarea  id="description" v-model="form.description" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                                            <has-error :form="form" field="description"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button class="btn btn-success" id="sub" type="submit"> <i class="fa fa-check"></i> Create Team</button>
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
        name: "request-smart-card"
    }
</script>

<style scoped>

</style>