<!doctype html>
<html lang="en">
<head>
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport"--}}
{{--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>QR Sheet</title>
    <style>
        td { text-align: center; }
        @page { margin: 0px; }
        body { margin: 0.25cm; }
    </style>
</head>
<body>
<script>
    function getImage(id) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'somewhere', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            // do something to response
            console.log(this.responseText);
        };
        xhr.send('user=person&pwd=password&organization=place&requiredkey=key');
    }
</script>
<div style="left: -3cm">
    <table style="">
        @foreach($qrs as $qs)
        <tr>
            @foreach($qs as $qr)
            <td>
                <table style="border: solid black; fill: black;">
                    <tr>
                        <td style="align-items: center"><span style="font-size: 7mm">RS{{$qr['value']}}</span></td>
                    </tr>
                    <tr>
                        <td><img style="height: 1in;width: 1in;" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={'type':'c','id'={{$qr['id']}}}" alt=""></td>
                    </tr>
                    <tr>
                        <td style="align-items: center"><span style="font-size: 4mm">{{$qr['id']}}</span></td>
                    </tr>
                </table>
            </td>
                @endforeach
        </tr>
            @endforeach
    </table>
</div>
</body>
</html>
