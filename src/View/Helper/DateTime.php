<?php

namespace Arp\DateTime\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * DateTime
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\DateTime\View\Helper
 */
class DateTime extends AbstractHelper
{
    /**
     * $format
     *
     * @var string
     */
    protected $format = 'd/m/y H:m:s';

    /**
     * __invoke
     *
     * Render the date and time as a string.
     *
     * @param \DateTime|null $dateTime
     * @param array          $options
     *
     * @return string
     */
    public function __invoke(\DateTime $dateTime = null, array $options = [])
    {
        if (null == $dateTime) {
            return '';
        }

        return $this->render($dateTime, $options);
    }

    /**
     * render
     *
     * @param \DateTime $dateTime
     * @param array     $options
     *
     * @return string
     */
    public function render(\DateTime $dateTime, array $options = [])
    {
        return $dateTime->format($this->format);
    }

}