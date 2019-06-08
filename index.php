<?php
include 'shopierAPI.php'; // İndirdiğimiz dosyada bulunan sınıfımızı dosyaya dahil ediyoruz.
$shopier = new Shopier('SHOPIER_API_KEY', 'SHOPIER_API_SECRET'); // Kendi api bilgilerinizi gireceksiniz.
$shopier->setBuyer([ // Kullanıcı bilgileri
'id' => '123456', // Sipariş kodu
'paket' => 'Eti Canga', // Paket adı
'first_name' => 'Emre', 'last_name' => 'AKDAŞ', 'email' => 'info@emreakdas.com', 'phone' => '05555555555']); // Kullanıcının ad, soyad, telefon, email bilgileri
$shopier->setOrderBilling([
'billing_address' => 'Meclis Mahallesi Emre Caddesi No:544564', //Kullanıcının adresi
'billing_city' => 'İstanbul', // İl
'billing_country' => 'Türkiye', //Ülke
'billing_postcode' => '34000', //Posta Kodu
]);
$shopier->setOrderShipping([
'shipping_address' => 'Meclis Mahallesi Emre Caddesi No:544564', //Kullanıcının adresi
'shipping_city' => 'İstanbul', // İl
'shipping_country' => 'Türkiye', //Ülke
'shipping_postcode' => '34000', //Posta Kodu
]);
die($shopier->run('544546545', 50, 'https://emreakdas.com/shopierNotify.php')); // Burada üç adet parametre göndermemiz gerekiyor ilk olarak paket id sonra fiyat daha sonrasında ise geri dönüş url mağazadaki girdiğiniz geri dönüş url ile aynı olması gerekiyor bu dosyamız da shopierNotfiy.php dosyamız oluyor.
?>
