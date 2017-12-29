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
 * SVGCircle class
 * API for circle objects
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\SVGShapeEx
 * @uses NPlavsic\PhpSvg\SVGStyle
 */
class SVGCircle extends SVGShapeEx
{
    /**
     * Construct a circle
     * 
     * @param integer $cx the center x
     * @param integer $cy the center y
     * @param integer $radius the radius of circle
     * @param string $id the id of element
     * @param SVGStyle $style style of element
     * 
     * @return void 
     */
    public function __construct( $cx, $cy, $radius, $id = null, $style = null )
    {
        $this->createNewElement('<circle></circle>');

        $this->setCx( $cx );
        $this->setCy( $cy );
        $this->setRadius($radius);
        $this->setId( $id );
        $this->setStyle($style);
    }
    
    /**
     * Define the center x
     * 
     * @param integer $cx 
     */
    public function setCx( $cx )
    {
        $this->addAttribute('cx', $cx );
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
    public function setCy( $cy )
    {
        $this->addAttribute('cy', $cy );
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
    public function setRadius( $radius )
    {
        $this->addAttribute('r', $radius );
    }

    /**
     * Return the radius of circle
     * 
     * @return integer the radius of circle
     */
    public function getRadius( )
    {
        return $this->getAttribute('r');
    }
}