<?php

namespace Arp\DateTime;

/**
 * Module
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime
 */
class Module
{
    /**
     * getConfig
     *
     * @return mixed
     */
    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }
}