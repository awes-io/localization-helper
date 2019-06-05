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
        if (gettype(__($key)) === 'array') {
            return $key;
        }

        $fallbackLocale = $this->translator->getFallback();

        if ($this->canBeUpdated($default, $key, $fallbackLocale)) {

            $path = explode('.', $key);

            $filename = $path[0];

            if (! isset($path[1])) return __($key, $placeholders);

            $this->translator->addLines([$key => $default], $fallbackLocale);

            $this->writeToLangFile(
                $fallbackLocale, 
                $this->translator->get($filename),
                $filename
            );

        }
        return __($key, $placeholders);
    }

    private function canBeUpdated($default, $key, $fallbackLocale)
    {
        $parsedKey = $this->translator->parseKey($key);

        [$namespace, $path, $item] = $parsedKey;

        $items = array_filter(explode('.', $item));

        foreach ($items as $item) {
            $path .= '.' . $item;
            if ($this->translator->has($path) && gettype($this->translator->get($path)) === 'string') {
                return false;
            }
        }

        return $default && config('app.debug')
            && !$this->translator->hasForLocale($key, $fallbackLocale);
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
        $header = "<?php\n\nreturn ";

        $language_file = $this->basePath . "/{$locale}/{$filename}.php";

        try {
            if (($fp = fopen($language_file, 'w')) !== FALSE) {
            
                fputs($fp, $header . $this->var_export54($translations) . ";\n");
                
                fclose($fp);
    
                return true;
            }
        } catch (\Exception $e) {
            return false;}}

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
