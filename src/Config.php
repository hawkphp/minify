<?php

/**
 * Minify code a before deployment
 *
 * @author     Ruslan Baimurzaev <baimurzaev@gmail.com>
 * @license    http://mit-license.org
 * @link       https://github.com/hawkphp/predeploy
 */

namespace Hawk\Minify;

/**
 * Class Config
 * @property string pathFrom
 * @property string pathTo
 * @property array extensions
 * @property array handlers
 * @package Hawk\Minify
 */
class Config extends \ArrayAccessible
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Config constructor.
     * @param string|array|null $settings
     */
    public function __construct($settings = null)
    {
        $this->init($settings);

        if (is_array($settings)) {
            parent::__construct($settings);
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return null;
    }

    /**
     * @param string|null $xmlSettingsFile
     */
    protected function init($xmlSettingsFile)
    {
        if (is_string($xmlSettingsFile) && file_exists($xmlSettingsFile) === true) {
            $this->applyXmlConfig($xmlSettingsFile);
        } else {
            $this->applyDefaultSettings();
        }
    }

    /**
     * @param $xmlFile
     */
    public function applyXmlConfig($xmlFile)
    {
        $xml = new XmlReader($xmlFile);

        $this->data['description'] = ($xml->hasElement('description'))
            ? $xml->getElement('description') : 'Minify code';

        $this->data['pathFrom'] = ($xml->hasElement('pathFrom'))
            ? $xml->getElement('pathFrom') : 'src';

        $this->data['pathTo'] = ($xml->hasElement('pathTo'))
            ? $xml->getElement('pathTo') : 'deploy';

        $this->data['handlers'] = ($xml->hasElement('handlers'))
            ? $xml->getElement('handlers') : ['space', 'tabulation', 'break'];

        $this->data['extensions'] = ($xml->hasElement('extensions'))
            ? $xml->getElement('extensions') : ['php'];

        $this->data['packing'] = ($xml->hasElement('packing'))
            ? $xml->getElement('packing') : false;
    }

    /**
     * Default settings
     */
    public function applyDefaultSettings()
    {
        $this->data = array_merge($this->data, [
            'description' => 'Minify code',
            'pathFrom' => 'src',
            'pathTo' => 'deploy',
            'handlers' => ['space', 'tabulation', 'break'],
            'extensions' => ['php'],
            'packing' => false
        ]);
    }
}
