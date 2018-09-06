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
 * SVGImage class
 * API for image objects
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses NPlavsic\PhpSvg\SVGShapeEx
 */
class SVGImage extends SVGShapeEx
{

    /**
     * Return the binary data of image
     *
     * @return bin the binary data of image
     * @example file_put_contents( 'output/test.png' , $image->getImage() );
     */
    public function getImage()
    {
        $info = $this->getImageData();

        if ($info->encode == 'base64') {
            //get embed image
            return base64_decode($info->binary);
        } else {
            //get file of system
            return file_get_contents($this->getAttribute('xlink:href'));
        }
    }

    /**
     * Explode embed image string returning a stdClass with, mime, encode e binary properties
     *
     * @param string $image
     * @return stdClass a stdClass with, mime, encode e binary properties
     */
    public function getImageData()
    {
        $image = $this->getAttribute('xlink:href');

        if (stripos($image, 'data:') === 0) {
            $explode = explode(',', $image);
            $mime = explode(';', $explode[0]);

            $img = new stdClass();
            $img->mime = str_replace('data:', '', $mime[0]);
            $img->encode = $mime[1];
            $img->binary = $explode[1];

            return $img;
        }

        return null;
    }

    /**
     * Define the image file.
     * Embed files will be parsed and inserted into SVG file using base64.
     *
     * @param string $filename
     * @param string $embed if is to embed or not
     * @param string $relative if to make path to file relative
     */
    public function setImage($filename, $embed = true)
    {
        if ($embed) {
            //get the sizes of image using gd
            $imageSize = getimagesize($filename, $imageSize);
            $mime = mime_content_type($filename);
            $file = base64_encode(file_get_contents($filename));
            $filename = 'data:' . $mime . ';base64,' . $file;
            $this->setWidth($imageSize[0]); //define the size of image
            $this->setHeight($imageSize[1]);
            return;
        }

        $this->addAttribute("xlink:href", $filename, 'http://www.w3.org/1999/xlink');
    }


}
