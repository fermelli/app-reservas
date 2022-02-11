<?php

/**
 * Project:  Securimage: A PHP class dealing with CAPTCHA images, audio, and validation
 * File:     securimage.php
 *
 * Copyright (c) 2018, Drew Phillips
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *  - Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Any modifications to the library should be indicated clearly in the source code
 * to inform users that the changes are not a part of the original software.
 *
 * @link https://www.phpcaptcha.org Securimage Homepage
 * @link https://www.phpcaptcha.org/latest.zip Download Latest Version
 * @link https://github.com/dapphp/securimage GitHub page
 * @link https://www.phpcaptcha.org/Securimage_Docs/ Online Documentation
 * @copyright 2018 Drew Phillips
 * @author Drew Phillips <drew@drew-phillips.com>
 * @version 3.6.8 (May 2020)
 * @package Securimage
 *
 */

class Securimage
{
    // All of the public variables below are securimage options
    // They can be passed as an array to the Securimage constructor, set below,
    // or set from securimage_show.php and securimage_play.php

    /**
     * Constant for rendering captcha as a JPEG image
     * @var int
     */
    const SI_IMAGE_JPEG = 1;

    /**
     * Constant for rendering captcha as a PNG image (default)
     * @var int
     */

    const SI_IMAGE_PNG  = 2;
    /**
     * Constant for rendering captcha as a GIF image
     * @var int
     */
    const SI_IMAGE_GIF  = 3;

    /**
     * Constant for generating a normal alphanumeric captcha based on the
     * character set
     *
     * @see Securimage::$charset charset property
     * @var int
     */
    const SI_CAPTCHA_STRING     = 0;

    /**
     * Constant for generating a captcha consisting of a simple math problem
     *
     * @var int
     */
    const SI_CAPTCHA_MATHEMATIC = 1;

    /**
     * Constant for generating a word based captcha using 2 words from a list
     *
     * @var int
     */
    const SI_CAPTCHA_WORDS      = 2;

    /*%*********************************************************************%*/
    // Properties

    /**
     * The width of the captcha image
     * @var int
     */
    public $image_width = 215;

    /**
     * The height of the captcha image
     * @var int
     */
    public $image_height = 80;

    /**
     * Font size is calculated by image height and this ratio.  Leave blank for
     * default ratio of 0.4.
     *
     * Valid range: 0.1 - 0.99.
     *
     * Depending on image_width, values > 0.6 are probably too large and
     * values < 0.3 are too small.
     *
     * @var float
     */
    public $font_ratio;

    /**
     * The type of the image, default = png
     *
     * @see Securimage::SI_IMAGE_PNG SI_IMAGE_PNG
     * @see Securimage::SI_IMAGE_JPEG SI_IMAGE_JPEG
     * @see Securimage::SI_IMAGE_GIF SI_IMAGE_GIF
     * @var int
     */
    public $image_type   = self::SI_IMAGE_PNG;

    /**
     * The background color of the captcha
     * @var Securimage_Color|string
     */
    public $image_bg_color = '#ffffff';

    /**
     * The color of the captcha text
     * @var Securimage_Color|string
     */
    public $text_color     = '#707070';

    /**
     * The color of the lines over the captcha
     * @var Securimage_Color|string
     */
    public $line_color     = '#707070';

    /**
     * The color of the noise that is drawn
     * @var Securimage_Color|string
     */
    public $noise_color    = '#707070';

    /**
     * How transparent to make the text.
     *
     * 0 = completely opaque, 100 = invisible
     *
     * @var int
     */
    public $text_transparency_percentage = 20;

    /**
     * Whether or not to draw the text transparently.
     *
     * true = use transparency, false = no transparency
     *
     * @var bool
     */
    public $use_transparent_text         = true;

    /**
     * The length of the captcha code
     * @var int
     */
    public $code_length    = 6;

    /**
     * Display random spaces in the captcha text on the image
     *
     * @var bool true to insert random spacing between groups of letters
     */
    public $use_random_spaces  = false;

    /**
     * Draw each character at an angle with random starting angle and increase/decrease per character
     * @var bool true to use random angles, false to draw each character normally
     */
    public $use_text_angles = false;

    /**
     * Instead of centering text vertically in the image, the baseline of each character is
     * randomized in such a way that the next character is drawn slightly higher or lower than
     * the previous in a step-like fashion.
     *
     * @var bool true to use random baselines, false to center text in image
     */
    public $use_random_baseline = false;

    /**
     * Draw a bounding box around some characters at random.  20% of the time, random boxes
     * may be drawn around 0 or more characters on the image.
     *
     * @var bool  true to randomly draw boxes around letters, false not to
     */
    public $use_random_boxes = false;

    /**
     * Whether the captcha should be case sensitive or not.
     *
     * Not recommended, use only for maximum protection.
     *
     * @var bool
     */
    public $case_sensitive = false;

    /**
     * The character set to use for generating the captcha code
     * @var string
     */
    public $charset        = 'abcdefghijkmnopqrstuvwxzyABCDEFGHJKLMNPQRSTUVWXZY0123456789';

    /**
     * How long in seconds a captcha remains valid, after this time it will be
     * considered incorrect.
     *
     * @var int
     */
    public $expiry_time    = 900;

    /**
     * The session name securimage should use.
     *
     * Only use if your application uses a custom session name (e.g. Joomla).
     * It is recommended to set this value here so it is used by all securimage
     * scripts (i.e. securimage_show.php)
     *
     * @var string
     */
    public $session_name   = null;

    /**
     * true to use the wordlist file, false to generate random captcha codes
     * @var bool
     */
    public $use_wordlist   = false;

    /**
     * The level of distortion.
     *
     * 0.75 = normal, 1.0 = very high distortion
     *
     * @var double
     */
    public $perturbation = 0.85;

    /**
     * How many lines to draw over the captcha code to increase security
     * @var int
     */
    public $num_lines    = 5;

    /**
     * The level of noise (random dots) to place on the image, 0-10
     * @var int
     */
    public $noise_level  = 2;

    /**
     * The signature text to draw on the bottom corner of the image
     * @var string
     */
    public $image_signature = '';

    /**
     * The color of the signature text
     * @var Securimage_Color|string
     */
    public $signature_color = '#707070';

    /**
     * The path to the ttf font file to use for the signature text.
     * Defaults to $ttf_file (AHGBold.ttf)
     *
     * @see Securimage::$ttf_file
     * @var string
     */
    public $signature_font;

    /**
     * Use a database backend for code storage.
     * Provides a fallback to users with cookies disabled.
     * Required when using captcha IDs.
     *
     * @see Securimage::$database_driver
     * @var bool
     */
    public $use_database = false;

    /**
     * The type of captcha to create.
     *
     * Either alphanumeric based on *charset*, a simple math problem, or an
     * image consisting of 2 words from the word list.
     *
     * @see Securimage::SI_CAPTCHA_STRING SI_CAPTCHA_STRING
     * @see Securimage::SI_CAPTCHA_MATHEMATIC SI_CAPTCHA_MATHEMATIC
     * @see Securimage::SI_CAPTCHA_WORDS SI_CAPTCHA_WORDS
     * @see Securimage::$charset charset property
     * @see Securimage::$wordlist_file wordlist_file property
     * @var int
     */
    public $captcha_type  = self::SI_CAPTCHA_STRING; // or self::SI_CAPTCHA_MATHEMATIC, or self::SI_CAPTCHA_WORDS;

    /**
     * The captcha namespace used for having multiple captchas on a page or
     * to separate captchas from differen forms on your site.
     * Example:
     *
     *     <?php
     *     // use <img src="securimage_show.php?namespace=contact_form">
     *     // or manually in securimage_show.php
     *     $img->setNamespace('contact_form');
     *
     *     // in form validator
     *     $img->setNamespace('contact_form');
     *     if ($img->check($code) == true) {
     *         echo "Valid!";
     *     }
     *
     * @var string
     */
    public $namespace;

    /**
     * The TTF font file to use to draw the captcha code.
     *
     * Leave blank for default font AHGBold.ttf
     *
     * @var string
     */
    public $ttf_file;

    /**
     * The path to the wordlist file to use.
     *
     * Leave blank for default words/words.txt
     *
     * @var string
     */
    public $wordlist_file;

    /**
     * Character encoding of the wordlist file.
     * Requires PHP Multibyte String (mbstring) support.
     * Allows word list to contain characters other than US-ASCII (requires compatible TTF font).
     *
     * @var string The character encoding (e.g. UTF-8, UTF-7, EUC-JP, GB2312)
     * @see http://php.net/manual/en/mbstring.supported-encodings.php
     * @since 3.6.3
     */
    public $wordlist_file_encoding = null;

    /**
     * The directory to scan for background images, if set a random background
     * will be chosen from this folder
     *
     * @var string
     */
    public $background_directory;

    /**
     * The name of the log file for logging audio errors
     *
     * @var string|null (defualt si_error.log)
     */
    public $log_file = null;

    /**
     * Captcha ID if using static captcha
     * @var string Unique captcha id
     */
    protected static $_captchaId = null;

    /**
     * The GD image resource of the captcha image
     *
     * @var resource|GdImage
     */
    protected $im;

    /**
     * A temporary GD image resource of the captcha image for distortion
     *
     * @var resource|GdImage
     */
    protected $tmpimg;

    /**
     * The background image GD resource
     * @var string
     */
    protected $bgimg;

    /**
     * Scale factor for magnification of distorted captcha image
     *
     * @var int
     */
    protected $iscale = 2;

    /**
     * Absolute path to securimage directory.
     *
     * This is calculated at runtime
     *
     * @var string
     */
    public $securimage_path = null;

    /**
     * The captcha challenge value.
     *
     * Either the case-sensitive/insensitive word captcha, or the solution to
     * the math captcha.
     *
     * @var string|bool Captcha challenge value
     */
    protected $code;

    /**
     * The display value of the captcha to draw on the image
     *
     * Either the word captcha or the math equation to present to the user
     *
     * @var string Captcha display value to draw on the image
     */
    protected $code_display;

    /**
     * Alternate text to draw as the captcha image text
     *
     * A value that can be passed to the constructor that can be used to
     * generate a captcha image with a given value.
     *
     * This value does not get stored in the session or database and is only
     * used when calling Securimage::show().
     *
     * If a display_value was passed to the constructor and the captcha image
     * is generated, the display_value will be used as the string to draw on
     * the captcha image.
     *
     * Used only if captcha codes are generated and managed by a 3rd party
     * app/library
     *
     * @var string Captcha code value to display on the image
     */
    public $display_value;

    /**
     * Captcha code supplied by user [set from Securimage::check()]
     *
     * @var string
     */
    protected $captcha_code;

    /**
     * Time (in seconds) that the captcha was solved in (correctly or incorrectly).
     *
     * This is from the time of code creation, to when validation was attempted.
     *
     * @var int
     */
    protected $_timeToSolve = 0;

    /**
     * Flag that can be specified telling securimage not to call exit after
     * generating a captcha image or audio file
     *
     * @var bool If true, script will not terminate; if false script will terminate (default)
     */
    protected $no_exit;

    /**
     * Flag indicating whether or not a PHP session should be started and used
     *
     * @var bool If true, no session will be started; if false, session will be started and used to store data (default)
     */
    protected $no_session;

    /**
     * Flag indicating whether or not HTTP headers will be sent when outputting
     * captcha image/audio
     *
     * @var bool If true (default) headers will be sent, if false, no headers are sent
     */
    protected $send_headers;

    /**
     * The GD color for the background color
     *
     * @var int
     */
    protected $gdbgcolor;

    /**
     * The GD color for the text color
     *
     * @var int
     */
    protected $gdtextcolor;

    /**
     * The GD color for the line color
     *
     * @var int
     */
    protected $gdlinecolor;

    /**
     * The GD color for the signature text color
     *
     * @var int
     */
    protected $gdsignaturecolor;

    /**
     * Create a new securimage object, pass options to set in the constructor.
     *
     * The object can then be used to display a captcha, play an audible captcha, or validate a submission.
     *
     * @param array $options  Options to initialize the class.  May be any class property.
     *
     *     $options = array(
     *         'text_color' => new Securimage_Color('#013020'),
     *         'code_length' => 5,
     *         'num_lines' => 5,
     *         'noise_level' => 3,
     *         'font_file' => Securimage::getPath() . '/custom.ttf'
     *     );
     *
     *     $img = new Securimage($options);
     *
     */
    public function __construct($options = array())
    {
        $this->securimage_path = dirname(__FILE__);

        if (!is_array($options)) {
            trigger_error(
                '$options passed to Securimage::__construct() must be an array.  ' .
                    gettype($options) . ' given',
                E_USER_WARNING
            );
            $options = array();
        }

        if (function_exists('mb_internal_encoding')) {
            mb_internal_encoding('UTF-8');
        }

        // check for and load settings from custom config file
        $config_file = null;

        if (file_exists(dirname(__FILE__) . '/config.inc.php')) {
            $config_file = dirname(__FILE__) . '/config.inc.php';
        }
        if (isset($options['config_file']) && file_exists($options['config_file'])) {
            $config_file = $options['config_file'];
        }

        if ($config_file) {
            $settings = include $config_file;

            if (is_array($settings)) {
                $options = array_merge($settings, $options);
            }
        }

        if (is_array($options) && sizeof($options) > 0) {
            foreach ($options as $prop => $val) {
                if ($prop == 'captchaId') {
                    Securimage::$_captchaId = $val;
                    $this->use_database     = true;
                } else if ($prop == 'use_sqlite_db') {
                    trigger_error("The use_sqlite_db option is deprecated, use 'use_database' instead", E_USER_NOTICE);
                } else {
                    $this->$prop = $val;
                }
            }
        }

        $this->image_bg_color  = $this->initColor($this->image_bg_color,  '#ffffff');
        $this->text_color      = $this->initColor($this->text_color,      '#616161');
        $this->line_color      = $this->initColor($this->line_color,      '#616161');
        $this->noise_color     = $this->initColor($this->noise_color,     '#616161');
        $this->signature_color = $this->initColor($this->signature_color, '#616161');

        if (is_null($this->ttf_file)) {
            $this->ttf_file = $this->securimage_path . '/AHGBold.ttf';
        }

        $this->signature_font = $this->ttf_file;

        if (is_null($this->wordlist_file)) {
            $this->wordlist_file = $this->securimage_path . '/words/words.txt';
        }

        if (is_null($this->code_length) || (int)$this->code_length < 1) {
            $this->code_length = 6;
        }

        if (is_null($this->perturbation) || !is_numeric($this->perturbation)) {
            $this->perturbation = 0.75;
        }

        if (is_null($this->namespace) || !is_string($this->namespace)) {
            $this->namespace = 'default';
        }

        if (is_null($this->no_exit)) {
            $this->no_exit = false;
        }

        if (is_null($this->no_session)) {
            $this->no_session = false;
        }

        if (is_null($this->send_headers)) {
            $this->send_headers = true;
        }

        if (is_null($this->log_file)) {
            $this->log_file = 'securimage.error_log';
        }

        if ($this->no_session != true) {
            // Initialize session or attach to existing
            if (session_id() == '' || (function_exists('session_status') && PHP_SESSION_NONE == session_status())) { // no session has been started yet (or it was previousy closed), which is needed for validation
                if (!is_null($this->session_name) && trim($this->session_name) != '') {
                    session_name(trim($this->session_name)); // set session name if provided
                }
                session_start();
            }
        }
    }

    /**
     * Return the absolute path to the Securimage directory.
     *
     * @return string The path to the securimage base directory
     */
    public static function getPath()
    {
        return dirname(__FILE__);
    }

    /**
     * Generate a new captcha ID or retrieve the current ID (if exists).
     *
     * @param bool $new If true, generates a new challenge and returns and ID.  If false, the existing captcha ID is returned, or null if none exists.
     * @param array $options Additional options to be passed to Securimage.
     *   $options must include database settings if they are not set directly in securimage.php
     *
     * @return null|string Returns null if no captcha id set and new was false, or the captcha ID
     */
    public static function getCaptchaId($new = true, array $options = array())
    {
        if (is_null($new) || (bool)$new == true) {
            $id = sha1(uniqid($_SERVER['REMOTE_ADDR'], true));
            $opts = array(
                'no_session'    => true,
                'use_database'  => true
            );
            if (sizeof($options) > 0) $opts = array_merge($options, $opts);
            $si = new self($opts);
            Securimage::$_captchaId = $id;
            $si->createCode();

            return $id;
        } else {
            return Securimage::$_captchaId;
        }
    }


    /**
     * Generates a new challenge and serves a captcha image.
     *
     * Appropriate headers will be sent to the browser unless the *send_headers* option is false.
     *
     * @param string $background_image The absolute or relative path to the background image to use as the background of the captcha image.
     *
     *     $img = new Securimage();
     *     $img->code_length = 6;
     *     $img->num_lines   = 5;
     *     $img->noise_level = 5;
     *
     *     $img->show(); // sends the image and appropriate headers to browser
     *     exit;
     */
    public function show($background_image = '')
    {
        set_error_handler(array(&$this, 'errorHandler'));

        if ($background_image != '' && is_readable($background_image)) {
            $this->bgimg = $background_image;
        }

        $this->doImage();
    }

    /**
     * Checks a given code against the correct value from the session and/or database.
     *
     * @param string $code  The captcha code to check
     *
     *     $code = $_POST['code'];
     *     $img  = new Securimage();
     *     if ($img->check($code) == true) {
     *         $captcha_valid = true;
     *     } else {
     *         $captcha_valid = false;
     *     }
     *
     * @return bool true if the given code was correct, false if not.
     */
    public function check($code)
    {
        if (!is_string($code)) {
            trigger_error("The \$code parameter passed to Securimage::check() must be a string, " . gettype($code) . " given", E_USER_NOTICE);
            $code = '';
        }

        $this->code_entered = $code;
        $this->validate();
        return $this->correct_code;
    }

    /**
     * Get the time in seconds that it took to solve the captcha.
     *
     * @return int The time in seconds from when the code was created, to when it was solved
     */
    public function getTimeToSolve()
    {
        return $this->_timeToSolve;
    }

    /**
     * Set the namespace for the captcha being stored in the session or database.
     *
     * Namespaces are useful when multiple captchas need to be displayed on a single page.
     *
     * @param string $namespace  Namespace value, String consisting of characters "a-zA-Z0-9_-"
     */
    public function setNamespace($namespace)
    {
        $namespace = preg_replace('/[^a-z0-9-_]/i', '', $namespace);
        $namespace = substr($namespace, 0, 64);

        if (!empty($namespace)) {
            $this->namespace = $namespace;
        } else {
            $this->namespace = 'default';
        }
    }

    /**
     * Return the code from the session or database (if configured).  If none exists or was found, an empty string is returned.
     *
     * @param bool $array  true to receive an array containing the code and properties, false to receive just the code.
     * @param bool $returnExisting If true, and the class property *code* is set, it will be returned instead of getting the code from the session or database.
     * @return array|string Return is an array if $array = true, otherwise a string containing the code
     */
    public function getCode($array = false, $returnExisting = false)
    {
        $code = array();

        if ($returnExisting && strlen($this->code) > 0) {
            if ($array) {
                return array(
                    'code'         => $this->code,
                    'display'      => $this->code_display,
                    'code_display' => $this->code_display,
                    'time'         => 0
                );
            } else {
                return $this->code;
            }
        }

        if ($this->no_session != true) {
            if (
                isset($_SESSION['securimage_code_value'][$this->namespace]) &&
                trim($_SESSION['securimage_code_value'][$this->namespace]) != ''
            ) {
                if ($this->isCodeExpired(
                    $_SESSION['securimage_code_ctime'][$this->namespace]
                ) == false) {
                    $code['code'] = $_SESSION['securimage_code_value'][$this->namespace];
                    $code['time'] = $_SESSION['securimage_code_ctime'][$this->namespace];
                    $code['display'] = $_SESSION['securimage_code_disp'][$this->namespace];
                }
            }
        }

        if ($array == true) {
            return $code;
        } elseif (!empty($code['code'])) {
            return $code['code'];
        }

        return '';
    }

    /**
     * The main image drawing routing, responsible for constructing the entire image and serving it
     */
    protected function doImage()
    {
        if ($this->use_transparent_text == true || $this->bgimg != '' || function_exists('imagecreatetruecolor')) {
            $imagecreate = 'imagecreatetruecolor';
        } else {
            $imagecreate = 'imagecreate';
        }

        $this->im = $imagecreate($this->image_width, $this->image_height);

        if (function_exists('imageantialias')) {
            imageantialias($this->im, true);
        }

        $this->allocateColors();

        if ($this->perturbation > 0) {
            $this->tmpimg = $imagecreate($this->image_width * $this->iscale, $this->image_height * $this->iscale);
            imagepalettecopy($this->tmpimg, $this->im);
        } else {
            $this->iscale = 1;
        }

        $this->setBackground();

        $code = '';

        if ($this->getCaptchaId(false) !== null) {
            // a captcha Id was supplied

            // check to see if a display_value for the captcha image was set
            if (is_string($this->display_value) && strlen($this->display_value) > 0) {
                $this->code_display = $this->display_value;
                $this->code         = ($this->case_sensitive) ?
                    $this->display_value   :
                    strtolower($this->display_value);
                $code = $this->code;
            }
        }

        if ($code == '') {
            // if the code was not set using display_value or was not found in
            // the database, create a new code
            $this->createCode();
        }

        if ($this->noise_level > 0) {
            $this->drawNoise();
        }

        $this->drawWord();

        if ($this->perturbation > 0 && is_readable($this->ttf_file)) {
            $this->distortedCopy();
        }

        if ($this->num_lines > 0) {
            $this->drawLines();
        }

        if (trim($this->image_signature) != '') {
            $this->addSignature();
        }

        $this->output();
    }

    /**
     * Allocate the colors to be used for the image
     */
    protected function allocateColors()
    {
        // allocate bg color first for imagecreate
        $this->gdbgcolor = imagecolorallocate(
            $this->im,
            $this->image_bg_color->r,
            $this->image_bg_color->g,
            $this->image_bg_color->b
        );

        $alpha = intval($this->text_transparency_percentage / 100 * 127);

        if ($this->use_transparent_text == true) {
            $this->gdtextcolor = imagecolorallocatealpha(
                $this->im,
                $this->text_color->r,
                $this->text_color->g,
                $this->text_color->b,
                $alpha
            );
            $this->gdlinecolor = imagecolorallocatealpha(
                $this->im,
                $this->line_color->r,
                $this->line_color->g,
                $this->line_color->b,
                $alpha
            );
            $this->gdnoisecolor = imagecolorallocatealpha(
                $this->im,
                $this->noise_color->r,
                $this->noise_color->g,
                $this->noise_color->b,
                $alpha
            );
        } else {
            $this->gdtextcolor = imagecolorallocate(
                $this->im,
                $this->text_color->r,
                $this->text_color->g,
                $this->text_color->b
            );
            $this->gdlinecolor = imagecolorallocate(
                $this->im,
                $this->line_color->r,
                $this->line_color->g,
                $this->line_color->b
            );
            $this->gdnoisecolor = imagecolorallocate(
                $this->im,
                $this->noise_color->r,
                $this->noise_color->g,
                $this->noise_color->b
            );
        }

        $this->gdsignaturecolor = imagecolorallocate(
            $this->im,
            $this->signature_color->r,
            $this->signature_color->g,
            $this->signature_color->b
        );
    }

    /**
     * The the background color, or background image to be used
     */
    protected function setBackground()
    {
        // set background color of image by drawing a rectangle since imagecreatetruecolor doesn't set a bg color
        imagefilledrectangle(
            $this->im,
            0,
            0,
            $this->image_width,
            $this->image_height,
            $this->gdbgcolor
        );

        if ($this->perturbation > 0) {
            imagefilledrectangle(
                $this->tmpimg,
                0,
                0,
                $this->image_width * $this->iscale,
                $this->image_height * $this->iscale,
                $this->gdbgcolor
            );
        }

        if ($this->bgimg == '') {
            if (
                $this->background_directory != null &&
                is_dir($this->background_directory) &&
                is_readable($this->background_directory)
            ) {
                $img = $this->getBackgroundFromDirectory();
                if ($img != false) {
                    $this->bgimg = $img;
                }
            }
        }

        if ($this->bgimg == '') {
            return;
        }

        $dat = @getimagesize($this->bgimg);
        if ($dat == false) {
            return;
        }

        switch ($dat[2]) {
            case 1:
                $newim = @imagecreatefromgif($this->bgimg);
                break;
            case 2:
                $newim = @imagecreatefromjpeg($this->bgimg);
                break;
            case 3:
                $newim = @imagecreatefrompng($this->bgimg);
                break;
            default:
                return;
        }

        if (!$newim) return;

        imagecopyresized(
            $this->im,
            $newim,
            0,
            0,
            0,
            0,
            $this->image_width,
            $this->image_height,
            imagesx($newim),
            imagesy($newim)
        );
    }

    /**
     * Scan the directory for a background image to use
     * @return string|bool
     */
    protected function getBackgroundFromDirectory()
    {
        $images = array();

        if (($dh = opendir($this->background_directory)) !== false) {
            while (($file = readdir($dh)) !== false) {
                if (preg_match('/(jpg|gif|png)$/i', $file)) $images[] = $file;
            }

            closedir($dh);

            if (sizeof($images) > 0) {
                return rtrim($this->background_directory, '/') . '/' . $images[mt_rand(0, sizeof($images) - 1)];
            }
        }

        return false;
    }

    /**
     * This method generates a new captcha code.
     *
     * Generates a random captcha code based on *charset*, math problem, or captcha from the wordlist and saves the value to the session and/or database.
     */
    public function createCode()
    {
        $this->code = false;

        switch ($this->captcha_type) {
            case self::SI_CAPTCHA_MATHEMATIC: {
                    do {
                        $signs = array('+', '-', 'x');
                        $left  = mt_rand(1, 10);
                        $right = mt_rand(1, 5);
                        $sign  = $signs[mt_rand(0, 2)];

                        switch ($sign) {
                            case 'x':
                                $c = $left * $right;
                                break;
                            case '-':
                                $c = $left - $right;
                                break;
                            default:
                                $c = $left + $right;
                                break;
                        }
                    } while ($c <= 0); // no negative #'s or 0

                    $this->code         = "$c";
                    $this->code_display = "$left $sign $right";
                    break;
                }

            case self::SI_CAPTCHA_WORDS:
                $words = $this->readCodeFromFile(2);
                $this->code = implode(' ', $words);
                $this->code_display = $this->code;
                break;

            default: {
                    if ($this->use_wordlist && is_readable($this->wordlist_file)) {
                        $this->code = $this->readCodeFromFile();
                    }

                    if ($this->code == false) {
                        $this->code = $this->generateCode($this->code_length);
                    }

                    $this->code_display = $this->code;
                    $this->code         = ($this->case_sensitive) ? $this->code : strtolower($this->code);
                } // default
        }

        $this->saveData();
    }

    /**
     * Draws the captcha code on the image
     */
    protected function drawWord()
    {
        $ratio = ($this->font_ratio) ? $this->font_ratio : 0.4;

        if ((float)$ratio < 0.1 || (float)$ratio >= 1) {
            $ratio = 0.4;
        }

        if (!is_readable($this->ttfFile())) {
            // this will not catch missing fonts after the first!
            $this->perturbation = 0;
            imagestring($this->im, 4, 10, ($this->image_height / 2) - 5, 'Failed to load TTF font file!', $this->gdtextcolor);

            return;
        }

        if ($this->perturbation > 0) {
            $width     = $this->image_width * $this->iscale;
            $height    = $this->image_height * $this->iscale;
            $font_size = $height * $ratio;
            $im        = &$this->tmpimg;
            $scale     = $this->iscale;
        } else {
            $height    = $this->image_height;
            $width     = $this->image_width;
            $font_size = $this->image_height * $ratio;
            $im        = &$this->im;
            $scale     = 1;
        }

        $captcha_text = $this->code_display;

        if ($this->use_random_spaces && $this->strpos($captcha_text, ' ') === false) {
            if (mt_rand(1, 100) % 5 > 0) { // ~20% chance no spacing added
                $index  = mt_rand(1, $this->strlen($captcha_text) - 1);
                $spaces = mt_rand(1, 3);

                // in general, we want all characters drawn close together to
                // prevent easy segmentation by solvers, but this adds random
                // spacing between two groups to make character positioning
                // less normalized.

                $captcha_text = sprintf(
                    '%s%s%s',
                    $this->substr($captcha_text, 0, $index),
                    str_repeat(' ', $spaces),
                    $this->substr($captcha_text, $index)
                );
            }
        }

        $fonts    = array();  // list of fonts corresponding to each char $i
        $angles   = array();  // angles corresponding to each char $i
        $distance = array();  // distance from current char $i to previous char
        $dims     = array();  // dimensions of each individual char $i
        $txtWid   = 0;        // width of the entire text string, including spaces and distances

        // Character positioning and angle

        $angle0 = mt_rand(10, 20);
        $angleN = mt_rand(-20, 10);

        if ($this->use_text_angles == false) {
            $angle0 = $angleN = $step = 0;
        }

        if (mt_rand(0, 99) % 2 == 0) {
            $angle0 = -$angle0;
        }
        if (mt_rand(0, 99) % 2 == 1) {
            $angleN = -$angleN;
        }

        $step   = abs($angle0 - $angleN) / (max(1, $this->strlen($captcha_text) - 1));
        $step   = ($angle0 > $angleN) ? -$step : $step;
        $angle  = $angle0;

        for ($c = 0; $c < $this->strlen($captcha_text); ++$c) {
            $font     = $this->ttfFile(); // select random font from list for this character
            $fonts[]  = $font;
            $angles[] = $angle;  // the angle of this character
            $dist     = mt_rand(-2, 0) * $scale; // random distance between this and next character
            $distance[] = $dist;
            $char     = $this->substr($captcha_text, $c, 1); // the character to draw for this sequence

            $dim = $this->getCharacterDimensions($char, $font_size, $angle, $font); // calculate dimensions of this character

            $dim[0] += $dist;   // add the distance to the dimension (negative to bring them closer)
            $txtWid += $dim[0]; // increment width based on character width

            $dims[] = $dim;

            $angle += $step; // next angle

            if ($angle > 20) {
                $angle = 20;
                $step  = $step * -1;
            } elseif ($angle < -20) {
                $angle = -20;
                $step  = -1 * $step;
            }
        }

        $nextYPos = function ($y, $i, $step) use ($height, $scale, $dims) {
            static $dir = 1;

            if ($y + $step + $dims[$i][2] + (10 * $scale) > $height) {
                $dir = 0;
            } elseif ($y - $step - $dims[$i][2] < $dims[$i][1] + $dims[$i][2] + (5 * $scale)) {
                $dir = 1;
            }

            if ($dir) {
                $y += $step;
            } else {
                $y -= $step;
            }

            return $y;
        };

        $cx = floor($width / 2 - ($txtWid / 2));
        $x  = mt_rand(5 * $scale, max($cx * 2 - (5 * $scale), 5 * $scale));

        if ($this->use_random_baseline) {
            $y = mt_rand($dims[0][1], $height - 10);
        } else {
            $y = ($height / 2 + $dims[0][1] / 2 - $dims[0][2]);
        }

        $st = $scale * mt_rand(5, 10);

        for ($c = 0; $c < $this->strlen($captcha_text); ++$c) {
            $font  = $fonts[$c];
            $char  = $this->substr($captcha_text, $c, 1);
            $angle = $angles[$c];
            $dim   = $dims[$c];

            if ($this->use_random_baseline) {
                $y = $nextYPos($y, $c, $st);
            }

            imagettftext(
                $im,
                $font_size,
                $angle,
                (int)$x,
                (int)$y,
                $this->gdtextcolor,
                $font,
                $char
            );

            if ($this->use_random_boxes && strlen(trim($char)) && mt_rand(1, 100) % 5 == 0) {
                imagesetthickness($im, 3);
                imagerectangle($im, $x, $y - $dim[1] + $dim[2], $x + $dim[0], $y + $dim[2], $this->gdtextcolor);
            }

            if ($c == ' ') {
                $x += $dim[0];
            } else {
                $x += $dim[0] + $distance[$c];
            }
        }

        // DEBUG
        //$this->im = $im;
        //$this->output();
    }

    /**
     * Get the width and height (in points) of a character for a given font,
     * angle, and size.
     *
     * @param string $char The character to get dimensions for
     * @param number $size The font size, in points
     * @param number $angle The angle of the text
     * @return number[] A 3-element array representing the width, height and baseline of the text
     */
    protected function getCharacterDimensions($char, $size, $angle, $font)
    {
        $box = imagettfbbox($size, $angle, $font, $char);

        return array($box[2] - $box[0], max($box[1] - $box[7], $box[5] - $box[3]), $box[1]);
    }

    /**
     * Copies the captcha image to the final image with distortion applied
     */
    protected function distortedCopy()
    {
        $numpoles = 3;       // distortion factor
        $px       = array(); // x coordinates of poles
        $py       = array(); // y coordinates of poles
        $rad      = array(); // radius of distortion from pole
        $amp      = array(); // amplitude
        $x        = ($this->image_width / 4); // lowest x coordinate of a pole
        $maxX     = $this->image_width - $x;  // maximum x coordinate of a pole
        $dx       = mt_rand($x / 10, $x);     // horizontal distance between poles
        $y        = mt_rand(20, $this->image_height - 20);  // random y coord
        $dy       = mt_rand(20, $this->image_height * 0.7); // y distance
        $minY     = 20;                                     // minimum y coordinate
        $maxY     = $this->image_height - 20;               // maximum y cooddinate

        // make array of poles AKA attractor points
        for ($i = 0; $i < $numpoles; ++$i) {
            $px[$i]  = ($x + ($dx * $i)) % $maxX;
            $py[$i]  = ($y + ($dy * $i)) % $maxY + $minY;
            $rad[$i] = mt_rand($this->image_height * 0.4, $this->image_height * 0.8);
            $tmp     = ((-$this->frand()) * 0.15) - .15;
            $amp[$i] = $this->perturbation * $tmp;
        }

        $bgCol   = imagecolorat($this->tmpimg, 0, 0);
        $width2  = $this->iscale * $this->image_width;
        $height2 = $this->iscale * $this->image_height;
        imagepalettecopy($this->im, $this->tmpimg); // copy palette to final image so text colors come across

        // loop over $img pixels, take pixels from $tmpimg with distortion field
        for ($ix = 0; $ix < $this->image_width; ++$ix) {
            for ($iy = 0; $iy < $this->image_height; ++$iy) {
                $x = $ix;
                $y = $iy;
                for ($i = 0; $i < $numpoles; ++$i) {
                    $dx = $ix - $px[$i];
                    $dy = $iy - $py[$i];
                    if ($dx == 0 && $dy == 0) {
                        continue;
                    }
                    $r = sqrt($dx * $dx + $dy * $dy);
                    if ($r > $rad[$i]) {
                        continue;
                    }
                    $rscale = $amp[$i] * sin(3.14 * $r / $rad[$i]);
                    $x += $dx * $rscale;
                    $y += $dy * $rscale;
                }
                $c = $bgCol;
                $x *= $this->iscale;
                $y *= $this->iscale;
                if ($x >= 0 && $x < $width2 && $y >= 0 && $y < $height2) {
                    $c = imagecolorat($this->tmpimg, $x, $y);
                }
                if ($c != $bgCol) { // only copy pixels of letters to preserve any background image
                    imagesetpixel($this->im, $ix, $iy, $c);
                }
            }
        }
    }

    /**
     * Draws distorted lines on the image
     */
    protected function drawLines()
    {
        for ($line = 0; $line < $this->num_lines; ++$line) {
            $x = $this->image_width * (1 + $line) / ($this->num_lines + 1);
            $x += (0.5 - $this->frand()) * $this->image_width / $this->num_lines;
            $y = mt_rand($this->image_height * 0.1, $this->image_height * 0.9);

            $theta = ($this->frand() - 0.5) * M_PI * 0.33;
            $w = $this->image_width;
            $len = mt_rand($w * 0.4, $w * 0.7);
            $lwid = mt_rand(0, 2);

            $k = $this->frand() * 0.6 + 0.2;
            $k = $k * $k * 0.5;
            $phi = $this->frand() * 6.28;
            $step = 0.5;
            $dx = $step * cos($theta);
            $dy = $step * sin($theta);
            $n = $len / $step;
            $amp = 1.5 * $this->frand() / ($k + 5.0 / $len);
            $x0 = $x - 0.5 * $len * cos($theta);
            $y0 = $y - 0.5 * $len * sin($theta);

            $ldx = round(-$dy * $lwid);
            $ldy = round($dx * $lwid);

            for ($i = 0; $i < $n; ++$i) {
                $x = $x0 + $i * $dx + $amp * $dy * sin($k * $i * $step + $phi);
                $y = $y0 + $i * $dy - $amp * $dx * sin($k * $i * $step + $phi);
                imagefilledrectangle($this->im, $x, $y, $x + $lwid, $y + $lwid, $this->gdlinecolor);
            }
        }
    }

    /**
     * Draws random noise on the image
     */
    protected function drawNoise()
    {
        if ($this->noise_level > 10) {
            $noise_level = 10;
        } else {
            $noise_level = $this->noise_level;
        }

        $t0 = microtime(true);
        $noise_level *= M_LOG2E;

        for ($x = 1; $x < $this->image_width; $x += 20) {
            for ($y = 1; $y < $this->image_height; $y += 20) {
                for ($i = 0; $i < $noise_level; ++$i) {
                    $x1 = mt_rand($x, $x + 20);
                    $y1 = mt_rand($y, $y + 20);
                    $size = mt_rand(1, 3);

                    if ($x1 - $size <= 0 && $y1 - $size <= 0) continue; // dont cover 0,0 since it is used by imagedistortedcopy
                    imagefilledarc($this->im, $x1, $y1, $size, $size, 0, mt_rand(180, 360), $this->gdlinecolor, IMG_ARC_PIE);
                }
            }
        }

        $t = microtime(true) - $t0;

        /*
        // DEBUG
        imagestring($this->im, 5, 25, 30, "$t", $this->gdnoisecolor);
        header('content-type: image/png');
        imagepng($this->im);
        exit;
        */
    }

    /**
     * Print signature text on image
     */
    protected function addSignature()
    {
        $bbox = imagettfbbox(10, 0, $this->signature_font, $this->image_signature);
        $textlen = $bbox[2] - $bbox[0];
        $x = $this->image_width - $textlen - 5;
        $y = $this->image_height - 3;

        imagettftext($this->im, 10, 0, $x, $y, $this->gdsignaturecolor, $this->signature_font, $this->image_signature);
    }

    /**
     * Sends the appropriate image and cache headers and outputs image to the browser
     */
    protected function output()
    {
        if ($this->canSendHeaders() || $this->send_headers == false) {
            if ($this->send_headers) {
                // only send the content-type headers if no headers have been output
                // this will ease debugging on misconfigured servers where warnings
                // may have been output which break the image and prevent easily viewing
                // source to see the error.
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-store, no-cache, must-revalidate");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
            }

            switch ($this->image_type) {
                case self::SI_IMAGE_JPEG:
                    if ($this->send_headers) header("Content-Type: image/jpeg");
                    imagejpeg($this->im, null, 90);
                    break;
                case self::SI_IMAGE_GIF:
                    if ($this->send_headers) header("Content-Type: image/gif");
                    imagegif($this->im);
                    break;
                default:
                    if ($this->send_headers) header("Content-Type: image/png");
                    imagepng($this->im);
                    break;
            }
        } else {
            echo '<hr /><strong>'
                . 'Failed to generate captcha image, content has already been '
                . 'output.<br />This is most likely due to misconfiguration or '
                . 'a PHP error was sent to the browser.</strong>';
        }

        imagedestroy($this->im);
        restore_error_handler();

        if (!$this->no_exit) exit;
    }

    /**
     * Gets a captcha code from a file containing a list of words.
     *
     * Seek to a random offset in the file and reads a block of data and returns a line from the file.
     *
     * @param int $numWords Number of words (lines) to read from the file
     * @return string|array|bool  Returns a string if only one word is to be read, or an array of words
     */
    protected function readCodeFromFile($numWords = 1)
    {
        $strtolower_func = 'strtolower';
        $mb_support      = false;

        if (!empty($this->wordlist_file_encoding)) {
            if (!extension_loaded('mbstring')) {
                trigger_error("wordlist_file_encoding option set, but PHP does not have mbstring support", E_USER_WARNING);
                return false;
            }

            // emits PHP warning if not supported
            $mb_support = mb_internal_encoding($this->wordlist_file_encoding);

            if (!$mb_support) {
                return false;
            }

            $strtolower_func = 'mb_strtolower';
        }

        $fp = fopen($this->wordlist_file, 'rb');
        if (!$fp) return false;

        $fsize = filesize($this->wordlist_file);
        if ($fsize < 512) return false; // too small of a list to be effective

        if ((int)$numWords < 1 || (int)$numWords > 5) $numWords = 1;

        $words = array();
        $w     = 0;
        $tries = 0;
        do {
            fseek($fp, mt_rand(0, $fsize - 512), SEEK_SET); // seek to a random position of file from 0 to filesize - 512 bytes
            $data = fread($fp, 512); // read a chunk from our random position

            if (($p = $this->strpos($data, "\n")) !== false) {
                $data = $this->substr($data, $p + 1);
            }

            if (($start = @$this->strpos($data, "\n", mt_rand(0, $this->strlen($data) / 2))) === false) {
                continue;
            }

            $data = $this->substr($data, $start + 1);
            $word = '';

            for ($i = 0; $i < $this->strlen($data); ++$i) {
                $c = $this->substr($data, $i, 1);
                if ($c == "\r") continue;
                if ($c == "\n") break;

                $word .= $c;
            }

            $word = trim($word);

            if (empty($word)) {
                continue;
            }

            $word = $strtolower_func($word);

            if ($mb_support) {
                // convert to UTF-8 for imagettftext
                $word = mb_convert_encoding($word, 'UTF-8', $this->wordlist_file_encoding);
            }

            $words[] = $word;
        } while (++$w < $numWords && $tries++ < $numWords * 2);

        fclose($fp);

        if (count($words) < $numWords) {
            return false;
        }

        if ($numWords == 1) {
            return $words[0];
        } else {
            return $words;
        }
    }

    /**
     * Generates a random captcha code from the set character set
     *
     * @see Securimage::$charset  Charset option
     * @return string A randomly generated CAPTCHA code
     */
    protected function generateCode()
    {
        $code = '';

        for ($i = 1, $cslen = $this->strlen($this->charset); $i <= $this->code_length; ++$i) {
            $code .= $this->substr($this->charset, mt_rand(0, $cslen - 1), 1);
        }

        return $code;
    }

    /**
     * Validate a code supplied by the user
     *
     * Checks the entered code against the value stored in the session and/or database (if configured).  Handles case sensitivity.
     * Also removes the code from session/database if the code was entered correctly to prevent re-use attack.
     *
     * This function does not return a value.
     *
     * @see Securimage::$correct_code 'correct_code' property
     */
    protected function validate()
    {
        if (!is_string($this->code) || strlen($this->code) == 0) {
            $code = $this->getCode(true);
            // returns stored code, or an empty string if no stored code was found
            // checks the session and database if enabled
        } else {
            $code = $this->code;
        }

        if (is_array($code)) {
            if (!empty($code)) {
                $ctime = $code['time'];
                $code  = $code['code'];

                $this->_timeToSolve = time() - $ctime;
            } else {
                $code = '';
            }
        }

        if ($this->case_sensitive == false && preg_match('/[A-Z]/', $code)) {
            // case sensitive was set from securimage_show.php but not in class
            // the code saved in the session has capitals so set case sensitive to true
            $this->case_sensitive = true;
        }

        $code_entered = trim((($this->case_sensitive) ? $this->code_entered
                : strtolower($this->code_entered))
        );
        $this->correct_code = false;

        if ($code != '') {
            if (strpos($code, ' ') !== false) {
                // for multi word captchas, remove more than once space from input
                $code_entered = preg_replace('/\s+/', ' ', $code_entered);
                $code_entered = strtolower($code_entered);
            }

            if ((string)$code === (string)$code_entered) {
                $this->correct_code = true;
                if ($this->no_session != true) {
                    $_SESSION['securimage_code_disp'][$this->namespace] = '';
                    $_SESSION['securimage_code_value'][$this->namespace] = '';
                    $_SESSION['securimage_code_ctime'][$this->namespace] = '';
                    $_SESSION['securimage_code_audio'][$this->namespace] = '';
                }
                // $this->clearCodeFromDatabase();
            }
        }
    }

    /**
     * Save CAPTCHA data to session and database (if configured)
     */
    protected function saveData()
    {
        if ($this->no_session != true) {
            if (isset($_SESSION['securimage_code_value']) && is_scalar($_SESSION['securimage_code_value'])) {
                // fix for migration from v2 - v3
                unset($_SESSION['securimage_code_value']);
                unset($_SESSION['securimage_code_ctime']);
            }

            $_SESSION['securimage_code_disp'][$this->namespace] = $this->code_display;
            $_SESSION['securimage_code_value'][$this->namespace] = $this->code;
            $_SESSION['securimage_code_ctime'][$this->namespace] = time();
            $_SESSION['securimage_code_audio'][$this->namespace] = null; // clear previous audio, if set
        }
    }

    /**
     * Checks to see if the captcha code has expired and can no longer be used.
     *
     * @see Securimage::$expiry_time expiry_time
     * @param int $creation_time  The Unix timestamp of when the captcha code was created
     * @return bool true if the code is expired, false if it is still valid
     */
    protected function isCodeExpired($creation_time)
    {
        $expired = true;

        if (!is_numeric($this->expiry_time) || $this->expiry_time < 1) {
            $expired = false;
        } else if (time() - $creation_time < $this->expiry_time) {
            $expired = false;
        }

        return $expired;
    }

    /**
     * Checks to see if headers can be sent and if any error has been output
     * to the browser
     *
     * @return bool true if it is safe to send headers, false if not
     */
    protected function canSendHeaders()
    {
        if (headers_sent()) {
            // output has been flushed and headers have already been sent
            return false;
        } else if (strlen((string)ob_get_contents()) > 0) {
            // headers haven't been sent, but there is data in the buffer that will break image and audio data
            return false;
        }

        return true;
    }
    /**
     * Return a random float between 0 and 0.9999
     *
     * @return float Random float between 0 and 0.9999
     */
    protected function frand()
    {
        return 0.0001 * mt_rand(0, 9999);
    }

    protected function strlen($string)
    {
        $strlen = 'strlen';

        if (function_exists('mb_strlen')) {
            $strlen = 'mb_strlen';
        }

        return $strlen($string);
    }

    protected function substr($string, $start, $length = null)
    {
        $substr = 'substr';

        if (function_exists('mb_substr')) {
            $substr = 'mb_substr';
        }

        if ($length === null) {
            return $substr($string, $start);
        } else {
            return $substr($string, $start, $length);
        }
    }

    protected function strpos($haystack, $needle, $offset = 0)
    {
        $strpos = 'strpos';

        if (function_exists('mb_strpos')) {
            $strpos = 'mb_strpos';
        }

        return $strpos($haystack, $needle, $offset);
    }

    /**
     * Convert an html color code to a Securimage_Color
     * @param string $color
     * @param Securimage_Color|string $default The defalt color to use if $color is invalid
     */
    protected function initColor($color, $default)
    {
        if ($color == null) {
            return new Securimage_Color($default);
        } else if (is_string($color)) {
            try {
                return new Securimage_Color($color);
            } catch (Exception $e) {
                return new Securimage_Color($default);
            }
        } else if (is_array($color) && sizeof($color) == 3) {
            return new Securimage_Color($color[0], $color[1], $color[2]);
        } else {
            return new Securimage_Color($default);
        }
    }

    protected function ttfFile()
    {
        if (is_string($this->ttf_file)) {
            return $this->ttf_file;
        } elseif (is_array($this->ttf_file)) {
            return $this->ttf_file[mt_rand(0, sizeof($this->ttf_file) - 1)];
        } else {
            throw new \Exception('ttf_file is not a string or array');
        }
    }

    /**
     * The error handling function used when outputting captcha image or audio.
     *
     * This error handler helps determine if any errors raised would
     * prevent captcha image or audio from displaying.  If they have
     * no effect on the output buffer or headers, true is returned so
     * the script can continue processing.
     *
     * See https://github.com/dapphp/securimage/issues/15
     *
     * @param int $errno  PHP error number
     * @param string $errstr  String description of the error
     * @param string $errfile  File error occurred in
     * @param int $errline  Line the error occurred on in file
     * @param array $errcontext  Additional context information
     * @return boolean true if the error was handled, false if PHP should handle the error
     */
    public function errorHandler($errno, $errstr, $errfile = '', $errline = 0, $errcontext = array())
    {
        // get the current error reporting level
        $level = error_reporting();

        // if error was supressed or $errno not set in current error level
        if ($level == 0 || ($level & $errno) == 0) {
            return true;
        }

        return false;
    }
}


/**
 * Color object for Securimage CAPTCHA
 *
 * @since 2.0
 * @package Securimage
 * @subpackage classes
 *
 */
class Securimage_Color
{
    /**
     * Red value (0-255)
     * @var int
     */
    public $r;

    /**
     * Gree value (0-255)
     * @var int
     */
    public $g;

    /**
     * Blue value (0-255)
     * @var int
     */
    public $b;

    /**
     * Create a new Securimage_Color object.
     *
     * Constructor expects 1 or 3 arguments.
     *
     * When passing a single argument, specify the color using HTML hex format.
     *
     * When passing 3 arguments, specify each RGB component (from 0-255)
     * individually.
     *
     * Examples:
     *
     *     $color = new Securimage_Color('#0080FF');
     *     $color = new Securimage_Color(0, 128, 255);
     *
     * @param string $color  The html color code to use
     * @throws Exception  If any color value is not valid
     */
    public function __construct($color = '#ffffff')
    {
        $args = func_get_args();

        if (sizeof($args) == 0) {
            $this->r = 255;
            $this->g = 255;
            $this->b = 255;
        } else if (sizeof($args) == 1) {
            // set based on html code
            if (substr($color, 0, 1) == '#') {
                $color = substr($color, 1);
            }

            if (strlen($color) != 3 && strlen($color) != 6) {
                throw new InvalidArgumentException(
                    'Invalid HTML color code passed to Securimage_Color'
                );
            }

            $this->constructHTML($color);
        } else if (sizeof($args) == 3) {
            $this->constructRGB($args[0], $args[1], $args[2]);
        } else {
            throw new InvalidArgumentException(
                'Securimage_Color constructor expects 0, 1 or 3 arguments; ' . sizeof($args) . ' given'
            );
        }
    }

    public function toLongColor()
    {
        return ($this->r << 16) + ($this->g << 8) + $this->b;
    }

    public function fromLongColor($color)
    {
        $this->r = ($color >> 16) & 0xff;
        $this->g = ($color >>  8) & 0xff;
        $this->b =  $color        & 0xff;

        return $this;
    }

    /**
     * Construct from an rgb triplet
     *
     * @param int $red The red component, 0-255
     * @param int $green The green component, 0-255
     * @param int $blue The blue component, 0-255
     */
    protected function constructRGB($red, $green, $blue)
    {
        if ($red < 0)     $red   = 0;
        if ($red > 255)   $red   = 255;
        if ($green < 0)   $green = 0;
        if ($green > 255) $green = 255;
        if ($blue < 0)    $blue  = 0;
        if ($blue > 255)  $blue  = 255;

        $this->r = $red;
        $this->g = $green;
        $this->b = $blue;
    }

    /**
     * Construct from an html hex color code
     *
     * @param string $color
     */
    protected function constructHTML($color)
    {
        if (strlen($color) == 3) {
            $red   = str_repeat(substr($color, 0, 1), 2);
            $green = str_repeat(substr($color, 1, 1), 2);
            $blue  = str_repeat(substr($color, 2, 1), 2);
        } else {
            $red   = substr($color, 0, 2);
            $green = substr($color, 2, 2);
            $blue  = substr($color, 4, 2);
        }

        $this->r = hexdec($red);
        $this->g = hexdec($green);
        $this->b = hexdec($blue);
    }
}
