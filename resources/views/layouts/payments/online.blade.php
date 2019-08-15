<!-- Prepare HTML Form and Submit to Paytm -->

<html>
<head>
    <title>Merchant Checkout Page</title>
</head>
<body>
<center><h1>Please do not refresh this page...</h1></center>
<form method='post' action='<?php echo $url; ?>' name='paytm_form'>
    <?php
    foreach($paytmParams as $name => $value) {
        echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
    }
    ?>
    <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checksum ?>">
</form>
<script type="text/javascript">
    document.paytm_form.submit();
</script>
</body>
</html>
