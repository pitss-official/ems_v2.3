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
    import moment from 'moment'
    export default {
        name: "breadcumb",
        // components:{'breadcumb':require('./Breadcumb.vue')},
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
                        eventStream.$emit("dashboardDataReceived", response.data);
                        let dateTo = moment().format('DD-MM-YYYY');
                        window.earningArrSpark=[]
                        for(let i=0;i<8;i++)
                        {
                            let d=moment().subtract(i,'d').format('DD-MM-YYYY');
                            if(response.data.thisWeekEarning[d]!=undefined){
                                earningArrSpark.push(response.data.thisWeekEarning[d].map(item => item.amount).reduce((prev, next) => prev + next))
                            }else{
                                earningArrSpark.push(0)
                            }
                        }
                        window.enrollmentArrSpark=[]
                        for(let i=0;i<8;i++)
                        {

                            let d=moment().subtract(i,'d').format('DD-MM-YYYY');
                            if(response.data.thisWeekEnrollments[d]!=undefined){
                                enrollmentArrSpark.push(response.data.thisWeekEnrollments[d].length)
                            }else{
                                enrollmentArrSpark.push(0)
                            }
                        }
                        window.mainchart={'dts':[],'org':[],'curr':[]}
                        for(let i=0;i<31;i++)
                        {
                            let d=moment().subtract(i,'d').format('DD-MM-YYYY');
                            let e=moment().subtract(i,'d').format('DD/MM');
                            mainchart.dts.push(e);
                            if(response.data.totalEnrollmentsByOrganization[d]!=undefined){
                                mainchart.org.push(response.data.totalEnrollmentsByOrganization[d].length)
                            }else{
                                mainchart.org.push(0)
                            }
                            if(response.data.totalEnrollmentsDoneByUser[d]!=undefined){
                                mainchart.curr.push(response.data.totalEnrollmentsDoneByUser[d].length)
                            }else{
                                mainchart.curr.push(0)
                            }
                        }
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
            eventStream.$on('dashboardDataRequired',data=>{
               this.fetchBalance();
            });
            this.fetchBalance();
        }
    }
</script>

<style scoped>

</style>
