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
 * SVGLine class
 *
 * API for line objects
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\SVGShapeEx
 * @uses Nplavsic\PhpSvg\SVGStyle
 */
class SVGLine extends SVGShapeEx
{

    /**
     * Define the x 1 of line
     *
     * @param int $x1
     */
    public function setX1($x1)
    {
        $this->addAttribute('x1', $x1);
    }
    
    /**
     * Define the x 2 of line
     *
     * @param int $x2
     */
    public function setX2($x2)
    {
        $this->addAttribute('x2', $x2);
    }
    
    /**
     * Define the y 1 of line
     *
     * @param int $y1
     */
    public function setY1($y1)
    {
        $this->addAttribute('y1', $y1);
    }
    
    /**
     * Define the y 2 of line
     *
     * @param int $y2
     */
    public function setY2($y2)
    {
        $this->addAttribute('y2', $y2);
    }
    
    /**
     * Return x1 attribute
     *
     * @return integer x1 attribute
     */
    public function getX1()
    {
        return $this->getAttribute('x1');
    }
    
    /**
     * Return x2 attribute
     *
     * @return integer x2 attribute
     */
    public function getX2()
    {
        return $this->getAttribute('x2');
    }
    
    /**
     * Return y1 attribute
     *
     * @return integer y1 attribute
     */
    public function getY1()
    {
        return $this->getAttribute('y1');
    }
    
    /**
     * Return y2  attribute
     *
     * @return integer y2 attribute
     */
    public function getY2()
    {
        return $this->getAttribute('y2');
    }
}
