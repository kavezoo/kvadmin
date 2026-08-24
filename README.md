# KvAdmin
KvAdmin plugin for Cakephp 5 projects based on Tabler Admin Template

#Usage
First of all you have to install the CakePhp ~5.4 ad after you can install this admin plugin
```bash
# composer create-project --prefer-dist cakephp/app:~5.4 my_app_name
# my_app_name
# composer require kavezoo/kvadmin
```

**src/Application.php**
Just add the plugin for **src/Application.php** file.
```php
    public function bootstrap(): void
    {
		...
		// Load more plugins here
		$this->addPlugin('KvAdmin', ['routes' => true, 'bootstrap' => true]);
		...
    }
```
**Add this line to end of the config/bootstrap.php file:**
```php
Configure::write('Bake.theme', 'KvAdmin');

Configure::write('Session', [
    'defaults' => 'php',
    'cookie' => 'NameOfCookie',
    'timeout' => 4320 // 3 days
]);
```

Add helpers to **src\View\AppView.php**
```php
    public function initialize(): void
    {
		parent::initialize();

		$this->loadHelper('KvAdmin.SystemIcon');
		$this->loadHelper('KvAdmin.Icon');
		$this->loadHelper('KvAdmin.KvForm');
    }
```

Add new folder in Controller folder: **Admin**
Controller/Admin

Create **AppController.php* in this folder with next content:

```php
<?php
declare(strict_types=1);

namespace App\Controller\Admin;
use KvAdmin\Controller\AppController as KvAdminAppController;

class AppController extends KvAdminAppController
{
    public function initialize(): void
    {
        parent::initialize();

    }
}
```

Create Admin prefix in route.php in config folder
```php
	$routes->prefix('Admin', function (RouteBuilder $builder) {
		$builder->setRouteClass(DashedRoute::class);
		$builder->connect('/', ['controller' => 'Cities', 'action' => 'index']);
		$builder->fallbacks();
	});
```

And now you can bake the admin files:
```bash
# cake bake model all
# cake bake controller all --prefix admin
# cake bake template all --prefix admin
```

If you wanna more prefix yust create it for example:
Add to route.php and bake it:
```php
	$routes->prefix('Member', function (RouteBuilder $builder) {
		$builder->setRouteClass(DashedRoute::class);
		$builder->connect('/', ['controller' => 'Clubs', 'action' => 'index']);
		$builder->fallbacks();
	});
```

Create **AppController.php* in Controller/Member folder with next content:

```php
<?php
declare(strict_types=1);

namespace App\Controller\Member;
use KvAdmin\Controller\AppController as KvAdminAppController;

class AppController extends KvAdminAppController
{
    public function initialize(): void
    {
        parent::initialize();

    }
}
```


```bash
# cake bake model all
# cake bake controller all --prefix member
# cake bake template all --prefix member
```

**You can customize the menu**:
Just copy the next files to your's prefix folder in **templates/Admin/element** and edit this own files:
```bash
# cp vendor/kavezoo/kvadmin/templates/element/header.php templates/Admin/element/header.php
# cp vendor/kavezoo/kvadmin/templates/element/topheader.php templates/Admin/element/topheader.php
# cp vendor/kavezoo/kvadmin/templates/element/footer.php templates/Admin/element/footer.php
# cp vendor/kavezoo/kvadmin/templates/element/topheader_user_menu.php templates/Admin/element/topheader_user_menu.php
```


Enjoy it!




