// Theme color settings
$(document).ready(function(){
function store(val) {
    $('.ti-close.right-side-toggle').click();
    axios({
        method:'get',
        url:'/api/put/user/theme/'+val
    }).then((response)=>{
        Toast.fire({
            type: 'success',
            position: 'bottom',
            text: response.data.message,
            showConfirmButton: true,
            timer:10000,
        });
    })
  }
 $("*[data-theme]").click(function(e){
      e.preventDefault();
        var currentStyle = $(this).attr('data-theme');
        store(currentStyle);
        $('#theme').attr({href: '/css/colors/'+currentStyle+'.css'})
    });

    // var currentTheme = get('theme');
    // if(currentTheme)
    // {
    //   $('#theme').attr({href: '/css/colors/'+currentTheme+'.css'});
    // }
    // color selector
    $('#themecolors').on('click', 'a', function(){
        $('#themecolors li a').removeClass('working');
        $(this).addClass('working')
      });

});
// $(document).ready(function(){
//
//     $("*[data-theme]").click(function(e){
//       e.preventDefault();
//         var currentStyle = $(this).attr('data-theme');
//         store('theme', currentStyle);
//         $('#theme').attr({href: 'css/colors/'+currentStyle+'.css'})
//     });
//
//     var currentTheme = get('theme');
//     if(currentTheme)
//     {
//       $('#theme').attr({href: 'css/colors/'+currentTheme+'.css'});
//     }
//     // color selector
// $('#themecolors').on('click', 'a', function(){
//         $('#themecolors li a').removeClass('working');
//         $(this).addClass('working')
//       });
// });
