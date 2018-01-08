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
 * SVGText class
 *
 * API for text objects
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\SVGShape
 * @uses Nplavsic\PhpSvg\SVGStyle
 */
class SVGText extends SVGShape
{

    /**
     * tspan object for text wrapping
     *
     * @var SVGShape
     */
    public $span;

    /**
     * Set font-size attribute
     *
     * @param float $size - font size
     *
     * @return SVGText - instance
     */
    public function setFontSize($size)
    {
        $this->setAttribute('font-size', $size);
        return $this;
    }

    /**
     * Set font-wight attribute
     *
     * @param string|integer $weight - font weight
     *
     * @return SVGText - instance
     */

    public function setFontWeight($weight)
    {
        $this->setAttribute('font-weight', $weight);
        return $this;
    }

    /**
     * Set font-style attribute
     *
     * @param string $style - font style
     *
     * @return SVGText - instance
     */
    public function setFontStyle($style)
    {
        $this->setAttribute('font-style', $style);
        return $this;
    }

    /**
     * Set font-family attribute
     *
     * @param string $font - font family
     *
     * @return SVGText - instance
     */
    public function setFontFamily($font)
    {
        $this->setAttribute('font-family', $font);
        return $this;
    }

    /**
     * Set color (fill) attribute
     *
     * @param string $color - font color
     *
     * @return SVGText - instance
     */
    public function setFill($color)
    {
        $this->setAttribute('fill', $color);
        return $this;
    }
}
