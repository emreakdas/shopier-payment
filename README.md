[![GitHub stars](https://img.shields.io/github/stars/emreakdas/shopier-payment.svg?style=social&label=Star&maxAge=2592000)](https://GitHub.com/emreakdas/shopier-payment/stargazers/)
[![GitHub watchers](https://img.shields.io/github/watchers/emreakdas/shopier-payment.svg?style=social&label=Watch&maxAge=2592000)](https://GitHub.com/emreakdas/shopier-payment/watchers/)
[![GitHub forks](https://img.shields.io/github/forks/emreakdas/shopier-payment.svg?style=social&label=Fork&maxAge=2592000)](https://GitHub.com/emreakdas/shopier-payment/network/)
[![Github all releases](https://img.shields.io/github/downloads/emreakdas/shopier-payment/total.svg)](https://GitHub.com/emreakdas/shopier-payment/releases/)
[![MIT license](https://img.shields.io/badge/License-MIT-blue.svg)](https://lbesson.mit-license.org/)

[logo]: https://i.hizliresim.com/D3WMz1.png
![logo]
# Shopier Nedir? Entegrasyon Nasıl Yapılır?
Shopier aslında sanal pos sağlayan bir firma gibi gözükse de aslında sanal pos sağlayan bir firma değildir. Shopier kendi sitesi içerisinden ödeme almanızı sağlayan bir aracıdır.

### Shopier Açık API Sağlıyor mu?
Shopier herhangi bir açık API sağlamamakta. Müşteri hizmetlerinizi arasanız dahi kredi kartı entegrasyonu için herhangi bir açık API sağlamadıklarını dile getireceklerdir.

### Açık API Sağlamıyor Entegrasyon Nasıl Olacak?
Bu konu çokça kişinin belirli yerlerden belirli bir ücret karşılığında entegrasyon yapmalarını istediği bir konu fakat bu konuya açıklık getirecek olursam; Herhangi bir açık API dahi bulunmasa bile bu bizim entegrasyon yapmamamıza olanak sağlamayacaktır. Entegrasyon işlemini yazılan bir sınıf ile entegre edip kendi sitemizde girilen tutara göre ödeme almamızı sağlayacağız. Nasıl mı? Şöyle; Bu sınıf girilen tutara göre manuel bir ürün oluşturup ödeme almamızı sağlıyor aslında bu oluşturulan ürün ürünlerim kısmında gözükmese dahi hayali bir ürün diyebiliriz. Kullanıcı aldığı ürüne göre tutar bizim sitemizden gidiyor kredi kartı ile ödeme almamızı sağlıyor.

### Herhangi Bir Sorun Yaşar mıyım?
Bu yöntemi çoğu kişinin kullanması ile birlikte herhangi bir sorun yaşamadıklarını göreceksiniz. Yasal mı yaptığımız yöntem derseniz sizin adınıza açılan bir mağazada istediğiniz kadar ödeme alıp istediğiniz kadar ürün oluşturabilme yetkiniz nasıl var ise bu yöntemde yasaldır.

### Shopier Entegrasyon
- Entegrasyon Dosyalarının İndirilmesi
- Sınıfın Ödeme Alacağımız Sayfaya Dahil Edilip Paket ve Kullanıcı Bilgilerinin Gönderilmesi.
  İndirdiğiniz klasörde üç adet dosya bulunmakta bunlar;
    - index.php > Ödemeleri alacağımız sayfa.
    - ShopierAPI.php > Shopier kredi kartı sınıfı.
    - shopierNotify.php > Shopier gelen isteği karşılayacağımız callback yani geri dönüş sayfası.
    
    Index dosyamızı açtığımızda şu kodlar bulunmakta bu kod blokları ne yapmakta onları açıklayayım;
    
    ```php
    <?php
    // Değişkene göre kendiniz düzenleyebilirsiniz.
    include 'shopierAPI.php'; // İndirdiğimiz dosyada bulunan sınıfımızı dosyaya dahil ediyoruz.
    $shopier = new Shopier('SHOPIER_API_KEY', 'SHOPIER_API_SECRET'); // Kendi api bilgilerinizi gireceksiniz.
    $shopier->setBuyer([ // Kullanıcı bilgileri
    'id' => '123456', // Sipariş kodu
    'paket' => 'Eti Canga', // Paket adı
    'first_name' => 'Emre', 'last_name' => 'AKDAŞ', 'email' => 'mail@siteadi.com', 'phone' => '05555555555']); // Kullanıcının ad, soyad, telefon, email bilgileri
    $shopier->setOrderBilling([
    'billing_address' => 'Emre Caddesi No:544564', //Kullanıcının adresi
    'billing_city' => 'İstanbul', // İl
    'billing_country' => 'Türkiye', //Ülke
    'billing_postcode' => '34000', //Posta Kodu
    ]);
    $shopier->setOrderShipping([
    'shipping_address' => 'İstanbul/Şişli No:544564', //Kullanıcının adresi
    'shipping_city' => 'İstanbul', // İl
    'shipping_country' => 'Türkiye', //Ülke
    'shipping_postcode' => '34000', //Posta Kodu
    ]);
    die($shopier->run('544546545', 50, 'https://siteadi.com/shopierNotify.php')); // Burada üç adet parametre göndermemiz gerekiyor ilk olarak paket id sonra fiyat daha sonrasında ise geri dönüş url mağazadaki girdiğiniz geri dönüş url ile aynı olması gerekiyor bu dosyamız da shopierNotfiy.php dosyamız oluyor.
    ?>
    ```
    
- Geri Dönüş URL ve Geri Dönüş Sayfası
Bu adım ise indirdiğiniz dosyada shopierNotify.php dosyasına denk gelmekte. Bu dosya gönderdiğimiz bilgileri getirmekte eğer kredi kartı ile ödeme başarılı ise yapacaklarıma tekabül etmekte.
Not: Bu sayfa kullanıcının göreceği bir sayfa değildir kod bloklarının içerisinde locationtrue ve locationfalse değişkenleri kullanıcının eğer işlem başarısız ve başarılı ise göreceği sayfaya yönlendirdiğim kısımdır. Bu kısım opsiyonel olduğu için eklemedim.Siz istediğiniz sayfaya yönlendirebilirsiniz.

  ```php
  <?php
  //Shopierdan gelen postlar.
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
  //İşlem başarılı ise yapacaklarınız
  }
  else{
  // İşlem başarısız ise yapacaklarınız.
  }
  }
  ?>
  ```
- Entegrasyon işlemi bu kadar sormak istediğiniz herhangi bir soruyu issues açarak sorabilirsiniz. Sağlıklı günler :)
### Bilgilendirme
Bu API unofficial api'dir. Herhangi bir sorun veya sorunlardan sorumlu değilim bilginize. Bu API kullanan bu şartlandırmayı kabul etmiş sayılır.
### Lisans
Shopier API [MIT](https://opensource.org/licenses/mit-license.php) lisansı altında lisanslanan açık kaynaklı bir api'dir.
