@component('mail::message')
# Your Smart Card Sheet is Ready to be printed

Please download the attached file from the below button. If you face any problem, kindly mail us at sysmaster@oms.megaminds.club;

@component('mail::button', ['url' => $link])
Download Sheet
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
