<?php
declare(strict_types=1);

namespace KvAdmin\View\Helper; // <-- NEM App\View\Helper!

use Cake\Core\Plugin;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;

class IconHelper extends Helper
{
    use StringTemplateTrait;

    protected array $_defaultConfig = [
        'basePath' => 'icons',
        'defaultType' => 'outline', // Ha nem adod meg, alapból az outline-ból tölti be
        'templates' => [
            'icon' => '<span class="icon icon-{{name}} icon-{{type}} {{class}}" {{attrs}}>{{svg}}</span>',
        ],
    ];

    /**
     * Belső memóriagyorsítótár (Cache), hogy ugyanazt a fájlt 
     * egy oldalbetöltésen belül csak egyszer olvassa be a lemezről.
     */
    protected array $_svgCache = [];

    /**
     * Ikon renderelése a megadott mappából
     *
     * @param string $name Az SVG fájl neve (.svg nélkül, pl. 'a-b', 'alarm')
     * @param array $options Konfiguráció: 'type' => 'outline'|'filled', 'class' => '...', stb.
     * @return string
     */
    public function render(string $name, array $options = []): string
    {
        // Meghatározzuk, hogy 'outline' vagy 'filled' mappát használja-e
        $type = $options['type'] ?? $this->getConfig('defaultType');
        unset($options['type']);

        $class = $options['class'] ?? '';
        unset($options['class']);

        // A pontos fájlelérési út a webroot-on belül
        $basePath = rtrim((string)$this->getConfig('basePath'), '/');
        $filePath = WWW_ROOT . $basePath . DS . $type . DS . $name . '.svg';

		if (!file_exists($filePath)) {
			// A plugin belső webroot mappájának fizikai útvonala:
			$pluginPath = Plugin::path('KvAdmin');
			$filePath = $pluginPath . 'webroot' . DS . 'icons' . DS . $type . DS . $name . '.svg';
		}

		if (file_exists($filePath)) {
			$svgContent = file_get_contents($filePath);
		}

        $svgContent = $this->_getSvgContent($filePath);

        if (!$svgContent) {
            return sprintf('<!-- Icon "%s" not found in /%s/%s/ -->', h($name), h($basePath), h($type));
        }

        $attrs = $this->templater()->formatAttributes($options);

        return $this->formatTemplate('icon', [
            'name' => h($name),
            'type' => h($type),
            'class' => h($class),
            'svg' => $svgContent,
            'attrs' => $attrs,
        ]);
    }

    /**
     * Külön segítségként hívható metódusok, ha még rövidebben szeretnéd írni
     */
    public function outline(string $name, array $options = []): string
    {
        $options['type'] = 'outline';
        return $this->render($name, $options);
    }

    public function filled(string $name, array $options = []): string
    {
        $options['type'] = 'filled';
        return $this->render($name, $options);
    }

    /**
     * Beolvassa és letisztítja az SVG tartalmát
     */
    protected function _getSvgContent(string $filePath): ?string
    {
        if (isset($this->_svgCache[$filePath])) {
            return $this->_svgCache[$filePath];
        }

        if (!file_exists($filePath)) {
            return null;
        }

        $content = file_get_contents($filePath);
        if ($content === false) {
            return null;
        }

        // XML fejrész és felesleges kommentek eltávolítása
        $content = preg_replace('/<\?xml.*?\?>/i', '', $content);
        $content = preg_replace('/<!--.*?-->/s', '', $content);

        $this->_svgCache[$filePath] = trim($content);

        return $this->_svgCache[$filePath];
    }
}
