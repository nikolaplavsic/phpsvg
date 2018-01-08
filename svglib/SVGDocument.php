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
 * SVGDocument class
 *
 * Used for creating svg documents
 *
 * Class pre-requisites:
 * - SimpleXmlElement - http://php.net/manual/en/class.simplexmlelement.php
 * - gzip support (for compressed svg) - http://php.net/manual/en/book.zlib.php
 * - imagemagick to export to png - http://php.net/manual/en/book.imagick.php
 * - GD to use embed image - http://php.net/manual/pt_BR/book.image.php
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\SVGShape
 */
class SVGDocument extends SVGShape
{
    const VERSION = '1.1';
    const XMLNS = 'http://www.w3.org/2000/svg';
    const EXTENSION = 'svg';
    const EXTENSION_COMPACT = 'svgz';
    const HEADER = 'image/svg+xml';
    const EXPORT_TYPE_IMAGE_MAGIC = 'imagick';
    const EXPORT_TYPE_INKSCAPE = 'inkscape';


    /**
     * Path to a file that is opened
     *
     * @var string
     */
    public $filename;
    
    

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
     * Out the file, used in browser situation,
     * because it changes the header to xml header
     *
     */
    public function output()
    {
        header('Content-type: ' . self::HEADER);
        echo $this->asXML();
    }

    /**
     * Define the version of SVG document
     *
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->setAttribute('version', $version);

        return $this;
    }

    /**
     * Get the version of SVG document
     *
     * @param string $version
     */
    public function getVersion()
    {
        return $this->getAttribute('version');
    }

    /**
     * Define the page dimension , width.
     *
     * @example setWidth('350px');
     * @example setWidth('350mm');
     *
     * @param string $width
     */
    public function setWidth($width)
    {
        $this->setAttribute('width', $width);

        return $this;
    }

    /**
     * Set the view box attribute, used to make SVG resizable in browser.
     *
     * @param string $startX start x coordinate
     * @param string $startY start y coordinate
     * @param string $width width
     * @param string $height height
     */
    public function setViewBox($startX, $startY, $width, $height)
    {
        $viewBox = str_replace(array( '%', 'px' ), '', "$startX $startY $width $height");
        $this->setAttribute('viewBox', $viewBox);

        return $this;
    }

    /**
     * Set the default view box, based on width and height.
     *
     * Used to make SVG resizable in browser.
     */
    public function setDefaultViewBox()
    {
        return $this->setViewBox(0, 0, $this->getWidth(), $this->getHeight());
    }

    /**
     * Returns the width of page
     *
     * @return string the width of page
     */
    public function getWidth()
    {
        return $this->getAttribute('width');
    }

    /**
     * Define the height of page.
     *
     * @param string $height
     *
     * @example setHeight('350mm');
     * @example setHeight('350px');
     */
    public function setHeight($height)
    {
        $this->setAttribute('height', $height);

        return $this;
    }

    /**
     * Returns the height of page
     *
     * @return string the height of page
     */
    public function getHeight()
    {
        return $this->getAttribute('height');
    }

    /**
     * Add a shape to SVG graphics
     *
     * @param XMLElement $append the element to append
     */
    public function addShape($append)
    {
        $this->append($append);

        return $this;
    }

    /**
     * Add some element to defs, normally a gradient
     *
     * @param XMLElement $element
     */
    public function addDefs($element)
    {
        if (!$this->defs) {
            $defs = new XMLElement('<defs></defs>');
            $this->append($defs);
        }

        $this->defs->append($element);
    }

    /**
     * Add some script content to svg
     *
     * @param text $script
     */
    public function addScript($script)
    {
        $element = new XMLElement('<script>' . $script . '</script>');
        $this->append($element);

        return $this;
    }

    /**
     * Return the definitions of the document, normally has gradients.
     *
     * @return SVGElement
     */
    public function getDefs()
    {
        return $this->defs;
    }

    /**
     * Export to a image file, consider file extension
     * Uses imageMagick or inkcape. If one fail try other.
     *
     * Try to define the complete path of files, works better for exportation.
     *
     * @param string $filename
     * @param integer $width the width of exported image
     * @param integer $height the height of exported image
     * @param boolean $respectRatio respect the ratio, image proportion
     * @param string $exportType the default export type
     */
    public function export($filename, $width = null, $height = null, $respectRatio = false, $exportType = SVGDocument::EXPORT_TYPE_IMAGE_MAGIC)
    {
        if ($exportType == SVGDocument::EXPORT_TYPE_IMAGE_MAGIC) {
            try {
                return $this->exportImagick($filename, $width, $height, $respectRatio);
            } catch (Exception $e) {
                try {
                    return $this->exportInkscape($filename, $width, $height);
                } catch (Exception $exc) {
                    $exc = null;
                    throw $e; //throw the first error
                }
            }
        } else {
            try {
                return $this->exportInkscape($filename, $width, $height);
            } catch (Exception $e) {
                try {
                    return $this->exportImagick($filename, $width, $height, $respectRatio);
                } catch (Exception $exc) {
                    $exc = null;
                    throw $e; //throw the original error
                }
            }
        }
    }

    /**
     * Export as SVG to image document using inkscape.
     *
     * It will save a temporary file on default system tempo folder.
     *
     * @param string $filename try to use complete path. Works better.
     * @param integer $width
     * @param integer $height
     *
     * @return boolean ?
     */
    public function exportInkscape($filename, $width = null, $height = null)
    {
        $format = SVGDocument::getFileExtension($filename);
        $inkscape = new Inkscape($this);
        $inkscape->setSize($width, $height);

        return $inkscape->export($format, $filename);
    }

    /**
     * Export to a image file, consider file extension
     * Uses imageMagick
     *
     * @param string $filename
     * @param integer $width the width of exported image
     * @param integer $height the height of exported image
     * @param boolean $respectRatio respect the ratio, image proportion
     */
    public function exportImagick($filename, $width = null, $height = null, $respectRatio = false)
    {
        if (!class_exists('Imagick')) {
            throw new Exception('Imagemagick class not found. Please install it.');
        }

        $image = new \Imagick();

        $ok = $image->readImageBlob($this->asXML(null, false));

        if ($ok) {
            if ($width && $height) {
                $image->thumbnailImage($width, $height, $respectRatio);
            }

            $image->writeImage($filename);

            $ok = true;
        }

        return $ok;
    }
}
