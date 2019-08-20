<template>
    <div id="request-smart-card">
        <div id="request-smart-card-main">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Send Collection to Organization</h4>
                        </div>

                        <div class="card-body">
                            <form class="form-material" action="javascript:">
                                <div class="form-body">
                                    <h3 class="card-title">Enter Details</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <!--row1-->
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Enter Amount to Pay</label>
                                                <input v-model="amount" name="amount" type="text" class="form-control">
                                            </div>
                                        </div>


                                    </div>
                                    <!--/row-->
                                </div>
                                <!--/row-->
                                <div class="form-actions">
                                    <label> Pay via PayTM / GooglePay / PhonePay / BHIM / Other UPI and Bank Apps</label>
                                    <br>
                                    <button class="btn btn-success" @click="sendForm"> <i class="fa fa-check"></i> Pay Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="py" style="display: none"></div>
    </div>
</template>

<script>
    export default {
        name: "pay-dues",
        data(){
            return{
                'amount':0,
            }
        },

        methods: {
            sendForm() {
                if(this.$data.amount>0)
                {
                    axios.post('/api/request/ops/paydues-request',{'amount':this.$data.amount}).then(res=>{
                        $('#py').html(res.data);
                        document.paytm_form.submit();
                    })
                }
                else{
                    swal.fire('Validation Error','','error')
                }
            },
        },
        mounted(){
        }
    }
</script>

<style scoped>

</style>
