<template>
    <div id="dual-entry-transfer">
        <div id="dual-entry-card">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Transfer Money (Dual Entry)</h4>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="transact" class="form-material">
                                <div class="form-body">
                                    <h3 class="card-title">Enter Account Details</h3>
                                    <hr>
                                    <alert-errors :form="transaction"></alert-errors>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Debit Account Number</label>
                                                <input @change="find('d')" @tab="find('d')" autofocus class="form-control" id="debitAcc" name="DebitAccountNumber" placeholder="" required type="number" v-model="transaction.debitAccount">
                                                <small class="form-control-feedback"><div class="label label-light-info" v-show="transaction.debitAccountName"><p style="font-size: 150% !important;" v-text="transaction.debitAccountName"></p></div></small><div class="label label-light-danger" v-show="transaction.debitAccountBalance"><p style="font-size: 140% !important;" v-text="transaction.debitAccountBalance"></p></div></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Credit Account Number</label>
                                                <input @change="find('c')" @tab="find('c')" autofocus class="form-control" id="creditAcc" name="CreditAccountNumber" placeholder="" required type="number" v-model="transaction.creditAccount">
                                                <small class="form-control-feedback"><div class="label label-light-info" v-show="transaction.creditAccountName"><p style="font-size: 150% !important;" v-text="transaction.creditAccountName"></p></div></small><div class="label label-light-danger" v-show="transaction.creditAccountBalance"><p style="font-size: 140% !important;" v-text="transaction.creditAccountBalance"></p></div></div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Transaction Narration</label>
                                            <input class="form-control" placeholder="" type="text" v-model="transaction.narration">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Amount</label>
                                            <input class="form-control" id="amount" onChange='$("#sub").focus()' placeholder="₹" required type="number" v-model="transaction.amount" v-validate="'required|min:1'" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button class="btn waves btn-success" id="sub" type="submit"> <i class="fa fa-check"></i> Create Request</button>
                                    <button class="btn btn-danger" type="reset">Cancel</button>
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
    //import Select from "vue-select/src/components/Select";
    import AlertErrors from "vform/src/components/AlertErrors";
//post /api/put/transactions/doubleEntry/new
    //get /api/fetch/transaction/account/{number}/details
    export default {
        components: {AlertErrors},
        data (){
            return {
                naive:{
                    filled:false,
                },
                // Create a new form instance
                transaction: new Form({
                    debitAccount: null,
                    creditAccount: null,
                    debitAccountName: null,
                    creditAccountName: null,
                    debitAccountBalance: null,
                    creditAccountBalance: null,
                    narration:null,
                    amount:0,
                }),
            };
        },
        methods:
            {
                find(type)
                {
                    let number=null;
                    if(type=='c') number=this.$data.transaction.creditAccount;
                    else number=this.$data.transaction.debitAccount;
                        axios({
                            method: 'get',
                            url: '/api/fetch/transaction/account/' + number+'/details',
                        })
                            .then((response) => {
                                if(type=='c')
                                {
                                    this.$data.transaction.creditAccountName=response.data.name;
                                    this.$data.transaction.creditAccountBalance='Rs. '+response.data.balance;
                                }else{
                                    this.$data.transaction.debitAccountName=response.data.name;
                                    this.$data.transaction.debitAccountBalance='Rs. '+response.data.balance;
                                }
                            })
                            .catch((response)=> {
                                if(type=='c')
                                {
                                    this.$data.transaction.creditAccountName='Account(s) doesnt exists or blocked';
                                    this.$data.transaction.creditAccountBalance=null;
                                }else{
                                    this.$data.transaction.debitAccountName='Account(s) doesnt exists or blocked';
                                    this.$data.transaction.debitAccountBalance=null;
                                }
                            });
                },
                transact()
                {
                    if(this.$data.transaction.creditAccount==this.$data.transaction.debitAccount){
                        swal.fire('Error','Credit and Debit Account Cannot be same',"error");
                        this.$data.transaction.creditAccount=null;
                        this.$data.transaction.creditAccountName=null;
                        this.$data.transaction.creditAccountBalance=null;
                        return;
                    }
                    this.$validator.validateAll();
                    swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Perform'
                    }).then((result) => {
                        if (result.value) {
                            this.transaction.post('/api/put/transactions/doubleEntry/new').then((response)=> {
                                if(response.data.result=='success'){
                                    this.transaction.reset();
                                    swal.fire('Transaction Success','Transaction Performed Successfully <br><b>Transaction ID'+response.data.id+'</b>',"success")
                                }
                            }).catch((response)=>{swal.fire('Truncated','Transaction failed because of errors. Amount credited back to your account','error')});
                        }
                    });
                }}
    }
</script>
