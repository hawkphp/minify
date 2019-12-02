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
 * Class Pipeline
 * @package Hawk\Minify
 */
class Pipeline
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $acceptor;

    /**
     * @var array
     */
    private $handlers = [];

    /**
     * Pipeline constructor.
     * @param null|string $value
     * @param null|string $acceptor
     */
    public function __construct($value = null, $acceptor = null)
    {
        if (is_string($value)) {
            $this->value = $value;
        }

        if (is_string($acceptor) !== null) {
            $this->acceptor = $acceptor;
        }
    }

    /**
     * @param $handler
     * @return $this
     */
    public function through($handler)
    {
        $this->handlers[] = $handler;
        return $this;
    }

    /**
     *
     */
    public function run()
    {
        $acceptor = $this->getAcceptor();

        if (!is_string($acceptor) || $acceptor === '') {
            throw new \InvalidArgumentException("No acceptor specified");
        }

        if (!is_string($this->value) || $this->value === '') {
            throw new \InvalidArgumentException("No value specified");
        }

        foreach ($this->handlers as $handler) {
            $value = $this->getValue();
            $this->setValue($handler->$acceptor($value));
        }
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getAcceptor()
    {
        return $this->acceptor;
    }

    /**
     * @param $acceptor
     * @return $this
     */
    public function setAcceptor($acceptor)
    {
        $this->acceptor = $acceptor;
        return $this;
    }

}