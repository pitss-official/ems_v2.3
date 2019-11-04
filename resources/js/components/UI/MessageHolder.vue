<template>
    <div class="chat-right-aside">
        <div class="chat-main-header">
            <div class="p-20 b-b">
                <h3 class="box-title">Chat Message</h3>
            </div>
        </div>
        <div class="chat-rbox" style="overflow: visible;">
            <div class="slimScrollDiv"  style="position: relative; overflow: visible hidden; width: auto; height: 100%;">
<!--                <ul class="chat-list p-20" @scroll="getOldMessages" id="messagesScrollable" style="overflow: auto; width: auto; height: 491px;">-->
                <ul class="chat-list p-20" id="messagesScrollable" style="overflow: auto; width: auto; height: 491px;">
                <div class='w-100' @click="getOldMessages"><div class="row"><div class="col-5"></div><div class="col-2">
                    <img src="https://i.gifer.com/ZKZg.gif" width="30px" alt="Loading Messages"/>
                </div><div class="col-5"></div></div></div>
                    <msg v-for="message in messages" :message="message.message" :name="message.sender+' '+message.id " :img="54" :alt="54" :time="message.created_at" :rev="assocCheck(message.sender)"></msg>
<!--                <li>-->
<!--                    <div class="chat-img"><img alt="user"></div>-->
<!--                    <div class="chat-content">-->
<!--                        <h5>James Anderson</h5>-->
<!--                        <div class="box bg-light-info">Lorem Ipsum is simply dummy text of the printing &amp; type setting industry.</div>-->
<!--                    </div>-->
<!--                    <div class="chat-time">10:56 am</div>-->
<!--                </li>-->
                <!--chat Row -->
            </ul><div class="slimScrollBar" style="background: rgb(220, 220, 220); width: 5px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 395.215px;"></div><div class="slimScrollRail" style="width: 5px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
        </div>
        <div class="card-body b-t">
            <div class="row">
                <div class="col-8">
                    <textarea placeholder="Type your message here" class="form-control b-0"></textarea>
                </div>
                <div class="col-4 text-right">
                    <button type="button" class="btn btn-info btn-circle btn-lg"><i class="fa fa-paper-plane-o"></i> </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MessageHolder",
        data(){
            return {
                chatParent:null,
                messages:[],
                currentUserID:undefined,
                currpage:null,
                routing:false,
            }
        },
        beforeMount() {
            axios.get('/api/user').then(res=>this.$data.currentUserID=res.data.firstName)
            this.fetchStore()
            this.$data.currpage!=null?this.$data.currpage-=1:axios.get('/api/chat/'+this.$route.params.chatID+'/messages?page='+this.$data.currpage).then(res=>{
                if(this.$data.currpage==null)this.$data.currpage=res.data.last_page;
            });
        },
        mounted(){
            $("#messagesScrollable").animate({ scrollTop: $('#messagesScrollable').prop("scrollHeight")*100}, 5000);
        },
        methods:{
            assocCheck(senderID){
                return senderID==this.$data.currentUserID
            },
            fetchStore(){
                this.$data.currpage!=null?this.$data.currpage-=1:axios.get('/api/chat/'+this.$route.params.chatID+'/messages?page='+this.$data.currpage).then(res=>{
                    if(this.$data.currpage==null)this.$data.currpage=res.data.last_page;
                });
                axios.get('/api/chat/'+this.$route.params.chatID+'/messages?page='+this.$data.currpage)
                    .then(r=>{this.$data.messages=r.data.data.concat(this.$data.messages);this.$data.routing=true})
            },
            getOldMessages(event){
                window.ee=event
                let lastpos=event.target.scrollTop
                if(this.getScrollPercentage(event.target)<5 && this.$data.routing==true){
                    this.fetchStore()
                    event.target.scrollTop=lastpos
                }
            },
            getScrollPercentage(target){
                var h = target,
                    b = document.body,
                    st = 'scrollTop',
                    sh = 'scrollHeight';
                return (h[st]||b[st]) / ((h[sh]||b[sh]) - h.clientHeight) * 100;
            }
        }
    }
</script>

<style scoped>

</style>
