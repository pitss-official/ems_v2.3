<template>

    <li v-if="rev==true" class="reverse">
        <div class="chat-time">{{time}}</div>
        <div class="chat-content">
            <h5>{{name}}</h5>
            <div class="box bg-light-inverse">{{message}}</div>
        </div>
        <div class="chat-img"><img :src="img" :alt="alt"></div>
    </li>
    <li v-else>
        <div class="chat-img"><img :src="img" :alt="alt"></div>
    <div class="chat-content">
        <h5>{{name}}</h5>
        <div class="box bg-light-success">{{message}}</div>
    </div>
        <div class="chat-time">{{time}}</div>
    </li>
</template>

<script>
    export default {
        name: "message",
        props:['img','alt','name','message','time','rev']
    }
</script>

<style scoped>

</style>
