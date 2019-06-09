<?php

namespace AwesIO\LocalizationHelper;

use AwesIO\LocalizationHelper\Contracts\LocalizationHelper as LocalizationHelperContract;

class LocalizationHelper implements LocalizationHelperContract
{
    protected $basePath;

    protected $translator;

    /**
     * LocalizationHelper constructor.
     * @param $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;

        $this->translator = app('translator');
    }

    /**
     * Translate the given message
     *
     * @param $key
     * @param $default
     * @param $placeholders
     * @return array|null|string
     */
    public function trans($key, $default = null, $placeholders = [])
    {
        $translation = __($key, $placeholders);
        if (is_array($translation)) {
            return $key;
        }
        if (config('app.debug')) {
            if (!is_array($default)) {
                $default = [$this->translator->getFallback() => $default];
            }
            foreach ($default as $locale => $item) {
                $this->updateTranslation($key, $item, $locale);
            }
            $translation = __($key, $placeholders);
        }

        return $translation;
    }

    private function updateTranslation($key, $default, $locale)
    {
        $path = explode('.', $key);
        if ($this->canBeUpdated($default, $key, $locale) && !empty($path[1])) {
            $this->translator->addLines([$key => $default], $locale);
            $this->writeToLangFile(
                $locale,
                $this->translator->get($path[0]),
                $path[0]
            );

        }
    }

    private function canBeUpdated($default, $key, $locale)
    {
        if (!$default || $this->translator->hasForLocale($key, $locale)) {
            return false;
        }
        $parsedKey = $this->translator->parseKey($key);
        [$namespace, $path, $item] = $parsedKey;
        $items = array_filter(explode('.', $item));
        foreach ($items as $item) {
            $path .= '.' . $item;
            if ($this->translator->hasForLocale($path, $locale)
                && is_string($this->translator->get($path, [], $locale))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Write to language file
     *
     * @param $locale
     * @param $translations
     * @return bool
     */
    private function writeToLangFile($locale, $translations, $filename)
    {
        $file = $this->basePath . "/{$locale}/{$filename}.php";
        try {
            if (($fp = fopen($file, 'w')) !== FALSE) {
                $header = "<?php\n\nreturn ";
                fputs($fp, $header . $this->var_export54($translations) . ";\n");
                fclose($fp);

                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * var_export to php5.4 array syntax
     * https://stackoverflow.com/questions/24316347/how-to-format-var-export-to-php5-4-array-syntax
     *
     * @param $var
     * @param string $indent
     * @return mixed|string
     */
    private function var_export54($var, $indent = "")
    {
        switch (gettype($var)) {
            case "string":
                return '"' . addcslashes($var, "\\\$\"\r\n\t\v\f") . '"';
            case "array":
                $indexed = array_keys($var) === range(0, count($var) - 1);
                $r = [];
                foreach ($var as $key => $value) {
                    $r[] = "$indent    "
                        . ($indexed ? "" : $this->var_export54($key) . " => ")
                        . $this->var_export54($value, "$indent    ");
                }
                return "[\n" . implode(",\n", $r) . "\n" . $indent . "]";
            case "boolean":
                return $var ? "TRUE" : "FALSE";
            default:
                return var_export($var, TRUE);
        }
    }
}
