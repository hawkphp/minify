<?php

namespace Hawk\Minify;

/**
 * Class Config
 * @package Hawk\Minify
 */
class Config extends \ArrayAccessible
{
    /**
     * @var array
     */
    private $data = [];

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
     * Config constructor.
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);

        $this->init();
    }

    /**
     *
     */
    protected function init()
    {
        $defaultPath = realpath(__DIR__ . '/../../../');
        $defaultFile = 'hawk.minify.xml';

        $xmlConfigFile = $defaultPath . $defaultFile;
        $configExists = (file_exists($xmlConfigFile) === true);

        $xml = new XmlReader($xmlConfigFile);

        $this->data['description'] = ($configExists === true) ? $xml->getElement('description') : 'Minify code';
        $this->data['pathFrom'] = $defaultPath . ($configExists === true) ? $xml->getElement('pathFrom') : 'src';
        $this->data['pathTo'] = $defaultPath . ($configExists === true) ? $xml->getElement('pathTo') : 'deploy';
        $this->data['handlers'] = ($configExists === true) ? $xml->getElement('handlers') : ['space', 'tabulation', 'break'];
        $this->data['extensions'] = ($configExists === true) ? $xml->getElement('extensions') : ['php'];
        $this->data['packing'] = ($configExists === true) ? $xml->getElement('packing') : false;
    }
}
