<template>
    <div id="dashboard-main">
        <div class="row">
            <!-- Column -->
            <ui-dashboard-tile icon="ti-user" title="Users" subtitle="Including Participants" :count="data.totalMembers"></ui-dashboard-tile>
            <ui-dashboard-tile icon="ti-id-badge" title="Coordinators" subtitle="MegaMinds Members" :count="data.totalCoordinators"></ui-dashboard-tile>
            <ui-dashboard-tile icon="ti-ticket" title="Referrals" subtitle="My Referrals" :count="data.totalMembersIntroduced"></ui-dashboard-tile>
            <ui-dashboard-tile icon="ti-money" title="Balance" subtitle="My Balance" :count="'₹'+data.currentBalance"></ui-dashboard-tile>
        </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="row">
                            <div class="col-lg-6 col-md-4">
                                <div class="card-body">
                                    <h3>Me vs Organization</h3>
                                    <h6 class="card-subtitle m-b-0">comparison between number of enrollments</h6> </div>
                            </div>
                            <div class="col-lg-3 col-md-4 b-r align-self-center">
                                <div class="card-body">
                                    <div class="d-flex flex-row">
                                        <div class="col-8 p-0 align-self-center">
                                            <h3 class="m-b-0">{{data.upcomingEvents}}</h3>
                                            <h5 class="text-muted m-b-0">Upcoming Events</h5> </div>
                                        <div class="col-4 text-right">
                                            <div class="round align-self-center round-success"><i class="mdi mdi-chart-line"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 align-self-center">
                                <div class="card-body">
                                    <div class="d-flex flex-row">
                                        <div class="col-8 p-0 align-self-center">
                                            <h3 class="m-b-0">{{data.totalEvents}}</h3>
                                            <h5 class="text-muted m-b-0">Total Events</h5> </div>
                                        <div class="col-4 text-right">
                                            <div class="round align-self-center bg-inverse"><i class="mdi mdi-chart-bar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <hr class="m-t-0"> </div>
                        <div class="chartist-chart andvios progresser-chart m-t-40" style="height:400px;"></div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-md-8 col-xlg-9">
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4" v-for="(event,key,val) in data.rankings">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">{{key}}</h4>
<!--                                <div class="d-flex flex-row">-->
<!--                                    <div class="p-10 b-r">-->
<!--                                        <h6 class="font-light">Montly</h6><b>20.40%</b>-->
<!--                                    </div>-->
<!--                                    <div class="p-10">-->
<!--                                        <h6 class="font-light">Daily</h6><b>5.40%</b>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </div>
                            <div :id="key.replace(/\s/g, '')" class="sparkchart"><canvas width="392" height="50" style="display: inline-block; width: 392px; height: 50px; vertical-align: top;"></canvas></div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <!-- Row -->
            </div>
            <div class="col-md-4 col-xlg-3">
                <!-- Column -->
                <div class="card earning-widget">
                    <div class="card-header">
                        <div class="card-actions">
                            <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                            <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                            <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                        </div>
                        <h4 class="card-title m-b-0">Rankings</h4>
                    </div>
                    <div class="card-body b-t collapse show">
                        <table class="table v-middle no-border">
                            <tbody v-for="(event,key,val) in data.rankings">
                            <tr>
                                <td colspan="2" class="text-center border-bottom"><h4>{{key.toUpperCase()}}</h4><span v-if="event.length==0" class="label btn-themecolor">0</span><span v-else class="label btn-themecolor">{{objectSum(event)}}</span></td>
                            </tr>
                            <tr v-if="event.length==0"><td colspan="2"><p class="faded">No Registrations Yet</p></td></tr>
                            <tr v-for="(val,key) in event">
                                <td>{{key}}</td>
                                <td align="right"><span class="label label-light-success">{{val}}</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Column -->
<!--                <div class="card">-->
<!--                    <div class="card-header">-->
<!--                        <div class="card-actions">-->
<!--                            <a class="" data-action="collapse"><i class="ti-minus"></i></a>-->
<!--                            <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>-->
<!--                            <a class="btn-close" data-action="close"><i class="ti-close"></i></a>-->
<!--                        </div>-->
<!--                        <h4 class="card-title m-b-0">Offers Available</h4>-->
<!--                    </div>-->
<!--                    <div class="card-body collapse show bg-info">-->
<!--                        <div id="myCarousel" class="carousel slide" data-ride="carousel">-->
<!--                            &lt;!&ndash; Carousel items &ndash;&gt;-->
<!--                            <div class="carousel-inner">-->
<!--                                <div class="carousel-item flex-column active carousel-item-left">-->
<!--                                    <i class="fa fa-shopping-cart fa-2x text-white"></i>-->
<!--                                    <p class="text-white">25th Jan</p>-->
<!--                                    <h3 class="text-white font-light">Now Get <span class="font-bold">50% Off</span><br>-->
<!--                                        on buy</h3>-->
<!--                                    <div class="text-white m-t-20">-->
<!--                                        <i>- Ecommerce site</i>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="carousel-item flex-column carousel-item-next carousel-item-left">-->
<!--                                    <i class="fa fa-shopping-cart fa-2x text-white"></i>-->
<!--                                    <p class="text-white">25th Jan</p>-->
<!--                                    <h3 class="text-white font-light">Now Get <span class="font-bold">50% Off</span><br>-->
<!--                                        on buy</h3>-->
<!--                                    <div class="text-white m-t-20">-->
<!--                                        <i>- Ecommerce site</i>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="carousel-item flex-column">-->
<!--                                    <i class="fa fa-shopping-cart fa-2x text-white"></i>-->
<!--                                    <p class="text-white">25th Jan</p>-->
<!--                                    <h3 class="text-white font-light">Now Get <span class="font-bold">50% Off</span><br>-->
<!--                                        on buy</h3>-->
<!--                                    <div class="text-white m-t-20">-->
<!--                                        <i>- Ecommerce site</i>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <!-- Column -->
<!--                &lt;!&ndash; Column &ndash;&gt;-->
<!--                <div class="card">-->
<!--                    <div class="card-header">-->
<!--                        <div class="card-actions">-->
<!--                            <a class="" data-action="collapse"><i class="ti-minus"></i></a>-->
<!--                            <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>-->
<!--                            <a class="btn-close" data-action="close"><i class="ti-close"></i></a>-->
<!--                        </div>-->
<!--                        <h4 class="card-title m-b-0">Monthly Wineer</h4>-->
<!--                    </div>-->
<!--                    <div class="card-body collapse show b-t">-->
<!--                        <div class="m-t-30 text-center">-->
<!--&lt;!&ndash;                            <img src="../assets/images/users/5.jpg" class="img-circle" width="150">&ndash;&gt;-->
<!--                            <h4 class="card-title m-t-10">Hanna Gover</h4>-->
<!--                            <h6 class="card-subtitle">Accoubts Manager Amix corp</h6>-->
<!--                            <div class="row text-center justify-content-md-center">-->
<!--                                <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>-->
<!--                                <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                &lt;!&ndash; Column &ndash;&gt;-->
<!--                <div class="card">-->
<!--                    <div class="card-header">-->
<!--                        <div class="card-actions">-->
<!--                            <a class="" data-action="collapse"><i class="ti-minus"></i></a>-->
<!--                            <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>-->
<!--                            <a class="btn-close" data-action="close"><i class="ti-close"></i></a>-->
<!--                        </div>-->
<!--                        <h4 class="card-title m-b-0">New items</h4>-->
<!--                    </div>-->
<!--                    <div class="card-body p-0 collapse show text-center">-->
<!--                        <div id="myCarousel2" class="carousel slide" data-ride="carousel">-->
<!--                            &lt;!&ndash; Carousel items &ndash;&gt;-->
<!--                            <div class="carousel-inner">-->
<!--                                <div class="carousel-item flex-column">-->
<!--&lt;!&ndash;                                    <img src="../assets/images/gallery/chair.jpg" alt="user">&ndash;&gt;-->
<!--                                    <h4 class="m-b-30">Brand New Chair</h4>-->
<!--                                </div>-->
<!--                                <div class="carousel-item flex-column">-->
<!--&lt;!&ndash;                                    <img src="../assets/images/gallery/chair2.jpg" alt="user">&ndash;&gt;-->
<!--                                    <h4 class="m-b-30">Brand New Chair</h4>-->
<!--                                </div>-->
<!--                                <div class="carousel-item flex-column">-->
<!--&lt;!&ndash;                                    <img src="../assets/images/gallery/chair3.jpg" alt="user">&ndash;&gt;-->
<!--                                    <h4 class="m-b-30">Brand New Chair</h4>-->
<!--                                </div>-->
<!--                                <div class="carousel-item flex-column active">-->
<!--&lt;!&ndash;                                    <img src="../assets/images/gallery/chair4.jpg" alt="user">&ndash;&gt;-->
<!--                                    <h4 class="m-b-30">Brand New Chair</h4>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                data:{
                    upcomingEvents:'Loading...',
                    totalEvents:'Loading...',
                    totalMembers:'Loading...',
                    totalCoordinators:'Loading...',
                    totalMembersIntroduced:'Loading...',
                    currentBalance:'Loading...',
                    rankings:[],
                }
            }
        },
        beforeMount() {
            eventStream.$emit('dashboardDataRequired');
        }
        ,
        mounted() {
            eventStream.$on('dashboardDataReceived',data=>{
                this.$data.data=data;
                var sparklineLogin = function() {
                    for (let [key, value] of Object.entries(data.rankings)) {
                        let arr=[];
                        for (let [k, v] of Object.entries(data.rankings[key])) {
                        arr.push(v);
                        }
                        $("#"+key.replace(/\s/g, '')).sparkline(arr, {
                            type: 'line',
                            width: '100%',
                            height: '75',
                            lineColor: '#26c6da',
                            fillColor: '#26c6da',
                            maxSpotColor: '#26c6da',
                            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
                            highlightSpotColor: '#26c6da'
                        });
                    }
                }
                var sparkResize;

                $(window).resize(function(e) {
                    clearTimeout(sparkResize);
                    sparkResize = setTimeout(sparklineLogin, 500);
                });
                sparklineLogin();
            })
        },
        methods:{
            objectSum(object){
                let sum=0;
                // object.forEach((event,key,val)=>{
                //     console.log(event,key,val)
                // });
            }

        }
    }
</script>
<style>
    .andvios .ct-series-a .ct-area{
        fill: black !important;
    }
    .andvios .ct-series-b .ct-area{
        fill: blue !important;
    }
</style>
