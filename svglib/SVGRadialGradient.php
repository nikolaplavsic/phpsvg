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
 * SVGRadialGradient class
 *
 * API for radial gradient objects
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\SVGLinearGradient
 * @uses Nplavsic\PhpSvg\SVGStop
 */
class SVGRadialGradient extends SVGLinearGradient
{

    /**
     * Construct a radial gradient
     *
     * @param string $id the id of element
     * @param array $stops gradient stops (NPlavsic\PhpSvg\SVGStop)
     *
     * @return void
     */
    public function __construct($id, array $stops)
    {
        $this->createNewElement('<radialGradient></radialGradient>');
        $this->setId($id);
        $this->setStops($stops);
    }
}
