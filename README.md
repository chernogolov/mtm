# MTM
MultiTool Manager - Laravel admin panel

#Installation

1. composer require chernogolov/mtm
2. php artisan breeze:install
3. php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
4. php artisan vendor:publish --tag=public --force
5. php artisan migrate
7. remove welcome and dashboard routes form routes/web.php
8. php artisan make:model ModelName -mc
9. add resource route routes/web.php Route::resource('ResourceName', HouseController::class)->middleware(['web', 'auth', 'verified']);
11. add to controller

```rb
namespace App\Http\Controllers;

use Chernogolov\Mtm\Controllers\CrudBaseController;
use Illuminate\Http\Request;
 
class HouseController extends CrudBaseController{
    public $modelName = 'House';
    public function __construct(){
      parent::__construct();
   }
}
```
    
#Usage

1. Create models
2. Add resources in /resources
3. Set up resources 
