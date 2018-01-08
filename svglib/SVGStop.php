<?php
/*
 * This file is part of the PhpSvg package.
 *
 * @author Eduardo Bonfandini <trialforce@gmail.com>
 * @author Dampfklon <me@dampfklon.d>
 * @author Nikola Plavšić <nikolaplavsic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NPlavsic\PhpSvg;

/**
 * SVGStop class
 *
 * API for gradient stop objects
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\XmlElement
 * @uses Nplavsic\PhpSvg\SVGStyle
 */
class SVGStop extends XmlElement
{

    /**
     * Define the style of element, can be a SVGStyle element or an string
     *
     * @param SVGStyle $style SVGStyle element or an string
     */
    public function setStyle($style)
    {
        if (!$style) {
            $style = new SVGStyle();
        }

        $this->setAttribute('style', $style);
    }

    /**
     * Return the style element
     *
     * @return SVGStyle style of element
     */
    public function getStyle()
    {
        return new SVGStyle($this->getAttribute('style'));
    }

    /**
     * Define the color of the stop
     *
     * @param string $color
     */
    public function setColor($color)
    {
        $style = $this->getStyle();
        $style->stopColor = $color;

        $this->setStyle($style);
    }

    /**
     * Return the color of stop
     *
     * @return string
     */
    public function getColor()
    {
        return $this->getStyle()->stopColor;
    }

    /**
     * Define the opacity off this stop
     * The make it 100% visible set opacity to 1.
     *
     * @param int $opacity
     */
    public function setOpacity($opacity = 1)
    {
        $style = $this->getStyle();
        $style->stopOpacity = intval($opacity);

        $this->setStyle($style);
    }

    /**
     * Return the opacity off this stop
     *
     * @return int return the opacity off this stop, 1 means 100% visible
     */
    public function getOpacity()
    {
        return intval($this->getStyle()->opacity);
    }

    /**
     * Define the offset of the stop
     * Offset variates from 0 to 1, passing by floating value between it.
     *
     * @param float $offset
     */
    public function setOffset($offset)
    {
        $this->setAttribute('offset', floatval($offset));
    }

    /**
     * Return the offset of the stop
     *
     * Offset variates from 0 to 1, passing by floating value between it.
     *
     * @return float
     */
    public function getOffset()
    {
        return intval($this->getAttribute('offset'));
    }
}
