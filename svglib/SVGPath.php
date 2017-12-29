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
 * SVGPath class
 *
 * API for path objects
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\SVGShape
 * @uses Nplavsic\PhpSvg\SVGStyle
 */
class SVGPath extends SVGShape
{

    /**
     * Construct a path
     *
     * @param string or array $d the points
     * @param string $id of element
     * @param string|SVGStyle object $style of element
     *
     * @return void
     */
    public function __construct($d, $id, $style)
    {
        $this->createNewElement( '<path></path>' );

        // if is as array make implode to glue it
        if (is_array($d)) {
            $d = implode(' ', $d);
        }

        $path->setAttribute('d', $d);
        $path->setId($id);
        $path->setAttribute('style', $style);

    }
}