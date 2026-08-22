<?php
namespace KvAdmin\View\Helper; // <-- NEM App\View\Helper!

use Cake\Routing\Router;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;

class SystemIconHelper extends Helper
{
	use StringTemplateTrait;
	
	protected array $_defaultConfig = [
        'spritePath' => '/icons/icons.svg',
        'templates' => [
            'icon' => '<svg class="icon icon-{{name}} {{class}}" {{attrs}}><use xlink:href="{{sprite}}#icon-{{name}}"></use></svg>',
        ],
		'defaultSize' => 24,
    ];
	
    // A leggyakoribb Tabler ikonok path-jai
    protected array $sysIcons = [
		// CRUD ikonok
		'plus' => '<path d="M12 5l0 14"></path><path d="M5 12l14 0"></path>',
		'view' => '<path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>',
        'edit' => '<path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path><path d="M16 5l3 3"></path>',
        'delete' => '<path d="M18 6l-12 12"></path><path d="M6 6l12 12"></path>',

		// LINK ikonok
		'link' => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-inline"><path d="M9 15l6 -6" /><path d="M11 6l0.468 -.469a4.914 4.914 0 0 1 6.95 0a4.914 4.914 0 0 1 0 6.95l-.468 .469" /><path d="M13 18l-.469 .469a4.914 4.914 0 0 1 -6.95 0a4.914 4.914 0 0 1 0 -6.95l.467 -.468" /></svg>',
		
		// Nyilak a paginátorhoz:
		'prev' => '<path d="M15 6l-6 6l6 6"></path>',
		'next' => '<path d="M9 6l6 6l-6 6"></path>',
		'first' => '<path d="M11 7l-5 5l5 5"></path><path d="M17 7l-5 5l5 5"></path>',
		'last' => '<path d="M7 7l5 5l-5 5"></path><path d="M13 7l5 5l-5 5"></path>',
		'sort-asc-desc' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" class="arrow-up"><path d="M4 18l8 -10l8 10" /></svg><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" class="arrow-down"><path d="M4 6l8 10l8 -10" /></svg>',

		// Egyéb rendszer ikonok
		'settings' => '<path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>',
		'search' => '<path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path>',
		'dots' => '<path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>',

		// Logikai (boolean) ikonok:
        'check' => '<path d="M5 12l5 5l10 -10"></path>',
        'x' => '<path d="M18 6l-12 12"></path><path d="M6 6l12 12"></path>',
    ];

	/*
		Kérdés MODAL ablakhoz ikon jel
	*/
    protected array $modalIcons = [
		'success' 	=> '',
		'warning' 	=> '',
		'info' 		=> '',
		'alert' 	=> '<path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path>',

    ];

	
	/**
     * Ikon HTML renderelése
     *
     * @param string $name Az ikon neve (pl. 'activity', 'a-b', 'alarm')
     * @param array $options Opcionális osztályok, méretek vagy attribútumok
     * @return string
     */
	public function render(string $name, array $options = []): string
    {
        $class = $options['class'] ?? '';
        unset($options['class']);

		// A $this->Url->build() HETETT a Router::url()-t használjuk:
        $spritePath = (string)$this->getConfig('spritePath');
        $sprite = Router::url('/' . ltrim($spritePath, '/'));
		
        $attrs = $this->templater()->formatAttributes($options);

        return $this->formatTemplate('icon', [
            'name' => h($name),
            'class' => h($class),
            'sprite' => $sprite,
            'attrs' => $attrs,
        ]);
    }	
	
	
    /**
     * Visszaadja a Tabler SVG ikont HTML-ként
     */
    public function sysIcon(string $name, string $extraClass = 'icon-1'): string
    {
        if (!isset($this->sysIcons[$name])) {
            return '';
        }

        return sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon %s">%s</svg>',
            h($extraClass),
            $this->sysIcons[$name]
        );
    }

    /**
     * Visszaadja a Tabler SVG ikont HTML-ként
     */
	public function modalIcon(string $name, string $extraClass = 'icon-1'): string
    {
        if (!isset($this->modalIcons[$name])) {
            return '';
        }

        return sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon %s">%s</svg>',
            h($extraClass),
            $this->modalIcons[$name]
        );
    }

	/**
	 * Logikai (boolean) érték megjelenítése ikonként
	 */
	public function boolean(?bool $value, string $trueTitle = 'Active', string $falseTitle = 'Inactive'): string
	{
		$icon = $value ? 'check' : 'x';
		$class = $value ? 'text-success' : 'text-muted opacity-25';
		$title = $value ? __($trueTitle) : __($falseTitle);

		return sprintf(
			'<span class="%s" data-bs-toggle="tooltip" data-bs-placement="top" title="%s">%s</span>',
			$class,
			h($title),
			$this->render($icon)
		);
	}	
	
}
?>