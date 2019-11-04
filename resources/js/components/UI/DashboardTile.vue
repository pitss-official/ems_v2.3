<template>
    <div class="col-xlg-3 col-lg-4 col-md-6">
        <div class="card card-inverse btn-themecolor">
            <div class="card-body ">
                <div class="row">
                    <div class="col-8">
                        <div class="d-flex">
                            <div class="m-r-20 align-self-center">
                                <h1 class="text-white"><i :class="icon"></i></h1></div>
                            <div>
                                <h3 class="card-title">{{title}}</h3>
                                <h6 class="card-subtitle">{{subtitle}}</h6> </div>
                        </div>
                    </div>
                    <div class="col-4 mt-2">
                        <h2 class="pull-right font-light text-white"><strong>{{count}}</strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DashboardTile",
        props:['title','subtitle','count','icon']
    }
</script>

<style scoped>
</style>
