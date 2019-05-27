<template>
    <li class="nav-item dropdown">
        <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" data-toggle="dropdown" href=""> <i class="mdi mdi-message"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
            <ul>
                <li>
                    <div class="drop-title">Notifications</div>
                </li>
    <li>
        <div class="message-center">
            <!-- Message -->
            <a href="#">
                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                <div class="mail-contnet">
                    <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
            </a>
        </div>
    </li>
                <li>
                    <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                </li>
            </ul>
        </div>
    </li>
</template>

<script>
    export default {
        name: "notifications"
    }
</script>

<style scoped>

</style>
