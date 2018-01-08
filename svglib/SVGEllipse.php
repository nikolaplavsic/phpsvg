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
 * SVGEllipse class
 *
 * API for ellipse objects
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\SVGShapeEx
 * @uses Nplavsic\PhpSvg\SVGStyle
 */
class SVGEllipse extends SVGShapeEx
{
    
    /**
     * Define the center x
     *
     * @param integer $cx
     */
    public function setCx($cx)
    {
        $this->addAttribute('cx', $cx);
    }
    
    /**
     * Return the center x
     *
     * @return integer cx attribute
     */
    public function getCx()
    {
        return $this->getAttribute('cx');
    }
    
    /**
     * Define the center y
     *
     * @param integer $cy
     */
    public function setCy($cy)
    {
        $this->addAttribute('cy', $cy);
    }
    
    /**
     * Return the center y
     *
     * @return integer cy attribute
     */
    public function getCy()
    {
        return $this->getAttribute('cy');
    }
    
    /**
     * Define the radius of circle
     *
     * @param integer $radius
     */
    public function setRadius($radiusX, $radiusY)
    {
        $this->addAttribute('rx', $radiusX);
        $this->addAttribute('ry', $radiusY);
    }

    /**
     * Return the x radius of circle
     *
     * @return integer the radius of circle
     */
    public function getRadiusX()
    {
        return $this->getAttribute('rx');
    }
    
    /**
     * Return the y radius of circle
     *
     * @return integer the radius of circle
     */
    public function getRadiusY()
    {
        return $this->getAttribute('ry');
    }
}
