<?php
//Shopierdan gelen postlar.
$status = $_POST["status"];
$invoiceId = $_POST["platform_order_id"];
$transactionId = $_POST["payment_id"];
$installment = $_POST["installment"];
$signature = $_POST["signature"];

/* Bu kısımda kullanıcının işlem başarılı ve başarısızsa yönleneceği değişkenlerdir. */
$url = 'https://siteadi.com/';
$locationtrue = $url."order?orderNo=$invoiceId";
$locationfalse = $url."order?orderNo=none";
/* Bu kısımda kullanıcının işlem başarılı ve başarısızsa yönleneceği değişkenlerdir. */

$data = $_POST["random_nr"] . $_POST["platform_order_id"] . $_POST["total_order_value"] . $_POST["currency"];
$signature = base64_decode($signature);
$expected = hash_hmac('SHA256', $data, $shopierSecret, true);
if ($signature == $expected) {
$status = strtolower($status);
if ($status == "success") {
//İşlem başarılı ise yapacaklarınız
header("Location: $locationtrue");
}
else{
// İşlem başarısız ise yapacaklarınız.
header("Location: $locationfalse");
}
}
?>
