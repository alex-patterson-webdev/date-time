<?php

namespace Arp\DateTime\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * DateTime
 *
 * View helper used to render a \DateTime instance to a specific string format.
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
     * __construct.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (! empty($options['format'])) {
            $this->setFormat($options['format']);
        }
    }

    /**
     * __invoke
     *
     * Render the date and time as a string.
     *
     * @param \DateTime|null $dateTime  The date and time instance to format.
     * @param array          $options   The optional rendering options.
     *
     * @return string
     */
    public function __invoke(\DateTime $dateTime = null, array $options = []) : string
    {
        if (null === $dateTime) {
            return '';
        }

        return $this->render($dateTime, $options);
    }

    /**
     * render
     *
     * Render the \DateTime instance as a string.
     *
     * @param \DateTime $dateTime  The date and time instance to format.
     * @param array     $options   The optional rendering options.
     *
     * @return string
     */
    public function render(\DateTime $dateTime, array $options = []) : string
    {
        $format = isset($options['format']) ? $options['format'] : $this->format;

        return $dateTime->format($format);
    }

    /**
     * setFormat
     *
     * Set the view helper date time format.
     *
     * @param string $format
     */
    public function setFormat(string $format)
    {
        $this->format = $format;
    }

}