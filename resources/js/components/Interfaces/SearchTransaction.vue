<template>
    <div id="search-transaction">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Search Transactions</h4>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="search" class="form-material">
                            <div class="form-body">
                                <h3 class="card-title">Enter Transaction Details</h3>
                                <hr>
                                <alert-errors :form="student"></alert-errors>
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Registration Number</label>
                                            <input @change="find" @tab="find" autofocus class="form-control" id="regNo"
                                                   name="RegistrationNumber" placeholder="" required type="number"
                                                   v-model="student.collegeUID"
                                                   v-validate="'required|numeric|digits:8'">
                                            <small class="form-control-feedback">Press TAB to fetch name</small>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                                            <!--				form-group has-danger/has-success									form-control-danger-->
                                            <input class="form-control" id="name"
                                                   placeholder="Enter Registration Number to Fetch" readonly type="text"
                                                   v-model="student.name">
                                            <small class="form-control-feedback">
                                                <div class="label label-light-danger" v-show="student.balance"><p
                                                    style="font-size: 140% !important;" v-text="student.balance"></p>
                                                </div>
                                            </small>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Mobile Number (Optional)</label>
                                        <input class="form-control" id="mobile" placeholder="" type="text"
                                               v-model="student.mobile">
                                        <small class="form-control-feedback">Registered Mobile</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Amount</label>
                                        <input class="form-control" id="amount" onChange='$("#sub").focus()'
                                               placeholder="₹" required type="number" v-model="student.amount"
                                               v-validate="'required|min:1'" value="0.00">
                                        <small class="form-control-feedback">Currently Supported ₹,$</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button class="btn waves btn-success" id="sub" type="submit"><i class="fa fa-check"></i>
                                    Create Request
                                </button>
                                <button class="btn btn-danger" type="reset">Cancel</button>
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
        name: "SearchTransaction"
    }
</script>

<style scoped>

</style>
