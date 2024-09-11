# MTM
MultiTool Manager - Laravel admin panel

#Installation

1. composer require chernogolov/mtm
2. php artisan breeze:install
3. php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
4. php artisan vendor:publish --tag=public --force
5. php artisan migrate
7. remove welcome and dashboard routes form routes/web.php

#Usage

1. Create models
2. Add resources in /resources
3. Set up resources 
