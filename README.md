# KvAdmin

KvAdmin plugin for CakePHP 5 projects based on the [Tabler Admin Template](https://tabler.io).

## Usage

First, create a CakePHP ~5.4 project, then install the KvAdmin plugin:

```bash
composer create-project --prefer-dist cakephp/app:~5.4 my_app_name
cd my_app_name
composer require kavezoo/kvadmin
```

### 1. Load the Plugin
Add the plugin to your `src/Application.php` file:

```php
public function bootstrap(): void
{
    parent::bootstrap();

    // Load more plugins here
    $this->addPlugin('KvAdmin', ['routes' => true, 'bootstrap' => true]);
}
```

### 2. Configure Bootstrap
Add the following lines to the end of your `config/bootstrap.php` file:

```php
use Cake\Core\Configure;

Configure::write('Bake.theme', 'KvAdmin');

Configure::write('Session', [
    'defaults' => 'php',
    'cookie' => 'NameOfCookie',
    'timeout' => 4320, // 3 days
]);
```

### 3. Load Helpers
Add the KvAdmin helpers to `src/View/AppView.php`:

```php
public function initialize(): void
{
    parent::initialize();

    $this->loadHelper('KvAdmin.SystemIcon');
    $this->loadHelper('KvAdmin.Icon');
    $this->loadHelper('KvAdmin.KvForm');
}
```

### 4. Create Admin Controller Directory & AppController
Create a new directory: `src/Controller/Admin/`

Create `src/Controller/Admin/AppController.php` with the following content:

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

### 5. Define Admin Routes
Add the `Admin` prefix in `config/routes.php`:

```php
$routes->prefix('Admin', function (RouteBuilder $builder) {
    $builder->setRouteClass(DashedRoute::class);
    $builder->connect('/', ['controller' => 'Cities', 'action' => 'index']);
    $builder->fallbacks();
});
```

### 6. Bake the Admin Files
Now you can bake your models, controllers, and templates using the Tabler theme:

```bash
bin/cake bake model all
bin/cake bake controller all --prefix admin
bin/cake bake template all --prefix admin
```

---

## Multiple Prefixes (e.g. Member)

If you need additional prefixes (like `Member`), follow the same pattern:

1. Add the prefix to `config/routes.php`:
```php
$routes->prefix('Member', function (RouteBuilder $builder) {
    $builder->setRouteClass(DashedRoute::class);
    $builder->connect('/', ['controller' => 'Clubs', 'action' => 'index']);
    $builder->fallbacks();
});
```

2. Create `src/Controller/Member/AppController.php`:
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

3. Bake files for the new prefix:
```bash
bin/cake bake controller all --prefix member
bin/cake bake template all --prefix member
```

---

## Customizing Layout Elements & Menu

To customize headers, footers, or navigation, copy the default elements from the plugin into your project's prefix directory (e.g. `templates/Admin/element/`):

```bash
mkdir -p templates/Admin/element
cp vendor/kavezoo/kvadmin/templates/element/header.php templates/Admin/element/header.php
cp vendor/kavezoo/kvadmin/templates/element/topheader.php templates/Admin/element/topheader.php
cp vendor/kavezoo/kvadmin/templates/element/footer.php templates/Admin/element/footer.php
cp vendor/kavezoo/kvadmin/templates/element/topheader_user_menu.php templates/Admin/element/topheader_user_menu.php
```

---

Built with [Tabler UI](https://tabler.io). Enjoy it!
