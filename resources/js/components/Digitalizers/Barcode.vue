<template>
    <div id="mainview">
        <qrcode-stream @decode="store"></qrcode-stream>
    </div>
</template>
<script>
    export default {
        name: "qrbasedattendance",
        methods:{
            store(string){
                swal.fire(string,string,"success");
            }
        }
    }
</script>
