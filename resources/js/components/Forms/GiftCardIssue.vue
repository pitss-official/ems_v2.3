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
                            <select @change="selectReciplentGroup"  class="selectpicker" data-style="form-control btn-secondary" id="group_type">
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
                                <select data-role="tagsinput" id="14_reg_no_csv" multiple type="number"></select><span><button class="btn btn-danger" onClick="$('#14_reg_no_csv').tagsinput('removeAll');" type="button">Clear All</button></span>
                            </div>


                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Amount</label>
                                        <input class=" form-control" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" id="14_csv_amt" name="tch2" required type="text" value="0">
                                    </div>
                                    <small class="form-control-feedback"></small>
                                </div><div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label">Validity</label>
                                    <input class=" form-control" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" id="14_gift_valid" name="tch5" required type="text" value="0">
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">Gift Message</label>
                                        <input class="form-control" id="14_gift_message" placeholder="Dear Studnet you are rewarded..." required type="text">
                                        <small class="form-control-feedback"></small> </div>
                                </div>
                            </div>
                            <div class="row" id="reciplent_list_14" style="display: none">
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
                                        <button @click="calculateValue" class="btn btn-inverse" id="14_process_it_p" type="button">Calculate</button><button @click="processRequest" class="btn btn-success" id="14_process_it" type="button">Deposit Cards</button><button class="btn btn-success" id="reload_it" onClick="location.reload();" type="button">Reset Form</button>
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
                                            <div class="progress-bar bg-warning active progress-bar-striped" id="14_display_progress_bar" role="progressbar" style="width: 0%; height:14px;"></div>
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
