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
 * SVGLinearGradient class
 *
 * API for linear gradient objects
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\XmlElement
 * @uses Nplavsic\PhpSvg\SVGStop
 */
class SVGLinearGradient extends XmlElement
{

    /**
     * Add one stop object.
     * Do not control the offset.
     *
     * @param SVGStop $stop
     */
    public function addStop(SVGStop $stop)
    {
        $this->append($stop);
    }

    /**
     * Define an array of SVGStop
     *
     * @param array of SVGStop
     */
    public function setStops($stops)
    {
        if (is_array($stops)) {
            //automagic controls the offset
            $offset = 0;
            $stopCount = count($stops)-1;

            foreach ($stops as $line => $stop) {
                if ($stop instanceof SVGStop) {
                    if (!$stop->getOffset()) {
                        $c = 1 * ($offset / $stopCount);
                        $offset++;
                        $stop->setOffset($c);
                    }

                    $this->addStop($stop);
                }
            }
        }
    }
}
