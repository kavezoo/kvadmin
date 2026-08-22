<?php
declare(strict_types=1);

namespace KvAdmin\View\Helper;

use Cake\I18n\DateTime;
use Cake\I18n\I18n;
use Cake\View\Helper;
use NumberFormatter;

/**
 * @property \Cake\View\Helper\FormHelper $Form
 * @property \Cake\View\Helper\HtmlHelper $Html
 * @property \App\View\Helper\IconHelper $Icon
 */
class KvFormHelper extends Helper
{
	protected array $helpers = ['Form', 'Html', 'Icon', 'Url'];

    /**
     * Dátum és időpont választó
     */
    public function dateTimePicker(string $fieldName, array $options = []): string
    {
        return $this->buildPicker(
            $fieldName,
            'flatpickr-datetime',
            'calendar-time',
            'yyyy-MM-dd HH:mm:ss',
            'ÉÉÉÉ.HH.NN ÓÓ:PP',
            $options
        );
    }

    /**
     * Csak dátum választó
     */
    public function datePicker(string $fieldName, array $options = []): string
    {
        return $this->buildPicker(
            $fieldName,
            'flatpickr-date',
            'calendar',
            'yyyy-MM-dd',
            'ÉÉÉÉ.HH.NN',
            $options
        );
    }

    /**
     * Csak idő választó
     */
    public function timePicker(string $fieldName, array $options = []): string
    {
        return $this->buildPicker(
            $fieldName,
            'flatpickr-time',
            'clock',
            'HH:mm:ss',
            'ÓÓ:PP',
            $options
        );
    }

    /**
     * Number Spinner léptető (+ / - gombokkal)
     */
    public function numberSpinner(string $fieldName, array $options = []): string
    {
        $maxWidth = $options['maxWidth'] ?? '200px';
        $label = $options['label'] ?? null;
        unset($options['maxWidth'], $options['label']);

        $defaultOptions = [
            'type' => 'number',
            'label' => false,
            'class' => 'form-control text-center',
            'templates' => [
                'inputContainer' => '{{content}}',
                'inputContainerError' => '{{content}}{{error}}',
            ],
            'min' => 0,
            'max' => 10000,
            'step' => '1',
        ];
        $inputOptions = array_merge($defaultOptions, $options);

        $btnMinus = $this->Form->button(
            $this->Icon->render('minus'),
            [
                'type' => 'button',
                'class' => 'btn btn-outline-secondary btn-icon',
                'data-action' => 'decrement',
                'escapeTitle' => false,
            ]
        );

        $btnPlus = $this->Form->button(
            $this->Icon->render('plus'),
            [
                'type' => 'button',
                'class' => 'btn btn-outline-secondary btn-icon',
                'data-action' => 'increment',
                'escapeTitle' => false,
            ]
        );

        $controlHtml = $this->Form->control($fieldName, $inputOptions);

        $groupHtml = sprintf(
            '<div class="input-group" style="max-width: %s;">%s%s%s</div>',
            h($maxWidth),
            $btnMinus,
            $controlHtml,
            $btnPlus
        );

        if ($label !== false && $label !== null) {
            $labelText = is_array($label) ? ($label['text'] ?? '') : $label;
            $labelClass = is_array($label) ? ($label['class'] ?? 'form-label') : 'form-label';
            $labelHtml = sprintf('<label class="%s">%s</label>', h($labelClass), h($labelText));

            return '<div>' . $labelHtml . $groupHtml . '</div>';
        }

        return $groupHtml;
    }

    /**
     * Tabler Kapcsoló (Switch)
     *
     * Ha nincs explicit `checked` opció, a FormHelper az entity / context
     * értékéből dönt (editnél a mentett érték, addnél az entity default).
     */
    public function switch(string $fieldName, array $options = []): string
    {
        $label = $options['label'] ?? '';
        $size = isset($options['size']) ? ' form-switch-' . $options['size'] : '';
        $hasChecked = array_key_exists('checked', $options);
        $checked = $hasChecked ? (bool)$options['checked'] : null;
        unset($options['label'], $options['size'], $options['checked']);

        $checkboxOptions = array_merge([
            'class' => 'form-check-input',
            'templates' => [
                'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
            ],
        ], $options);

        // Explicit checked csak akkor, ha a hívó kérte — különben entity érték
        if ($hasChecked) {
            $checkboxOptions['checked'] = $checked;
        }

        $checkboxHtml = $this->Form->checkbox($fieldName, $checkboxOptions);

        return sprintf(
            '<label class="form-check form-switch%s mb-0">%s<span class="form-check-label">%s</span></label>',
            h($size),
            $checkboxHtml,
            h((string)$label)
        );
    }

    /**
     * Maszkolt mező
     */
    public function maskedInput(string $fieldName, string $mask, array $options = []): string
    {
        $defaults = [
            'type' => 'text',
            'class' => 'form-control',
            'data-mask' => $mask,
            'data-mask-visible' => 'true',
            'placeholder' => $mask,
            'autocomplete' => 'off',
            'label' => ['class' => 'form-label'],
        ];

        return $this->Form->control($fieldName, array_merge($defaults, $options));
    }

    /**
     * Közös Flatpickr picker felépítő
     */
    protected function buildPicker(
        string $fieldName,
        string $pickerClass,
        string $iconName,
        string $dateFormat,
        string $placeholder,
        array $options
    ): string {
        $entity = $this->Form->getSourceValue($fieldName);
        $formattedValue = null;

        if ($entity instanceof DateTime || $entity instanceof \DateTimeInterface) {
            $formattedValue = $entity->format(str_replace(['yyyy', 'MM', 'dd', 'HH', 'mm', 'ss'], ['Y', 'm', 'd', 'H', 'i', 's'], $dateFormat));
        }

        $defaults = [
            'type' => 'text',
            'class' => 'form-control ' . $pickerClass,
            'placeholder' => $placeholder,
            'autocomplete' => 'off',
            'label' => ['class' => 'form-label'],
            'templates' => [
                'inputContainer' => '<div>{{content}}</div>',
                'formGroup' => '{{label}}<div class="input-icon"><span class="input-icon-addon">'
                    . $this->Icon->outline($iconName)
                    . '</span>{{input}}</div>',
            ],
        ];

        if ($formattedValue !== null && !isset($options['value'])) {
            $defaults['value'] = $formattedValue;
        }

        return $this->Form->control($fieldName, array_merge($defaults, $options));
    }

	/**
     * Mentés submit gomb - Átlátszó alap, hoverkor világoszöld háttér + zöld keret + Tooltip
     *
     * @param string|null $title Gomb felirata (alapértelmezett: 'Save')
     * @param array $options Form->button opciók (pl. 'tooltip' => '...')
     * @return string
     */
    public function saveButton(?string $title = null, array $options = []): string
    {
        $title = $title ?? __('Save');
        $tooltipText = $options['tooltip'] ?? __('Módosítások mentése és az űrlap beküldése');
        unset($options['tooltip']);

        $icon = $this->Icon->outline('device-floppy', ['class' => 'icon btn-icon-adjust']);
        $content = $icon . ' ' . $title;

        $defaultOptions = [
            'type' => 'submit',
            'escapeTitle' => false,
            'class' => 'btn btn-save-action btn-animate-icon d-inline-flex align-items-center gap-2',
            'data-bs-toggle' => 'tooltip',
            'data-bs-placement' => 'top',
            'data-bs-title' => $tooltipText,
        ];

        if (isset($options['class'])) {
            $defaultOptions['class'] .= ' ' . $options['class'];
            unset($options['class']);
        }

        $options = array_merge($defaultOptions, $options);

        return $this->Form->button($content, $options);
    }

    /**
     * Mégse / Vissza gomb - Szürke outline stílus + Tooltip
     *
     * @param string|null $title Gomb felirata (alapértelmezett: 'Cancel')
     * @param array|string|null $url Egyedi URL (alapértelmezett: ['action' => 'index'])
     * @param array $options Html->link opciók (pl. 'tooltip' => '...')
     * @return string
     */
	public function cancelButton(?string $title = null, array|string|null $url = null, array $options = []): string
	{
		$title = $title ?? __('Cancel');
		$url = $url ?? ['action' => 'index'];
		$tooltipText = $options['tooltip'] ?? __('Visszatérés a listához mentés nélkül');
		unset($options['tooltip']);

		$icon = $this->Icon->outline('x', ['class' => 'icon btn-icon-adjust']);
		$content = $icon . ' ' . $title;

		$defaultOptions = [
			'escape' => false,
			'class' => 'btn btn-cancel-action ms-4 d-inline-flex align-items-center gap-2',
			'data-bs-toggle' => 'tooltip',
			'data-bs-placement' => 'top',
			'data-bs-title' => $tooltipText,
		];

		if (isset($options['class'])) {
			$defaultOptions['class'] .= ' ' . $options['class'];
			unset($options['class']);
		}

		$options = array_merge($defaultOptions, $options);

		return $this->Html->link($content, $url, $options);
	}
	
	
/*
	class SearchHelper extends Helper
	{
		protected array $helpers = ['Form'];

		public function inputSearch(string $name = 'search', ?string $value = null, array $options = []): string
		{
			$defaults = [
				'id' => 'advanced-table-search',
				'class' => 'form-control',
				'placeholder' => __('Search...'),
				'value' => $value ?? '',
				'autocomplete' => 'off',
			];

			return $this->Form->text($name, array_merge($defaults, $options));
		}
	}	
*/
	



	/**
     * Kereső input mező generálása
     */
    public function input(string $name = 'search', ?string $value = null, array $options = []): string
    {
        $defaults = [
            'id' => 'advanced-table-search',
            'class' => 'form-control',
            'placeholder' => __('Search...'),
            'value' => $value ?? (string)$this->getView()->getRequest()->getQuery($name, ''),
            'autocomplete' => 'off',
        ];

        return $this->Form->text($name, array_merge($defaults, $options));
    }

    /**
     * Keresés törlése (X) gomb generálása
     */
    public function clearButton(array|string|null $url = null, array $options = []): string
    {
        $url = $url ?? [
            'controller' => $this->getView()->getRequest()->getParam('controller'),
            'action' => 'index',
            '?' => ['clear' => 'search'],
        ];

        $defaultOptions = [
            'escape' => false,
            'id' => 'btn-clear-search',
            'class' => 'btn-search-clear text-muted text-decoration-none',
            'title' => __('Keresés törlése és összes rekord mutatása'),
            'data-bs-toggle' => 'tooltip',
            'data-bs-html' => 'true',
            'data-bs-placement' => 'top',
        ];

        $link = $this->Html->link(
            $this->Icon->outline('x'),
            $url,
            array_merge($defaultOptions, $options)
        );

        return '<span class="input-group-text pe-2 py-0 d-flex align-items-center">' . $link . '</span>';
    }

    /**
     * Gyorsbillentyű (ctrl + K) badge elem
     */
    public function shortcutBadge(string $keyCombo = 'ctrl + K'): string
    {
        return '<span class="input-group-text pe-2" style="border-left-width: 0px; border-left-style: none;">'
            . '<kbd id="search-shortcut-hint" class="search-kbd-badge">' . h($keyCombo) . '</kbd>'
            . '</span>';
    }

    /**
     * Teljes kereső űrlap generálása a rendezési mezőkkel és input-group-pal együtt
     */
    public function search(string $name = 'search', array|string|null $clearUrl = null, array $options = []): string
    {
        $request = $this->getView()->getRequest();
        $searchValue = (string)$request->getQuery($name, '');

        $out = $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query']]);

        // Rendezési paraméterek megtartása (ha vannak)
        $sort = $request->getQuery('sort');
        $direction = $request->getQuery('direction');
        if (!empty($sort)) {
            $out .= $this->Form->hidden('sort', ['value' => $sort]);
            $out .= $this->Form->hidden('direction', ['value' => $direction]);
        }

        // Szülő szerinti szűrő paraméterek megtartása (pl. city_id, club_id)
        foreach ($request->getQueryParams() as $paramKey => $paramValue) {
            if (in_array($paramKey, ['search', 'clear', 'page', 'sort', 'direction'], true)) {
                continue;
            }
            if ($paramValue === null || $paramValue === '') {
                continue;
            }
            $out .= $this->Form->hidden($paramKey, ['value' => $paramValue]);
        }

        // Input group konténer felépítése
        $out .= '<div class="input-group input-group-flat search-input-group w-100 position-relative">';
        
        // Bal oldali kereső ikon
        $out .= '<span class="input-group-text search-box-left-side">' . $this->Icon->outline('search') . '</span>';
        
        // Input mező
        $out .= $this->input($name, $searchValue, $options['input'] ?? []);

        // Jobb oldal: törlés gomb vagy billentyűkombináció jelvény
        if (!empty($searchValue)) {
            $out .= $this->clearButton($clearUrl, $options['clear'] ?? []);
        } else {
            $out .= $this->shortcutBadge($options['shortcut'] ?? 'ctrl + K');
        }

        $out .= '</div>';
        $out .= $this->Form->end();

        return $out;
    }


/**
     * Visszaadja az aktuális locale pénznem adatait
     * 
     * @param string|null $locale Ha null, az I18n::getLocale() értéket használja (pl. 'hu_HU', 'en_US')
     * @return array{symbol: string, position: string, has_space: bool, currency_code: string}
     */
    public function getLocaleCurrencyInfo(?string $locale = null): array
    {
        $locale = $locale ?? I18n::getLocale();
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        $symbol = $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
        $currencyCode = $formatter->getTextAttribute(NumberFormatter::CURRENCY_CODE);
        $pattern = $formatter->getPattern();

        // Pozíció vizsgálata a formátum mintában (¤ jelöli a valutaszimbólum helyét)
        $isPrefix = str_starts_with($pattern, '¤');
        $position = $isPrefix ? 'prefix' : 'postfix';

        // Szóköz vizsgálata a szimbólum és a számjegyek között
        $hasSpace = str_contains($pattern, '¤ ') || str_contains($pattern, ' ¤') ||
                    str_contains($pattern, "¤\u{00A0}") || str_contains($pattern, "\u{00A0}¤");

        return [
            'symbol' => $symbol,
            'position' => $position,
            'has_space' => $hasSpace,
            'currency_code' => $currencyCode,
        ];
    }	
	
	
	
	
/**
     * Megtekintés (View) gomb
     */
    public function actionView(array|string $url, array $options = []): string
    {
        $defaultOptions = [
            'escape' => false,
            'class' => 'btn btn-icon btn-action-default',
            'data-bs-toggle' => 'tooltip',
            'data-bs-placement' => 'top',
            'title' => __('View'),
        ];

        return $this->Html->link(
            $this->Icon->outline('eye'),
            $url,
            array_merge($defaultOptions, $options)
        );
    }

    /**
     * Szerkesztés (Edit) gomb
     */
    public function actionEdit(array|string $url, array $options = []): string
    {
        $defaultOptions = [
            'escape' => false,
            'class' => 'btn btn-icon btn-action-default',
            'data-bs-toggle' => 'tooltip',
            'data-bs-placement' => 'top',
            'title' => __('Edit'),
        ];

        return $this->Html->link(
            $this->Icon->outline('edit'),
            $url,
            array_merge($defaultOptions, $options)
        );
    }

    /**
     * Törlés (Delete) gomb modal indítóval
     */
    public function actionDelete(
        array|string $url,
        string $itemName = '',
        string $targetModal = '#delete-modal',
        array $options = []
    ): string {
        $deleteUrl = is_array($url) ? $this->Url->build($url) : $url;

        $button = sprintf(
            '<button type="button" data-name="%s" data-url="%s" class="%s" data-bs-toggle="modal" data-bs-target="%s">%s</button>',
            h($itemName),
            $deleteUrl,
            $options['class'] ?? 'btn btn-icon btn-action-danger',
            $targetModal,
            $this->Icon->outline('x')
        );

        return sprintf(
            '<span title="%s" data-bs-toggle="tooltip" data-bs-placement="top">%s</span>',
            h(__('Delete')),
            $button
        );
    }

    /**
     * Komplett műveleti gomblista (View + Edit + Delete) TD wrapperrel
     */
	public function actions(
        object $entity,
        string $displayField = 'name',
        array $buttons = ['view', 'edit', 'delete'],
        string $targetModal = '#delete-modal'
    ): string {
        $id = $entity->id ?? null;
        $itemName = (string)($entity->{$displayField} ?? '');

        $html = '<td class="actions">';
        $html .= '<div class="btn-list flex-nowrap align-items-center">';

        if (in_array('view', $buttons)) {
            $html .= $this->actionView(['action' => 'view', $id]);
        }
        if (in_array('edit', $buttons)) {
            $html .= $this->actionEdit(['action' => 'edit', $id]);
        }
        if (in_array('delete', $buttons)) {
            $html .= $this->actionDelete(['action' => 'delete', $id], $itemName, $targetModal);
        }

        $html .= '</div>';
        $html .= '</td>';

        return $html;
    }

    /**
     * Bezárás / vissza a listához (X ikon gomb)
     */
    public function linkCloseIndex(array|string $url = ['action' => 'index'], array $options = []): string
    {
        return $this->Html->link(
            $this->Icon->outline('x'),
            $url,
            array_merge([
                'escape' => false,
                'class' => 'btn btn-icon btn-action-default btn-smooth-rotate',
                'data-bs-toggle' => 'tooltip',
                'title' => __('Vissza a listához'),
            ], $options)
        );
    }

    /**
     * Űrlap tab fül link
     */
    public function linkTab(string $label, string $target, bool $active = false, array $options = []): string
    {
        $defaults = [
            'class' => 'nav-link' . ($active ? ' active' : ''),
            'data-bs-toggle' => 'tab',
            'aria-selected' => $active ? 'true' : 'false',
            'role' => 'tab',
        ];
        if (!$active) {
            $defaults['tabindex'] = '-1';
        }

        return $this->Html->link($label, $target, array_merge($defaults, $options));
    }

    /**
     * Beállítások tab fül (fogaskerék ikon)
     */
    public function linkTabSettings(bool $active = false, array $options = []): string
    {
        $defaults = [
            'escape' => false,
            'class' => 'nav-link' . ($active ? ' active' : ''),
            'data-bs-toggle' => 'tab',
            'title' => __('Settings'),
            'aria-selected' => $active ? 'true' : 'false',
            'role' => 'tab',
        ];
        if (!$active) {
            $defaults['tabindex'] = '-1';
        }

        return $this->Html->link(
            $this->Icon->render('settings', ['class' => 'stroke-thin']),
            '#tabs-settings',
            array_merge($defaults, $options)
        );
    }

    /**
     * Új rekord gomb (index fejléc)
     */
    public function linkAddNew(array|string $url, string $entityLabel, array $options = []): string
    {
        $content = $this->Icon->outline('plus')
            . '<span class="d-none d-sm-inline ms-1">'
            . __('Add new') . ' ' . h($entityLabel)
            . '</span>';

        return $this->Html->link(
            $content,
            $url,
            array_merge([
                'escape' => false,
                'class' => 'btn btn-outline-secondary btn-header-new',
            ], $options)
        );
    }

    /**
     * Szülő rekord megtekintése (szűrt gyereklista sáv)
     */
    public function linkParentView(array $parentContext, array $options = []): string
    {
        return $this->Html->link(
            __('Szülő megtekintése'),
            [
                'controller' => $parentContext['controller'],
                'action' => 'view',
                $parentContext['foreignKeyValue'],
            ],
            array_merge(['class' => 'ms-auto btn btn-sm btn-outline-secondary'], $options)
        );
    }

    /**
     * Teljes lista (szűrés törlése)
     */
    public function linkFullList(array $options = []): string
    {
        return $this->Html->link(
            __('Teljes lista'),
            ['action' => 'index', '?' => ['clear' => 'filter']],
            array_merge(['class' => 'btn btn-sm btn-outline-secondary'], $options)
        );
    }

    /**
     * BelongsTo kapcsolat link az index táblázatban (tooltip + link ikon)
     */
    public function linkBelongsToCell(
        object $owner,
        string $associationProperty,
        string $displayField,
        string $controller,
        string $primaryKey = 'id'
    ): string {
        if (!$owner->hasValue($associationProperty)) {
            return '';
        }

        $related = $owner->{$associationProperty};
        $label = h((string)($related->{$displayField} ?? ''));
        $content = $label . '<span class="icon-link-subtle ms-1">' . $this->Icon->outline('link') . '</span>';

        return $this->Html->link(
            $content,
            ['controller' => $controller, 'action' => 'view', $related->{$primaryKey}],
            [
                'class' => 'text-reset text-decoration-none fw-bold',
                'escape' => false,
                'data-bs-toggle' => 'tooltip',
                'data-bs-html' => 'true',
                'data-bs-placement' => 'top',
                'title' => '<b>' . $label . '</b><br>' . __('adatlap megtekintése'),
            ]
        );
    }

    /**
     * Kapcsolt rekord link a view táblázatban
     */
    public function linkRelatedRecord(
        object $owner,
        string $associationProperty,
        string $displayField,
        string $controller,
        string $primaryKey = 'id'
    ): string {
        if (!$owner->hasValue($associationProperty)) {
            return '';
        }

        $related = $owner->{$associationProperty};

        return $this->Html->link(
            h((string)($related->{$displayField} ?? '')),
            ['controller' => $controller, 'action' => 'view', $related->{$primaryKey}],
            ['class' => 'text-reset text-decoration-none fw-bold']
        );
    }

    /**
     * Gyerek lista gomb (HasMany – index Related oszlop)
     */
    public function linkChildList(
        string $controller,
        string $foreignKey,
        int|string $foreignKeyValue,
        string $parentFilter,
        string $title,
        array $options = []
    ): string {
        return $this->Html->link(
            $this->Icon->outline('list'),
            [
                'controller' => $controller,
                'action' => 'index',
                '?' => [
                    $foreignKey => $foreignKeyValue,
                    'parent_filter' => $parentFilter,
                ],
            ],
            array_merge([
                'escape' => false,
                'class' => 'btn btn-icon btn-action-default',
                'data-bs-toggle' => 'tooltip',
                'data-bs-placement' => 'top',
                'title' => $title,
            ], $options)
        );
    }
	
}