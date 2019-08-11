<template>
            <div class="row page-titles">
                <div class="col-md-5 col-8 align-self-center">
                    <h3 class="text-themecolor">Dashboard</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:window.location.url">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <div class="col-md-7 col-4 align-self-center">
                    <div class="d-flex m-t-10 justify-content-end">
                        <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                            <div class="chart-text m-r-10">
                                <h6 class="m-b-0"><small>EARNINGS</small></h6>
                                <h4 class="m-t-0 text-info" v-html="thisMonthEarnings"></h4></div>
                            <div class="spark-chart">
                                <div id="monthchart"></div>
                            </div>
                        </div>
                        <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                            <div class="chart-text m-r-10">
                                <h6 class="m-b-0"><small>BALANCE</small></h6>
                                <h4 class="m-t-0 text-primary" v-html="currentBalance"></h4></div>
                            <div class="spark-chart">
                                <div id="lastmonthchart"></div>
                            </div>
                        </div>
                        <div class="">
                            <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                        </div>
                    </div>
                </div>
            </div>
</template>

<script>
    export default {
        name: "breadcumb",
        data()
        {
            return{
                thisMonthEarnings:'Loading...',
                currentBalance:'Loading...',
                url:window.location.pathname,
            }
        },
        methods:
            {
                fetchBalance()
                {
                    axios({
                        method:'post',
                        url:'/api/fetch/user/balance/currentBalance'
                    }).then((response)=>{
                        this.$data.thisMonthEarnings='&#8377;'+response.data.thisMonthEarnings;
                        this.$data.currentBalance='&#8377;'+response.data.currentBalance;
                    }).catch()
                }
            },
        beforeMount() {
            setInterval(()=>{
                this.fetchBalance();
            },30000);
        },
        mounted() {
            this.fetchBalance();
        }
    }
</script>

<style scoped>

</style>
