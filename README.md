# İletiMerkezi Laravel Paketi

Bu paket, İletiMerkezi API'sini kullanarak Laravel projelerinizde SMS gönderimi yapmanızı sağlar. Paket, Laravel Notification Channel ve Facade olarak kullanılabilir.

## Kurulum

1. **Composer ile paketi yükleyin:**

   ```sh
   composer require iletimerkezi/iletimerkezi-laravel
    ```    

2. **Konfigürasyon Dosyasını Yayınlayın:**

    ```sh
    php artisan vendor:publish --tag=iletimerkezi-config
    ```

3. `config/iletimerkezi.php` dosyasını açın ve API anahtarınızı ve gönderici adınızı girin.

    ```sh
    key=API_ANAHTARINIZ
    hash=API_HASH
    sender=ONAYLI_BASLIGINIZ
    ```

## Kullanım Örnekleri

### Facade ile Kullanım

```php
<?php
use IletiMerkezi\Facades\IletiMerkezi;

// Tek bir numaraya SMS gönderimi
IletiMerkezi::sms()->send('505xxxxxxx', 'Mesaj içeriği');

// Birden fazla numaraya SMS gönderimi
IletiMerkezi::sms()->send(['505xxxxxxx', '505xxxxxxx'], 'Mesaj içeriği');
```

### Notification Channel ile Kullanım

1. İletiMerkezi kanalını kullanarak bir bildirim sınıfı oluşturun:

    ```sh
    php artisan make:notification OrderShipped
    ```

2. `OrderShipped` sınıfını aşağıdaki gibi düzenleyin:

    ```php
    <?php
    use Illuminate\Notifications\Notification;
    use IletiMerkezi\SMS\IletiMerkeziMessage;

    class OrderShipped extends Notification
    {
        public function via($notifiable)
        {
            return ['iletimerkezi'];
        }

        public function toIletiMerkezi($notifiable)
        {
            return IletiMerkeziMessage::create('Siparişiniz kargoya verilmiştir.')
                ->setIys(false, 'TACIR')
                // Opsiyonel: Gönderici adını belirler
                ->setSender('IletiMerkezi')
                // Opsiyonel: Gönderim zamanını belirler
                ->sendAt(now()->addMinutes(10)); 
        }
    }
    ```

3. Kullanıcı Modelinde Telefon Numarasını Tanımlayın:

    ```php
    <?php
    public function routeNotificationForIletiMerkezi()
    {
        return $this->phone_number; // Kullanıcının telefon numarası alanı
    }
    ```

4. Kullanıcıya SMS göndermek için `notify` yöntemini kullanın:

    ```php
    <?php
    use App\Notifications\OrderShipped;

    $user->notify(new OrderShipped());
    ```

## Desteklenen Laravel Sürümleri

    - Laravel 7.x
    - Laravel 8.x
    - Laravel 9.x
    - Laravel 10.x
    - Laravel 11.x