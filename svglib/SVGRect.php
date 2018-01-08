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
 * SVGRect class
 *
 * API for rectangle objects
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\SVGShapeEx
 * @uses Nplavsic\PhpSvg\SVGStyle
 */
class SVGRect extends SVGShapeEx
{
    
    /**
     * Define the round of rect
     *
     * @param integer $rx the round
     */
    public function setRound($rx)
    {
        $this->addAttribute('rx', $rx);
    }
    
    /**
     * Return the round of rect
     *
     * @return integer return the round
     */
    public function getRound()
    {
        return $this->getAttribute('rx');
    }
}
