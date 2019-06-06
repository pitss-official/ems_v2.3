// window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
//
try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('popper.js').default;
//
//     //require('bootstrap');
    require( 'jszip' );
    require( 'pdfmake' );
    require( 'datatables.net-bs' )(window,$);
    require( 'datatables.net-autofill-bs' )(window,$);
    require( 'datatables.net-buttons-bs' )(window,$);
    require('datatables.net-buttons-bs/js/buttons.bootstrap.min')(window,$);
    require( 'datatables.net-buttons/js/buttons.colVis.js' )(window,$);
    require( 'datatables.net-buttons/js/buttons.flash.js' )(window,$);
    require( 'datatables.net-buttons/js/buttons.html5.js' )(window,$);
    require( 'datatables.net-buttons/js/buttons.print.js' )(window,$);
    require( 'datatables.net-colreorder-bs' )(window,$);
    require( 'datatables.net-fixedcolumns-bs' )(window,$);
    require( 'datatables.net-fixedheader-bs' )(window,$);
    require( 'datatables.net-keytable-bs' )(window,$);
    require( 'datatables.net-responsive-bs' )(window,$);
    require( 'datatables.net-rowgroup-bs' )(window,$);
    require( 'datatables.net-rowreorder-bs' )(window,$);
    require( 'datatables.net-scroller-bs' )(window,$);
    require( 'datatables.net-select-bs' )(window,$);
    pdfMake = require('pdfmake/build/pdfmake.js');
    pdfFonts = require('pdfmake/build/vfs_fonts.js');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
