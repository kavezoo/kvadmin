<?php
declare(strict_types=1);

namespace KvAdmin\Model\Behavior;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\I18n\I18n;
use Cake\ORM\Behavior;
use Cake\ORM\Table;
use DateTime;
use IntlDateFormatter;
use NumberFormatter;

class LocalizedDataBehavior extends Behavior
{
    protected array $_defaultConfig = [
        'locale' => null, // null esetén a CakePHP aktuális nyelvi beállítását használja (I18n::getLocale())
        'autoDetectTypes' => true, // Automatikusan felismeri a tábla sémájából a típusokat
    ];

    /**
     * Az adatok entitásba töltése (marshalling) előtt fut le
     */
    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options): void
    {
        $locale = $this->getConfig('locale') ?? I18n::getLocale();
        $schema = $this->_table->getSchema();
		//debug($data);
		//debug($schema);
		//dd($locale);

        foreach ($data as $field => $value) {
            // Csak kitöltött string értékeket vizsgálunk
            if (!is_string($value) || trim($value) === '') {
                continue;
            }

            $value = trim($value);
            $columnType = $schema->getColumnType((string)$field);

            // Ha nincs ilyen mező az adatbázisban, átugorjuk
            if ($columnType === null) {
                continue;
            }

            // 1. Dátum és Idő típusok normalizálása
            if (in_array($columnType, ['date', 'datetime', 'timestamp', 'datetimefractional'], true)) {
                $data[$field] = $this->normalizeDate($value, $columnType, $locale);
            }

            // 2. Szám típusok normalizálása (decimal, float, integer)
            if (in_array($columnType, ['decimal', 'float', 'integer', 'biginteger', 'smallinteger'], true)) {
                $data[$field] = $this->normalizeNumber($value, $locale);
            }
        }
    }

    /**
     * Lokalizált dátumok konvertálása SQL formátumba (Y-m-d vagy Y-m-d H:i:s)
     */
    protected function normalizeDate(string $value, string $type, string $locale): string
    {
        // Ha már standard ISO formátumban van (pl. HTML5 inputok küldik: 2026-04-15), békén hagyjuk
        if (preg_match('/^\d{4}-\d{2}-\d{2}( \d{2}:\d{2}(:\d{2})?)?$/', $value)) {
            return $value;
        }

        // 1. Próbálkozás a PHP IntlDateFormatter-rel az adott locale szerint
        $formatters = [
            new IntlDateFormatter($locale, IntlDateFormatter::SHORT, IntlDateFormatter::SHORT),
            new IntlDateFormatter($locale, IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM),
            new IntlDateFormatter($locale, IntlDateFormatter::SHORT, IntlDateFormatter::NONE),
            new IntlDateFormatter($locale, IntlDateFormatter::MEDIUM, IntlDateFormatter::NONE),
            new IntlDateFormatter($locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE),
        ];

        foreach ($formatters as $formatter) {
            $formatter->setLenient(false);
            $timestamp = $formatter->parse($value);
            if ($timestamp !== false) {
                return $type === 'date' 
                    ? date('Y-m-d', $timestamp) 
                    : date('Y-m-d H:i:s', $timestamp);
            }
        }

        // 2. Fallback: gyakori magyar és európai pontozott/perjeles formátumok
        $customFormats = [
            'Y.m.d. H:i:s' => 'Y-m-d H:i:s',
            'Y.m.d H:i:s'  => 'Y-m-d H:i:s',
            'Y.m.d.'       => 'Y-m-d',
            'Y. m. d.'     => 'Y-m-d',
            'Y.m.d'        => 'Y-m-d',
            'd/m/Y'        => 'Y-m-d',
            'd.m.Y'        => 'Y-m-d',
            'd-m-Y'        => 'Y-m-d',
            'd/m/Y H:i'    => 'Y-m-d H:i:00',
            'd.m.Y H:i'    => 'Y-m-d H:i:00',
        ];

        foreach ($customFormats as $format => $targetFormat) {
            $d = DateTime::createFromFormat($format, $value);
            if ($d && $d->format($format) === $value) {
                return $type === 'date' ? $d->format('Y-m-d') : $d->format($targetFormat);
            }
        }

        return $value;
    }

    /**
     * Lokalizált számok tisztítása (ezres tagolók törlése, tizedesvessző pontra cserélése)
     */
    protected function normalizeNumber(string $value, string $locale): string
    {
        $formatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
        $decSep = $formatter->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL); // pl. hu/de esetén: ","
        $groupSep = $formatter->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL); // pl. hu esetén: szóköz/NBSP, de: "."

        // Nem-törő szóközök (NBSP) és sima szóközök eltávolítása
        $clean = str_replace(["\xc2\xa0", "\u{00A0}", ' '], '', $value);

        // Csoportosító / ezres elválasztó eltávolítása (ha van)
        if ($groupSep !== '') {
            $clean = str_replace($groupSep, '', $clean);
        }

        // Tizedes elválasztó átalakítása standard ponttá (.)
        if ($decSep !== '' && $decSep !== '.') {
            $clean = str_replace($decSep, '.', $clean);
        }

        // Ha a tisztítás után érvényes számot kaptunk, visszaadjuk az SQL-kompatibilis formát
        if (is_numeric($clean)) {
            return $clean;
        }

        return $value;
    }
}
