<template>
    <div id="prepare-event-groups">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-info" id="mains">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Event Proposal - Coordinator Selection (Mandatory)</h4>
                    </div>
                    <div class="card-body">
                        <label>Choose the coordinators to work in the event so that Groups can be formed. Assignment of the students will take place after this step.</label>
                        <form method="post" action="javascript:prepare();" class="form-material">
                            <div class="form-body">
                                <h3 class="card-title">Coordinator Selection</h3>
                                <hr>
                            </div>
                            <!--/row-->
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Event Selection</label>
                                        <select onChange="fetchDays()" id="eventID" class="form-control custom-select" required data-placeholder="Choose a Category" tabindex="1">
                                            <option value="0" selected>Select Event</option>
                                            <?php foreach($events->listUpcoming() as $event) echo "<option value=".$event->eventID.">$event->name</option>";?>
                                        </select>
                                        <small class="form-control-feedback">Select event for which you want to choose the coordinators</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Day Selection</label>
                                        <div class="dates">
                                            <select class="select2 m-b-10 select2-multiple form-control custom-select" style="width: 100%" multiple="multiple" data-placeholder="" id="eventdays" required tabindex="1">
                                            </select>
                                        </div>
                                        <small class="form-control-feedback">Select event for which you want to choose the coordinators</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Assignment Type</label>
                                        <select onChange="" id="assType" class="form-control custom-select" required data-placeholder="Choose a Category" tabindex="1">
                                            <option value="0" selected>Select Assignment Type</option>
                                            <option value="1">From all Registered Coordinators</option>
                                        </select>
                                        <small class="form-control-feedback">Select event for which you want to choose the coordinators</small>
                                    </div>
                                </div>
                            </div>
                            <div id="display" style="display: none">

                            </div>
                            <div class="form-actions">
                                <button type="submit" id="process_btn" class="btn btn-primary"> <i class="fa fa-check"></i> Prepare</button>
                                <button type="button" class="btn btn-danger" onClick="reset()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "prepare-event-groups"
    }
</script>

<style scoped>

</style>