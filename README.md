[![GitHub stars](https://img.shields.io/github/stars/emreakdas/shopier-payment.svg?style=social&label=Star&maxAge=2592000)](https://GitHub.com/emreakdas/shopier-payment/stargazers/)
[![GitHub watchers](https://img.shields.io/github/watchers/emreakdas/shopier-payment.svg?style=social&label=Watch&maxAge=2592000)](https://GitHub.com/emreakdas/shopier-payment/watchers/)
[![GitHub forks](https://img.shields.io/github/forks/emreakdas/shopier-payment.svg?style=social&label=Fork&maxAge=2592000)](https://GitHub.com/emreakdas/shopier-payment/network/)
[![Github all releases](https://img.shields.io/github/downloads/emreakdas/shopier-payment/total.svg)](https://GitHub.com/emreakdas/shopier-payment/releases/)
[![MIT license](https://img.shields.io/badge/License-MIT-blue.svg)](https://lbesson.mit-license.org/)

[logo]: https://i.hizliresim.com/D3WMz1.png
![logo]

### Usage

    ```php
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
    ```
    
- CallBack Page

  ```php
  <?php
    $status = $_POST["status"];
    $invoiceId = $_POST["platform_order_id"];
    $transactionId = $_POST["payment_id"];
    $installment = $_POST["installment"];
    $signature = $_POST["signature"];

    $data = $_POST["random_nr"] . $_POST["platform_order_id"] . $_POST["total_order_value"] . $_POST["currency"];
    $signature = base64_decode($signature);
    $expected = hash_hmac('SHA256', $data, $shopierSecret, true);
    if ($signature == $expected) {
      $status = strtolower($status);

      if ($status == "success") {
        //Status success
      } else {
        //Status error
      }
    }
  ?>
  ```

### Bilgilendirme
Bu API unofficial api'dir. Herhangi bir sorun veya sorunlardan sorumlu değilim bilginize. Bu API kullanan bu şartlandırmayı kabul etmiş sayılır.
### Lisans
Shopier API [MIT](https://opensource.org/licenses/mit-license.php) lisansı altında lisanslanan açık kaynaklı bir api'dir.
