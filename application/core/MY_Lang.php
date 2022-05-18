<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Language in URL for CodeIgniter.
 *
 * @author		Walid Aqleh <waleedakleh23@hotmail.com>
 * @version		1.1.2
 * @based on	        Internationalization (i18n) library for CodeIgniter 2 by Jerome Jaglale (http://jeromejaglale.com/doc/php/codeigniter_i18n)
 * @link https://github.com/waqleh/CodeIgniter-Language-In-URL-Internationalization-
 */
class MY_Lang extends CI_Lang {
    /**
     * configuration (you can move these into a config file or get it from a database)
     */

    /**
     * languages
     * default language is the first element
     *
     * @var array
     */
    public $languages = [
        'en' => 'english',
        'hi' => 'hindi',
        //'ar' => 'arabic',
        //'ku' => 'kurdish'
    ];

    /**
     * special URIs (not localized)
     *
     * @var array
     */
    public $special = [
        "admin",
        "auth",
        "backoffice",
    ];

    /**
     * where to redirect if no language in URI
     *
     * @var string
     */
    public $default_uri = '';

    /**
     * default lang file that will be created if it doesn't exist
     * and will be used to automatically add any missing strings
     */
    public $default_lang_file = 'message_lang.php';

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * If URI without language then Add language current URI and redirect
     * If URI is special don't add language to URI
     *
     * @return	void
     */
    /*function __construct() {
        parent::__construct();

        global $CFG;
        global $URI;

        if($CFG->item('default_lang_file')){
            $this->default_lang_file = $CFG->item('default_lang_file');
        }

        $segment = $URI->segment(1);

        if (!strlen($this->default_uri)) {
            $this->default_uri = $URI->uri_string();
        }

        if (isset($this->languages[$segment])) { // URI with language -> ok
            $language = $this->languages[$segment];
            $CFG->set_item('language', $language);
        } else if ($this->is_special($segment)) { // special URI -> no redirect
            return;
        } else { // URI without language -> redirect to default_uri
            // set default language
            $CFG->set_item('language', $this->languages[$this->default_lang()]);

            // redirect
            header("Location: " . $CFG->site_url($this->localized($this->default_uri)), TRUE, 301);
            exit;
        }
    }*/

    /**
     * Returns the current language
     *
     * @return  string ex: return 'en' if language in CI config is 'english'
     */
    function lang() {
        global $CFG;
        $language = $CFG->item('language');

        $lang = array_search($language, $this->languages);
        if ($lang) {
            return $lang;
        }

        return NULL; // this should not happen
    }

    /**
     * Check if URI is special URIs (not localized)
     *
     * @param   string  $uri    URI
     * @return  boolean TRUE if special Or FALSE if not
     */
    function is_special($uri) {
        $exploded = explode('/', $uri);
        if (in_array($exploded[0], $this->special)) {
            return TRUE;
        }
        if (isset($this->languages[$uri])) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Switch to another language
     *
     * @param   string  $lang    Language key
     * @return  string URI
     */
    function switch_uri($lang) {
        $CI = & get_instance();

        $uri = $CI->uri->uri_string();
        $exploded = explode('/', $uri);
        if ($exploded[0] == $this->lang() || !strlen($exploded[0])) {
            $exploded[0] = $lang;
        }
        $uri = implode('/', $exploded);
        return $uri;
    }

    /**
     * Check if there is a language segment in this $uri?
     *
     * @param   string  $uri    URI
     * @return  boolean TRUE on success or FALSE on failure
     */
    function has_language($uri) {
        $first_segment = NULL;

        $exploded = explode('/', $uri);
        if (isset($exploded[0])) {
            if ($exploded[0] != '') {
                $first_segment = $exploded[0];
            } else if (isset($exploded[1]) && $exploded[1] != '') {
                $first_segment = $exploded[1];
            }
        }

        if ($first_segment != NULL) {
            return isset($this->languages[$first_segment]);
        }

        return FALSE;
    }

    /**
     * return default language: first element of $this->languages
     *
     * @return  string Key of first element in $this->languages
     */
    function default_lang() {
        foreach ($this->languages as $lang => $language) {
            return $lang;
        }
    }

    /**
     * add language segment to $uri (if appropriate)
     *
     * @param   string  $uri URI
     * @return  string  URI
     */
    function localized($uri) {
        if ($this->has_language($uri) || $this->is_special($uri) || preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $uri)) {
            // we don't need a language segment because:
            // - there's already one or
            // - it's a special uri (set in $special) or
            // - that's a link to a file
        } else {
            $uri = $this->lang() . (0 !== strpos($uri, '/') ? '/' : '') . $uri;
        }

        return $uri;
    }

    /**
     * return translation of line (key). If line is not available add it to a general language file
     *
     * @param   string  $line       URI
     * @param   boolean $log_errors Optional parameters to stop logging not found lines ### UNUSED ###
     * @return  string
     */
    function line($line = '', $log_errors = TRUE) {
        $value = ($line == '' OR ! isset($this->language[$line])) ? FALSE : $this->language[$line];
        if ($value === FALSE) {
            $file = APPPATH . 'language' . DIRECTORY_SEPARATOR . $this->languages[$this->lang()] . DIRECTORY_SEPARATOR . $this->default_lang_file;
            if (($found = file_exists($file)) === FALSE) {
                $this->create_lang_file($file);
            }
            //$this->add_to_lang_file($file, $line);
            return $line;
        }
        return $value;
    }

    /**
     * create a language file
     *
     * @param   string  $file   path of language file
     */
    function create_lang_file($file) {
        try {
            file_put_contents($file, "<?php
          defined('BASEPATH') OR exit('No direct script access allowed');
          \$lang = array();" . PHP_EOL);
        } catch (Exception $exc) {
            log_message('error', 'Could not create lang file: "' . $file . '"');
        }
    }

    /**
     * add line to language file array
     *
     * @param   string  $file   path of language file
     * @param   string  $line   line (key) to add to file
     */
    function add_to_lang_file($file, $line) {
        try {
            $file_contents = file_get_contents($file);
            $pattern = '~\$lang\[(\'|")' . preg_quote($line) . '(\'|")\]~';
            if (!preg_match($pattern, $file_contents)) {
                $data = '$lang[\'' . addcslashes($line, '\'') . '\'] = "' . addcslashes($line, '"') . '";';
                file_put_contents($file, PHP_EOL . $data, FILE_APPEND);
            }
            $file_contents = trim(file_get_contents($file));
            $pattern = '/<\?php/';
            if (!preg_match($pattern, $file_contents)) {
                $content = '<?php ' . $file_contents;
                file_put_contents($file, $content);
            }
        } catch (Exception $exc) {
            log_message('error', 'Could not edit lang file: "' . $file . '"');
        }
    }

    /**
     * Load a language file
     *
     * @param	mixed	$langfile	Language file name
     * @param	string	$idiom		Language name (english, etc.)
     * @param	bool	$return		Whether to return the loaded array of translations
     * @param 	bool	$add_suffix	Whether to add suffix to $langfile
     * @param 	string	$alt_path	Alternative path to look for the language file
     *
     * @return	void|string[]	Array containing translations, if $return is set to TRUE
     */
    public function load($langfile, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '') {
        if (is_array($langfile)) {
            foreach ($langfile as $value) {
                $this->load($value, $idiom, $return, $add_suffix, $alt_path);
            }

            return;
        }

        $langfile = str_replace('.php', '', $langfile);

        if ($add_suffix === TRUE) {
            $langfile = preg_replace('/_lang$/', '', $langfile) . '_lang';
        }

        $langfile .= '.php';

        if (empty($idiom) OR ! preg_match('/^[a-z_-]+$/i', $idiom)) {
            $config = & get_config();
            $idiom = empty($config['language']) ? 'english' : $config['language'];
        }

        if ($return === FALSE && isset($this->is_loaded[$langfile]) && $this->is_loaded[$langfile] === $idiom) {
            return;
        }

        // Load the base file, so any others found can override it
        $basepath = BASEPATH . 'language' . DIRECTORY_SEPARATOR . $idiom . DIRECTORY_SEPARATOR . $langfile;
        if (($found = file_exists($basepath)) === TRUE) {
            include($basepath);
        }

        // Do we have an alternative path to look in?
        if ($alt_path !== '') {
            $alt_path .= 'language' . DIRECTORY_SEPARATOR . $idiom . DIRECTORY_SEPARATOR . $langfile;
            if (file_exists($alt_path)) {
                include($alt_path);
                $found = TRUE;
            }
        } else {
            foreach (get_instance()->load->get_package_paths(TRUE) as $package_path) {
                $package_path .= 'language' . DIRECTORY_SEPARATOR . $idiom . DIRECTORY_SEPARATOR . $langfile;
                if ($basepath !== $package_path && file_exists($package_path)) {
                    include($package_path);
                    $found = TRUE;
                    break;
                }
            }
        }
        if ($found !== TRUE) {
            log_message('error', 'Unable to load the requested language file: language' . DIRECTORY_SEPARATOR . $idiom . DIRECTORY_SEPARATOR . $langfile);
            $file = APPPATH . 'language' . DIRECTORY_SEPARATOR . $this->languages[$this->lang()] . DIRECTORY_SEPARATOR . $this->default_lang_file;
            //$this->create_lang_file($file);
            require($file);
        }

        if (!isset($lang) OR ! is_array($lang)) {
            log_message('error', 'Language file contains no data: language' . DIRECTORY_SEPARATOR . $idiom . DIRECTORY_SEPARATOR . $langfile);

            if ($return === TRUE) {
                return array();
            }
            return;
        }

        if ($return === TRUE) {
            return $lang;
        }

        $this->is_loaded[$langfile] = $idiom;
        $this->language = array_merge($this->language, $lang);

        log_message('info', 'Language file loaded: language' . DIRECTORY_SEPARATOR . $idiom . DIRECTORY_SEPARATOR . $langfile);
        return TRUE;
    }

    /**
     * return languages array
     *
     * @return  array
     */
    public function get_lang() {
        return $this->languages;
    }

}
