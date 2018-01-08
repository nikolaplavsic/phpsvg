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
 * Implementation of ShapeEx, it is a shape with width.
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\SVGShape
 */
class SVGShapeEx extends SVGShape
{
    /**
     * Define the width of the object
     *
     * @param integer $width
     */
    public function setWidth($width)
    {
        $this->setAttribute('width', $width);
    }

    /**
     * Return the width of element
     *
     * @return integer the width of element
     */
    public function getWidth()
    {
        return $this->getAttribute('width');
    }

    /**
     * Define the height of the object
     *
     * @param integer $height
     */
    public function setHeight($height)
    {
        $this->setAttribute('height', $height);
    }

    /**
     * Return the height of element
     *
     * @return integer the height of element
     */
    public function getHeight()
    {
        return $this->getAttribute('height');
    }
}
