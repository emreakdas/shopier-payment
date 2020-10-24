# Shopier
Shopier kredi kartı entegrasyonu nasıl yapılır? Shopier açık API sağlıyor mu? gibi bir çok konu ve makale bulunmakta. Bu konuya açıklık getirmek amacıyla Shopier hakkında sorulan soruları cevaplayıp ve kredi kartı entegrasyonunu nasıl yapabileceğinizden bahsedeceğim.

- Shopier Nedir?
Shopier aslında sanal pos sağlayan bir firma gibi gözükse de aslında sanal pos sağlayan bir firma değildir. Shopier kendi sitesi içerisinden ödeme almanızı sağlayan bir aracıdır.

- Shopier Açık API Sağlıyor mu?
Shopier herhangi bir açık API sağlamamakta. Müşteri hizmetlerinizi arasanız dahi kredi kartı entegrasyonu için herhangi bir açık API sağlamadıklarını dile getireceklerdir.

- Açık API Sağlamıyor Entegrasyon Nasıl Olacak?
Bu konu çokça kişinin belirli yerlerden belirli bir ücret karşılığında entegrasyon yapmalarını istediği bir konu fakat bu konuya açıklık getirecek olursam; Herhangi bir açık API dahi bulunmasa bile bu bizim entegrasyon yapmamamıza olanak sağlamayacaktır. Entegrasyon işlemini yazılan bir sınıf ile entegre edip kendi sitemizde girilen tutara göre ödeme almamızı sağlayacağız. Nasıl mı? Şöyle; Bu sınıf girilen tutara göre manuel bir ürün oluşturup ödeme almamızı sağlıyor aslında bu oluşturulan ürün ürünlerim kısmında gözükmese dahi hayali bir ürün diyebiliriz. Kullanıcı aldığı ürüne göre tutar bizim sitemizden gidiyor kredi kartı ile ödeme almamızı sağlıyor.

- Herhangi Bir Sorun Yaşar mıyım?
Bu yöntemi çoğu kişinin kullanması ile birlikte herhangi bir sorun yaşamadıklarını göreceksiniz. Yasal mı yaptığımız yöntem derseniz sizin adınıza açılan bir mağazada istediğiniz kadar ödeme alıp istediğiniz kadar ürün oluşturabilme yetkiniz nasıl var ise bu yöntemde yasaldır.

Entegrasyon için tarafıma günde bir ton mail geliyor entegrasyon yapmıyorum lütfen mail atmayınız!

- Shopier Kredi Kartı Entegrasyonu
Gelelim entegrasyon işlemini yapmaya. GitHub hesabımda açtığım bir repository de bu kaynak kodları size vereceğim. 5 Adımda entegrasyon işlemini yapalım.

Entegrasyon Dosyalarının İndirilmesi
İlk olarak GitHub hesabımdan dosyaları indiriniz.
Sınıfın Ödeme Alacağımız Sayfaya Dahil Edilip Paket ve Kullanıcı Bilgilerinin Gönderilmesi
İndirdiğiniz klasörde üç adet dosya bulunmakta bunlar;
index.php > Ödemeleri alacağımız sayfa.
ShopierAPI.php > Shopier kredi kartı sınıfı.
shopierNotify.php > Shopier gelen isteği karşılayacağımız callback yani geri dönüş sayfası.

Index dosyamızı açtığımızda şu kodlar bulunmakta bu kod blokları ne yapmakta onları açıklayayım;

<?php
// Değişkene göre kendiniz düzenleyebilirsiniz.
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
Geri Dönüş URL ve Geri Dönüş Sayfası
Bu adım ise indirdiğiniz dosyada shopierNotify.php dosyasına denk gelmekte. Bu dosya gönderdiğimiz bilgileri getirmekte eğer kredi kartı ile ödeme başarılı ise yapacaklarıma tekabül etmekte.
Not: Bu sayfa kullanıcının göreceği bir sayfa değildir kod bloklarının içerisinde locationtrue ve locationfalse değişkenleri kullanıcının eğer işlem başarısız ve başarılı ise göreceği sayfaya yönlendirdiğim kısımdır. Bu kısım opsiyonel olduğu için eklemedim.Siz istediğiniz sayfaya yönlendirebilirsiniz.

<?php
//Shopierdan gelen postlar.
$status = $_POST["status"];
$invoiceId = $_POST["platform_order_id"];
$transactionId = $_POST["payment_id"];
$installment = $_POST["installment"];
$signature = $_POST["signature"];

/* Bu kısımda kullanıcının işlem başarılı ve başarısızsa yönleneceği değişkenlerdir. */
$url = 'https://emreakdas.com/';
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
Entegrasyon Bitiş
Entegrasyon işlemimiz tam anlamıyla bitti. Entegrasyonun çalışır halini GitHub hesabım üzerinden indirebilirsiniz. (İndir)Aklınıza takılan herhangi bir soruyu yorum kısmında sormaktan çekinmeyiniz hepinize iyi entegrasyonlar 🙂 Tüm entegrasyonlar için; Bilgi
