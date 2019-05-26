<template>
        <nav class="sidebar-nav">
        <ul id="sidebarnav" v-html="link">
        </ul>
        </nav>
</template>
<script>
    export default {
        data()
        {
            return{
                link:''
            }
        },
            methods:
                    {
                    },
        mounted() {
                axios.get("/api/fetch/navigation").then(({data})=>this.link=data)
            setInterval( ()=> {
                                    axios.get("/api/fetch/navigation").then(({data})=>this.link=data)
            },10000);
        }
    }
</script>
<style lang="scss">
    //@import "";
</style>
