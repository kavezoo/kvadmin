<?php
declare(strict_types=1);

namespace KvAdmin\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
	public $session = '';
	public $prefix = '';
	public $controller = '';
	public $action = '';
	//public $plugin = '';
	//public $namespace = '';
	//public $controllerClass = '';
	//public $controllerPath = '';

    public function initialize(): void
    {
        parent::initialize();

        $this->session = $this->getRequest()->getSession() ?? null;
        $this->prefix = $this->request->getParam('prefix') ?? '';
		$this->controller = $this->request->getParam('controller') ?? '';
		$this->action = $this->request->getParam('action') ?? '';
		//$this->plugin = $this->request->getParam('plugin');
		//$this->namespace = $this->request->getParam('namespace');
		//$this->controllerClass = $this->request->getParam('controllerClass');
		//$this->controllerPath = $this->request->getParam('controllerPath');

        $this->set('session', $this->session);
        $this->set('prefix', $this->prefix);
		$this->set('controller', $this->controller);
		$this->set('action', $this->action);
		//$this->set('plugin', $this->plugin);
		//$this->set('namespace', $this->namespace);
		//$this->set('controllerClass', $this->controllerClass);
		//$this->set('controllerPath', $this->controllerPath);

        // Beállítja a /kv_admin/templates/layout/default.php fájlt alapértelmezettnek
        $this->viewBuilder()->setLayout('KvAdmin.default');
    }
}


