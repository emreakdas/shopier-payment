<?php
// Değişkene göre kendiniz düzenleyebilirsiniz.
        include 'shopierAPI.php';
				$shopierKey = $pos['shopierKey'];
				$shopierSecret = $pos['shopierSecret'];
				$shopier = new Shopier($shopierKey, $shopierSecret);
				$shopier->setBuyer([
					'id' => $kods,
					'paket' => $paketbaslik,
					'first_name' => $ad, 'last_name' => $soyad, 'email' => $email, 'phone' => $telefon]);
				$shopier->setOrderBilling([
					'billing_address' => $acikadres,
					'billing_city' => $il,
					'billing_country' => $ulke,
					'billing_postcode' => $postakodu,
				]);
				$shopier->setOrderShipping([
					'shipping_address' => $acikadres,
					'shipping_city' => $il,
					'shipping_country' => $ulke,
					'shipping_postcode' => $postakodu,
				]);
				die($shopier->run($paketid, $fiyat, $callback));
?>
