<template>
    <div id="dashboard-main">
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
                                            <h3 class="m-b-0">3</h3>
                                            <h5 class="text-muted m-b-0">Events</h5> </div>
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
                                            <h3 class="m-b-0">0</h3>
                                            <h5 class="text-muted m-b-0">Dates</h5> </div>
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
        <module-under-construction></module-under-construction>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
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
