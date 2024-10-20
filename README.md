# MTM
MultiTool Manager - Многофункциональная админ панель для Laravel.

#Установка

1. composer require chernogolov/mtm
2. php artisan breeze:install
3. php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
4. php artisan vendor:publish --tag=public --force
5. php artisan migrate
7. Удалите welcome and dashboard маршруты form routes/web.php
8. Отредактируйте модель User - Добавьте трейт HasRoles
```rb
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;
...
}
```
9. Запустите npm run build
10. Установите Trix Editor для работы с редактором
```rb
php artisan richtext:install
```

#Использование
1. Создайте миграцию, модель и контроллер
```rb
php artisan make:model Post -mc
```
2. Добавьте ресурс в маршруты routes/web.php
```rb
Route::resource('post', PostController::class)->middleware(['web', 'auth', 'verified']);
```
3. Наследуйте контроллер CrudBaseController для включения базового функционала. Пример ниже:
```rb
namespace App\Http\Controllers;

use Chernogolov\Mtm\Controllers\CrudBaseController;
use Illuminate\Http\Request;
 
class PostController extends CrudBaseController{
    public $modelName = 'Post';
    public function __construct(){
      parent::__construct();
   }
}
```
4. Настройте ресурс в панели управления.

    


