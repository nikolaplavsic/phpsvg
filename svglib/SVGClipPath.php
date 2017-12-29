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
 * Api for clippath element
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\SVGShape
 */
class SVGClipPath extends SVGShape
{

    /**
     * Construct a clippath
     *
     * @param string $id
     *
     * @return void
     */
    public function __construct( $id )
    {
        $this->createNewElement('<clippath></clippath>');
        $this->setId( $id );
    }

    public function addShape( $append )
    {
        $this->append( $append );

        return $this;
    }

}
