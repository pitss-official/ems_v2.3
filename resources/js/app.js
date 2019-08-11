/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import { loadProgressBar } from 'axios-progress-bar'
import VeeValidate from 'vee-validate'
import Swal from 'sweetalert2'
import {
    Form,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
} from 'vform';
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component(AlertErrors.name, AlertErrors);
Vue.component(AlertSuccess.name, AlertSuccess);

import DataTable from "datatables.net-bs";
// import "datatables.net-autofill-bs/js/autoFill.bootstrap";
import "datatables.net-buttons-bs";
import "datatables.net-colreorder-bs"
import "datatables.net-fixedcolumns-bs"
import "datatables.net-fixedheader-bs"
import "datatables.net-keytable-bs"
import "datatables.net-responsive-bs"
import "datatables.net-rowgroup-bs"
import "datatables.net-rowreorder-bs"
import "datatables.net-scroller-bs"
import "datatables.net-select-bs";
import "datatables.net-buttons-bs"
import "datatables.net-buttons/js/buttons.colVis.js"
import "datatables.net-buttons/js/buttons.print.js"
import "datatables.net-buttons/js/buttons.html5.js"
import "datatables.net-buttons/js/buttons.flash.js"
import pdfMake from "pdfmake/build/pdfmake.js"
import pdfFonts from "pdfmake/build/vfs_fonts.js"
import "bootstrap-switch"
pdfMake.vfs = pdfFonts.pdfMake.vfs;


Vue.use(VueRouter);
window.Swal=Swal;
window.swal=Swal;
window.Form=Form;
window.Toast = swal.mixin({
    toast: true,
    // position: 'top-end',
    showConfirmButton: true,
    // timer: 3000
});
window.linker1=0
Vue.use(VeeValidate);

let routes=[
    {path:'/home',component: require('./components/Personal/Dashboard').default},
    {path:'/test',component: require('./components/test1').default},
    {path:'/MyAccount/Settings',component: require('./components/Personal/Settings').default},
    {path:'/MyAccount/FinancialTransactions',component: require('./components/Personal/Transactions').default},
    {path:'/MyProfile/view',component: require('./components/Personal/Profile').default},
    {path:'/serve/forms/enrollment/new',component: require('./components/Forms/Enrollment').default},
    {path:'/serve/forms/enrollment/collectCash',component: require('./components/Forms/EnrollmentFees').default},
    {path:'/serve/forms/money/transferBalance/interMember',component: require('./components/Forms/TransferBalance').default},
    {path:'/serve/forms/money/requestBalance/interMember',component: require('./components/Forms/RequestBalance').default},
    {path:'/serve/forms/money/transfer/interMember/batch',component: require('./components/Forms/BatchMoneyTransfer').default},
    {path:'/serve/forms/search/transaction',component: require('./components/Interfaces/SearchTransaction').default},
    {path:'/serve/forms/event/new',component: require('./components/Forms/RegisterEvent').default},
    {path:'/serve/forms/venues/new',component: require('./components/Forms/AddEventVenue').default},
    {path:'/serve/forms/event/teams/new',component: require('./components/Forms/AddTeamForEvent').default},
    {path:'/serve/forms/enrollments/changeTeam',component: require('./components/Forms/ChangeTeam').default},
    {path:'/serve/forms/events/budgets/add',component: require('./components/Forms/AddBudget').default},
    {path:'/serve/forms/digitalAttendance/Scanner',component: require('./components/Digitalizers/Barcode').default},
    {path:'/serve/action/events/MarkStudentAttendance',component: require('./components/Forms/MarkEventAttendance').default},
    {path:'/serve/action/events/VerifyStudentAttendance',component: require('./components/Forms/VerifyAttendance').default},
    {path:'/serve/action/events/RequestSmartCard',component: require('./components/Forms/RequestSmartCard').default},
    {path:'*',component: require('./components/Global/404Error').default},
]
const router =new VueRouter({
    mode:'history',
    routes
})
loadProgressBar()
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('naiveLinkController', require('./components/Personal/Navigation').default);
Vue.component('naiveBreadcrumb', require('./components/Personal/Breadcumb').default);
Vue.component('naiveRightSideBar', require('./components/Personal/SideBar').default);
Vue.component('naiveQueues', require('./components/Personal/Queues').default);
Vue.component('naiveNotifications', require('./components/Personal/Notifications').default);
Vue.component('naiveMessages', require('./components/Personal/Messages').default);
Vue.component('moduleUnderConstruction', require('./components/Global/ModuleUnderConstruction').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
});

// // Make sure sw are supported
// if ('serviceWorker' in navigator) {
//     window.addEventListener('load', () => {
//         navigator.serviceWorker
//             .register('/serviceWorker.js')
//             .then(reg => console.log('Service Worker: Registered (Pages)'))
//             .catch(err => console.log(`Service Worker: Error: ${err}`));
//     });
// }
