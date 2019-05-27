<template>
    <li class="nav-item dropdown">
                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle text-muted waves-effect waves-dark" data-toggle="dropdown" href="" id="2"> <i class="mdi mdi-email"></i>
                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                </a>
                <div aria-labelledby="2" class="dropdown-menu mailbox dropdown-menu-right scale-up">
                    <ul>
                        <li>
                            <div class="drop-title">You have 4 new messages</div>
                        </li>
                        <li>
                            <div class="message-center">
                                <!-- Message -->
                                <a href="#">
                                    <div class="user-img"> <img alt="user" class="img-circle" src=""> <span class="profile-status online pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                </a>
                                <!-- Message -->
                                <a href="#">
                                    <div class="user-img"> <img alt="user" class="img-circle" src=""> <span class="profile-status busy pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                </a>
                                <!-- Message -->
                                <a href="#">
                                    <div class="user-img"> <img alt="user" class="img-circle" src=""> <span class="profile-status away pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                </a>
                                <!-- Message -->
                                <a href="#">
                                    <div class="user-img"> <img alt="user" class="img-circle" src=""> <span class="profile-status offline pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                        </li>
                    </ul>
                </div>
            </li>
</template>

<script>
    export default {
        name: "messages"
    }
</script>

<style scoped>

</style>
