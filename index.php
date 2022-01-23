<?php
include 'shopierAPI.php'; 
$shopier = new Shopier('SHOPIER_API_KEY', 'SHOPIER_API_SECRET');
$shopier->setBuyer([ 
'id' => '123456',
'paket' => 'Eti Canga', 
'first_name' => 'Emre', 'last_name' => 'AKDAŞ', 'email' => 'mail@mail.com', 'phone' => '05555555555']); 
$shopier->setOrderBilling([
'billing_address' => 'Cemal Gürsel Caddesi No:544564',
'billing_city' => 'İstanbul',
'billing_country' => 'Türkiye',
'billing_postcode' => '34000',
]);
$shopier->setOrderShipping([
'shipping_address' => 'Cemal Gürsel Caddesi No:544564', 
'shipping_city' => 'İstanbul',
'shipping_country' => 'Türkiye',
'shipping_postcode' => '34000', 
]);
die($shopier->run('544546545', 50, 'https://siteadi.com/shopierNotify.php'));
?>
