<template>
    <div id="gift-card-issue">
        <div id="div-gift-card-issue-main">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info" id="gift-main">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Distribute Gift Certificates (Discount Coupons)</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="m-t-30 m-b-10">Select the Reciplent Group Type</h5>
                            <select class="selectpicker"  id="group_type" data-style="form-control btn-secondary" @change="selectReciplentGroup">
                                <option value="0">Select a Type</option>
                                <optgroup label="From Events">
                                    <option value="11">Attendees</option>
                                    <option value="12">Participants</option>
                                    <option value="13">Winners</option>
                                </optgroup>
                                <optgroup label="From Registration Numbers">
                                    <option value="14">Raw Numbers</option>
                                    <option value="15">Students</option>
                                </optgroup><optgroup label="From Files">
                                <option value="16">CSV File</option>
                            </optgroup>
                            </select>
                        </div>
                    </div></div></div>
            <div class="row" id="select_raw_reciplent">

                <div class="col-lg-12">
                    <div class="card card-outline-info" id="mains">
                        <div class="card-body"><form class="form-material p-r-20" id="14_form">
                            <h3><span class="mdi mdi-trophy-award"></span>Award Gift Certificates to Students (Registration Number Based)</h3><hr><label>Enter the Comma Separated Registration Numbers</label><br><label>The Recipients are:</label>
                            <div class="form-group">
                                <select multiple type="number" data-role="tagsinput" id="14_reg_no_csv"></select><span><button type="button" class="btn btn-danger" onClick="$('#14_reg_no_csv').tagsinput('removeAll');">Clear All</button></span>
                            </div>


                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Amount</label>
                                        <input id="14_csv_amt" type="text" value="0" name="tch2" class=" form-control" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" required>
                                    </div>
                                    <small class="form-control-feedback"></small>
                                </div><div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">Validity</label>
                                    <input id="14_gift_valid" type="text" value="0" name="tch5" class=" form-control" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" required>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">Gift Message</label>
                                        <input id="14_gift_message" type="text" class="form-control" placeholder="Dear Studnet you are rewarded..." required>
                                        <small class="form-control-feedback"></small> </div>
                                </div>
                            </div>
                            <div class="row" style="display: none" id="reciplent_list_14">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Registartion Number</th>
                                                <th>Amount</th>
                                                <th class="text-nowrap">Status</th>
                                            </tr>
                                            </thead>
                                            <tbody id="14_status_table_tbody">

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>Total Amount:</th>
                                                <th id="14_status_display_total"></th>
                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div></div></form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <button type="button" id="14_process_it_p" class="btn btn-inverse" @click="calculateValue">Calculate</button><button id="14_process_it" type="button" class="btn btn-success" @click="processRequest">Deposit Cards</button><button id="reload_it" type="button" class="btn btn-success" onClick="location.reload();">Reset Form</button>
                                    </div>
                                </div>
                            </div>
                            <div id="14_display_prog_section" style="display: none">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="" id="14_blink_ani_display_Status">PRESS DEPOSIT TO CONTINEUE</div>
                                    </div></div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="progress m-t-30">
                                            <div id="14_display_progress_bar" class="progress-bar bg-warning active progress-bar-striped" style="width: 0%; height:14px;" role="progressbar"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div></div></div></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "gift-card-issue",
        data()
        {
            return
            {

            }
        },
        methods:
            {
              selectReciplentGroup()
              {

              },
              calculateValue()
              {

              },
                processRequest()
                {

                },
            },
    }
</script>

<style scoped>

</style>