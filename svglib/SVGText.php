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
     * Construct a text
     *
     * @param integer $x the x position of text
     * @param integer $y the y position of text
     * @param string $id the id of element
     * @param string $text content for text element
     * @param string|SVGStyle $style style of element
     *
     * @return void
     */
    public function __construct( $x, $y, $id, $text, $style = null )
    {
        $this->createNewElement('<text>'.$text.'</text>');
        $this->setX( $x );
        $this->setY( $y );
        $thist->setId( $id );
        $this->setAttribute( 'style', $style );
    }

}
