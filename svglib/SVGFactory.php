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
 * SVGFactory class
 *
 * Used for creating svg objects
 * instead of constructors that can't be extended with SimpleXMLElement
 *
 * @version 0.9
 * @since 0.9
 */
class SVGFactory
{
    const VERSION = '1.1';
    const XMLNS = 'http://www.w3.org/2000/svg';
    const EXTENSION = 'svg';
    const EXTENSION_COMPACT = 'svgz';

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
    public function SVGCircle($cx, $cy, $radius, $id = null, $style = null)
    {
        $obj = new SVGCircle('<circle></circle>');
        $obj->setCx($cx);
        $obj->setCy($cy);
        $obj->setRadius($radius);
        $obj->setId($id);
        $obj->setStyle($style);

        return $obj;
    }

    /**
     * Construct a clippath
     *
     * @param string $id
     *
     * @return void
     */
    public function SVGClipPath($id)
    {
        $obj = new SVGClipPath('<clippath></clippath>');
        $obj->setId($id);

        return $obj;
    }

    /**
     * Create new SVGDocument
     *
     * @param $filename the file to load
     *
     * @return void
     */
    public function SVGDocument($filename = null)
    {
        if ($filename !== null) {
            return $this->openFile($filename);
        }

        return $this->openBlank();
    }

    /**
     * Return the extension of a filename
     *
     * @param string 	$filename 	- the filename to get the extension
     * @return string 	extension of given file
     */
    protected static function getFileExtension($filename)
    {
        $explode = explode('.', $filename);
        return strtolower($explode[ count($explode) - 1 ]);
    }
    
    /**
     * Open and load svg file
     * @param $filename the file to load
     *
     * @throws \Exception if file iz gzipped and there is no gzip support
     * @throws \Exception if file conent can't be loaded
     * @return void
     */
    protected function openFile($filename)
    {
        // if is svgz use compres.zlib to load the compacted SVG
        if (self::getFileExtension($filename) == self::EXTENSION_COMPACT) {
            
            // verify if zlib is installed
            if (!function_exists('gzopen')) {
                throw new Exception('GZip support not installed.');
            }

            $filename = 'compress.zlib://' . $filename;
        }

        // get the content
        $content = file_get_contents($filename);

        // throw error if not found
        if (!$content) {
            throw new Exception('Impossible to load content of file: ' . $filename);
        }

        return new SVGDocument($content);
    }

    /**
     * Open new file in A4 format
     *
     * @return void
     */
    protected function openBlank()
    {
        //create clean SVG
        $doc = new SVGDocument('<?xml version="1.0" encoding="UTF-8" standalone="no"?><svg></svg>');

        //define the default parameters A4 pageformat
        $doc->setWidth('210mm');
        $doc->setHeight('297mm');
        $doc->setVersion(self::VERSION);
        $doc->setAttribute('xmlns', self::XMLNS);
        
        return $doc;
    }
    
    /**
     * Construct an ellipse
     *
     * @param integer $cx the center x
     * @param integer $cy the center y
     * @param integer $radiusX the X radius of ellipse
     * @param integer $radiusY the Y radius of ellipse
     * @param string $id the id of element
     * @param SVGStyle $style style of element
     *
     * @return void
     */
    public function SVGEllipse($cx, $cy, $radiusX, $radiusY, $id = null, $style = null)
    {
        $obj = new SVGEllipse('<ellipse></ellipse>');

        $obj->setCx($cx);
        $obj->setCy($cy);
        $obj->setRadius($radiusX, $radiusY);
        $obj->setId($id);
        $obj->setStyle($style);

        return $obj;
    }

    /**
     * Construct a group
     *
     * @param string $id the id of element
     *
     * @return void
     */
    public function SVGGroup($id)
    {
        $obj = new SVGGroup('<g></g>');
        $obj->setId($id);

        return $obj;
    }

    /**
     * Construct an image
     *
     * @param integer $x the x position of image
     * @param integer $y the y position of image
     * @param string $id the id of element
     * @param string $filename path to image
     * @param boolean $embed flag for embeding the image
     *
     * @return void
     */
    public function SVGImage($x, $y, $id, $filename, $embed = true, $relative = false)
    {
        $obj = new SVGImage('<image></image>');
        $obj->setX($x);
        $obj->setY($y);
        $obj->setId($id);
        $obj->setImage($filename, $embed, $relative);

        return $obj;
    }

    /**
     * Construct a line
     *
     * @param integer $x1 x position for line start
     * @param integer $y1 y position for line start
     * @param integer $x2 x position for line end
     * @param integer $y2 y position for line end
     * @param string $id the id of element
     * @param SVGStyle $style style of element
     *
     * @return void
     */
    public function SVGLine($x1, $y1, $x2, $y2, $id = null, $style = null)
    {
        $obj = new SVGLine('<line></line>');

        $obj->setX1($x1);
        $obj->setX2($x2);
        $obj->setY1($y1);
        $obj->setY2($y2);
        $obj->setId($id);
        $obj->setStyle($style);

        return $obj;
    }

    /**
     * Construct a linear gradient
     *
     * @param string $id the id of element
     * @param array $stops gradient stops (NPlavsic\PhpSvg\SVGStop)
     *
     * @return void
     */
    public function SVGLinearGradient($id, array $stops)
    {
        $obj = new SVGLinearGradient('<linearGradient></linearGradient>');
        $obj->setId($id);
        $obj->setStops($stops);

        return $obj;
    }

    /**
     * Construct a path
     *
     * @param string or array $d the points
     * @param string $id of element
     * @param string|SVGStyle object $style of element
     *
     * @return void
     */
    public function SVGPath($d, $id, $style)
    {
        $obj = new SVGPath('<path></path>');

        // if is as array make implode to glue it
        if (is_array($d)) {
            $d = implode(' ', $d);
        }

        $obj->setAttribute('d', $d);
        $obj->setId($id);
        $obj->setAttribute('style', $style);

        return $obj;
    }

    /**
     * Construct a radial gradient
     *
     * @param string $id the id of element
     * @param array $stops gradient stops (NPlavsic\PhpSvg\SVGStop)
     *
     * @return void
     */
    public function SVGRadialGradient($id, array $stops)
    {
        $obj = new SVGRadialGradient('<radialGradient></radialGradient>');

        $obj->setId($id);
        $obj->setStops($stops);

        return $obj;
    }

    /**
     * Construct a rect
     *
     * @param integer $x the x position of rect
     * @param integer $y the y position of rect
     * @param string $id the id of element
     * @param integer $width the width of rect
     * @param integer $height the height of rect
     * @param string|SVGStyle $style style of element
     *
     * @return void
     */
    public function SVGRect($x, $y, $id, $width, $height, $style = null)
    {
        $obj = new SVGRect('<rect></rect>');

        $obj->setX($x);
        $obj->setY($y);
        $obj->setWidth($width);
        $obj->setHeight($height);
        $obj->setId($id);
        $obj->setStyle($style);

        return $obj;
    }

    /**
     * Construct a gradient stop
     *
     * @param string $id the id of element
     * @param string|SVGStyle $style style of element
     * @param float $offset stop offset
     *
     * @return void
     */
    public function SVGStop($id = null, $style = null, $offset = null)
    {
        $obj = new SVGStop('<stop></stop>');

        $obj->setId($id);
        $obj->setStyle($style);
        $obj->setOffset($offset);

        return $obj;
    }

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
    public function SVGText($x, $y, $id, $text, $style = null)
    {
        $obj = new SVGText('<text>'.$text.'</text>');
        
        $obj->setX($x);
        $obj->setY($y);
        $obj->setId($id);
        $obj->setAttribute('style', $style);

        return $obj;
    }
}
