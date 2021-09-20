# Remote-permission


### Установка
```shell
$ composer require ludovicose/remote-permission
```

### Добавить провайдер в config/app.php
```php
<?php
return [
        //...
        
        /*
         * Package Service Providers...
         */
        \Spark\RemotePermission\Providers\RemotePermissionServiceProvider::class,
        
        //..
];
```

### Переменные окружение
```env
REMOTE_SERVER_ADDRESS=http://gateway.loc 
REMOTE_SERVER_URI=/gateway/users/{userId}/permission/{permission} 
REMOTE_TRUE_STATUS_RESPONSE=201
REMOTE_FALSE_STATUS_RESPONSE=209
```
