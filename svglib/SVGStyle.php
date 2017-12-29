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
 * SVGStyle class
 *
 * Service for applying styles
 *
 * @version 0.9
 * @since 0.1
 */

class SVGStyle
{
    public $fill;
    public $stroke;
    public $strokeWidth;
    public $stopColor;
    public $stopOpacity;
    public $display;
    
    /**
     * Construct the style
     *
     * @param array $style an array with styles
     */
    public function __construct( $style = null )
    {
        if (is_string($style) )
        {
            $style = explode(';', $style);

            if ( is_array($style))
            {
                foreach ( $style as $line => $info )
                {
                    $styleElement = explode(':', $info);

                    if ( $styleElement[0] )
                    {
                        $property = SVGStyle::toCamelCase( $styleElement[0]);
                        $this->{$property} = $styleElement[1];
                    }
                }
            }
        }
        else if ( is_array($style) )
        {
            foreach ( $style as $line => $info )
            {
                $this->$line = $info;
            }
        }
    }

    /**
     * Return the string representation of object
     *
     * @return string representation of object
     */
    public function __toString()
    {
        $vars = get_object_vars($this);
        $result = '';

        if ( is_array($vars) )
        {
            foreach ( $vars as $line => $info )
            {
                if ( isset($info) )
                {
                    $line  = SVGStyle::fromCamelCase( $line );
                    $result .= "$line:$info;";
                }
            }
        }

        return $result;
    }
    
    /**
     * Define the display of elemet
     * 
     * @param string $display
     */
    public function setDisplay($display)
    {
        $this->display = $display;
    }
    
    /**
     * Return the display of element
     * @return string
     */
    public function getDisplay()
    {
        return $this->display;
    }
    
    /**
     * Show the element
     */
    public function show()
    {
        $this->display = 'inline';
    }
    
    /**
     * Hide the element
     */
    public function hide()
    {
        $this->display = 'none';
    }

    /**
     * Set the fill color
     *
     * @param string $fill color
     */
    public function setFill($fill)
    {
        if ( $fill instanceof SVGLinearGradient )
        {
            $fill = $this->url( $fill );
        }
        
        $this->fill = $fill;
    }

    /**
     * Get the fill color
     * 
     * @return string fill color
     */
    public function getFill()
    {
        return $this->fill;
    }

    /**
     * Set the stroke (contour) color
     *
     * @param string $stroke the stroke color
     */
    public function setStroke($stroke, $width = null )
    {
        $this->stroke = $stroke;
        
        $this->setStrokeWidth($width);
    }
    
    /**
     * Define the width of the stroke
     * 
     * @param integer $width width of the stroke
     */ 
    public function setStrokeWidth( $width )
    {
        if ( $width )
        {
            $this->strokeWidth = $width;
        }
    }
    
    /**
     * Return the stroke width
     * 
     * @return type integer
     */
    public function getStrokeWidth()
    {
        return $this->strokeWidth;
    }

    /**
     * Return the stroke (contour) color
     *
     * @return string
     */
    public function getStroke( )
    {
        return $this->stroke;
    }

    /**
     * Make the url in some param
     *
     * @param XmlElement or string $content
     *
     * @return string
     */
    public function url( $content )
    {
        $url = $content;
        
        if ( $content instanceof XmlElement )
        {
            $url = '#'.$content->getId();
        }
        
        return "url({$url})";
    }

    /**
     * Make a not camelCase version of string
     *
     * http://www.paulferrett.com/2009/php-camel-case-functions/
     *
     * stopColor turns stop-color
     *
     * @param string $str
     * @return string the new string
     */
    protected static function fromCamelCase($str)
    {
        $str[0] = strtolower($str[0]);
        return preg_replace_callback('/([A-Z])/', function ($hit) {return "-".strtolower($hit[0]);}, $str);
    }

    /**
     * Converts a string to camelCase
     *
     * stop-color turns stopColor 
     *
     * @param string $str
     * @return string
     */
    protected static function toCamelCase($str)
    {
        return preg_replace_callback('/-([a-z])/', function ($hit) {return strtoupper($hit[0]);}, $str);
    }
}
