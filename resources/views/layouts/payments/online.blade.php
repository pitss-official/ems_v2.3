<form method='post' action='{{$url}}' name='paytm_form' id="paynow">
    @foreach($params as $name => $value)
        <input type="hidden" name="{{$name}}" value="{{$value}}">
    @endforeach
    <input type="hidden" name="CHECKSUMHASH" value="{{$checksum}}">
</form>
