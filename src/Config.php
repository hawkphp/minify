<?php

/**
 * Prepare deploy 2019
 * Minify code a before deployment
 *
 * @author     Ruslan Baimurzaev <baimurzaev@gmail.com>
 * @license    http://mit-license.org/
 * @link        https://github.com/hawkphp/predeploy
 */

namespace Hawk\Minify;

/**
 * Class Config
 * @property string pathFrom
 * @property string pathTo
 * @property array extensions
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
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        $this->init();

        parent::__construct($array);
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
     *
     */
    protected function init()
    {
        $defaultPath = realpath(__DIR__ . '/../../../');
        $defaultFile = 'minify.hawk.xml';
        $xmlConfigFile = $defaultPath . $defaultFile;

        if (file_exists($xmlConfigFile) === true) {
            $this->applyXmlConfig($xmlConfigFile);
        } else {
            $this->getDefaultSettings();
        }
    }

    /**
     * @param $xmlFile
     */
    public function applyXmlConfig($xmlFile)
    {
        $xml = new XmlReader($xmlFile);

        $this->data['description'] = ($xml->hasElement('description'))
            ? $xml->getElement('description') : '';

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
    public function getDefaultSettings()
    {
        return [
            'description' => 'Minify code',
            'pathFrom' => 'src',
            'pathTo' => 'deploy',
            'handlers' => ['space', 'tabulation', 'break'],
            'extensions' => ['php'],
            'packing' => false
        ];
    }
}
