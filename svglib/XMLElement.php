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

use SimpleXMLElement;

/**
 * Extend the functionalities of SimpleXMLElement
 * for use with svg elements
 * 
 * NOTE: From version 0.9 this class doesn't extend SimpleXMLElement
 *       SimpleXMLElement is used as property. This design
 *       is taken out of need to have own constructor.
 *
 * @version 0.9
 * @since 0.1
 *
 * @uses SimpleXMLElement
 */
class XMLElement
{

    /**
     * Value used to control last used id
     *
     * @var integer
     */
    protected static $uniqueId = 0;

    /**
     * Define if is to generate identificator automagic
     *
     * @var boolean if is to generate identificator automagic
     */
	public static $useAutoId = true;

	/**
	 * XML element instance to be used
	 * 
	 * @var \SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * Load new SimpleXMLElement with provided content
	 * 
	 * @param string $content xml content
	 * 
	 * @return void
	 */
	protected function createNewElement($content)
	{
		$this->xml = new SimpleXMLElement($content);
	}

	/**
	 * Wrapper for xml element function addAttribute()
	 * 
	 * @link http://php.net/manual/en/simplexmlelement.addattribute.php
	 * 
	 */
	public function addAttribute($name, $value = null, $namespace = null)
	{
		if(!$this->xml) {
			throw new \Exception('You need to create an xml element first.');
		}
		
		$this->xml->addAttribute($name, $value, $namespace);
	}

	/**
	 * Wrapper for xml element function addChild()
	 * 
	 * @link http://php.net/manual/en/simplexmlelement.addchild.php
	 * 
	 */
	public function addChild($name, $value = null, $namespace = null)
	{
		if(!$this->xml) {
			throw new \Exception('You need to create an xml element first.');
		}
		
		return $this->xml->addChild($name, $value, $namespace);
	}

	/**
	 * Wrapper for xml element function attributes()
	 * 
	 * @link http://php.net/manual/en/simplexmlelement.attributes.php
	 * 
	 */
	public function attributes()
	{
		if(!$this->xml) {
			throw new \Exception('You need to create an xml element first.');
		}

		return $this->xml->attributes();
	}

	/**
	 * Wrapper for xml element function children()
	 * 
	 * @link http://php.net/manual/en/simplexmlelement.children.php
	 * 
	 */
	public function children($namespace = null, $is_prefix = false)
	{
		if(!$this->xml) {
			throw new \Exception('You need to create an xml element first.');
		}
		
		return $this->xml->children($namespace, $is_prefix);
	}

	/**
	 * Wrapper for xml element function count()
	 * 
	 * @link http://php.net/manual/en/simplexmlelement.count.php
	 * 
	 */
	public function count()
	{
		if(!$this->xml) {
			throw new \Exception('You need to create an xml element first.');
		}
		
		return $this->xml->count();
	}

	/**
	 * Wrapper for xml element function getName()
	 * 
	 * @link http://php.net/manual/en/simplexmlelement.getname.php
	 * 
	 */
	public function getName()
	{
		if(!$this->xml) {
			throw new \Exception('You need to create an xml element first.');
		}
		
		return $this->xml->getName();
	}

	/**
	 * Wrapper for xml element function getNamespaces()
	 * 
	 * @link http://php.net/manual/en/simplexmlelement.getnamespaces.php
	 * 
	 */
	public function getNamespaces($recursive = false)
	{
		if(!$this->xml) {
			throw new \Exception('You need to create an xml element first.');
		}
		
		return $this->xml->getNamespaces($recursive);
	}


    /**
     * Remove a attribute
     *
     * @param string $attribute name of attribute
     */
    public function removeAttribute($attribute)
    {
        unset($this->attributes()->$attribute);
    }

    /**
     * Define an attribute, differs from addAttribute.
     * Define overwrite existent attribute
     *
     * @param string $attribute attribute to set
     * @param string $value value to set
     * @param string $namespace the namespace of attribute
     *
     * @return void
     * @example  $this->addAttribute("xlink:href", $filename, 'http://www.w3.org/1999/xlink');
     */
    public function setAttribute($attribute, $value, $namespace = null)
    {
        $this->removeAttribute($attribute);
        $this->addAttribute($attribute, $value, $namespace);
    }

    /**
     * Return a value of a attribute. Support namespaces using namespace:attribute
     *
     * @param string $attribute
     *
     * @return string return the value of passed attribute
     *
     * @example $svg->g->image->getAttribute('xlink:href')
     */
    public function getAttribute($attribute)
    {
        $explode = explode(":", $attribute);

        if (count($explode) > 1) {
            $attributes = $this->attributes($explode[ 0 ], true);

            // if the attribute exits with namespace return it
            if ($attributes[ $explode[ 1 ] ]) {
                return $attributes[ $explode[ 1 ] ];
                // ----- END -----
            }
            


            //otherwize will return the attribute without namespaces
            $attribute = $explode[ 1 ];
        }

        return strval($this->attributes()->$attribute);
        // ----- END -----
    }

    /**
     * Define ID of element
     *
     * @param string $id
     *
     * @return void
     */
    public function setId($id)
    {
        if (self::$useAutoId) {
            $id = $id ? $id : $this->getUniqueId();
        }

        $this->setAttribute('id', $id);
    }

    /**
     * Return identificator of element
     *
     * @return string identificator of element
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }

    /**
     * Returns a unique, never used before  identificator, Inkscape like.
     *
     * @return string
     */
    public function getUniqueId()
    {
        return $this->getName() . self::$uniqueId++;
    }

    /**
     * Append other XMLElement, support namespaces.
     *
     * @param NPlavsic\PhpSvg\XMLElement $append
     *
     * @return void
     */
    public function append(XMLElement $append)
    {
        // list all namespaces used in append object
        $namespaces = $append->getNameSpaces();

        // get all childs
        if (strlen(trim(strval($append)) == 0)) {
            $xml = $this->addChild($append->getName(), ' ');

            foreach ($append->children() as $child) {
                $xml->append($child);
            }
        } else {
            // add one child
            $xml = $this->addChild($append->getName(), strval($append) . ' ');
        }

        // add simple attributes
        foreach ($append->attributes() as $attribute => $value) {
            $xml->addAttribute($attribute, $value);
        }

        // add attributes with namespace example xlink:href
        foreach ($namespaces as $index => $namespace) {
            foreach ($append->attributes($namespace) as $attribute => $value) {
                $xml->addAttribute($index . ':' . $attribute, $value, $namespace);
            }
        }
    }

    /**
     * Find an element using it's id.
     * This function will return only one element, the first
     *
     * @param string $id the id to find
     *
     * @return NPlavsic\PhpSvg\XMLElement|null
     */
    public function getElementById($id)
    {
        return $this->getElementByAttribute('id', $id);
    }

    /**
     * Return the first element using the attribute and value passed.
     * Recursive method.
     *
     * @param string $attribute
     * @param string $value
     *
     * @return NPlavsic\PhpSvg\XMLElement|null
     */
    public function getElementByAttribute($attribute, $value)
    {
        if ($this->getAttribute($attribute) == $value) {
            return $this;
            // ----- END -----
        }


        
        if (count($this->children()) > 0) {
            foreach ($this->children() as $child) {
                $element = $child->getElementByAttribute($attribute, $value);

                if ($element) {
                    return $element;
                    // ----- END -----
                }
            }
        }

        return null;
        // ----- END -----
    }

    /**
     * Recursive function that search elements that match the condition.
     * Return an array of XmlElement.
     *
     * @param string $attribute the attribute to search
     * @param string $value the value to search
     * @param string $condition possible values ==, != , >, >=, <, <=
     *
     * @return array array of XmlElement
     */
    public function getElementsByAttribute($attribute, $value, $condition = '==')
    {
        $result = array( );
        $attributeValue = $this->getAttribute($attribute);

        switch ($condition) {
            case '==':
                // treat the empty condition
                if ($value == '') {
                    if (!$attributeValue) {
                        $result[ ] = $this;
                    }
                }

                if ($attributeValue == $value) {
                    $result[ ] = $this;
                }
                break;
            case '!=':
                if ($attributeValue != $value) {
                    $result[ ] = $this;
                }
                break;
            case '>':
                if ($attributeValue > $value) {
                    $result[ ] = $this;
                }
                break;
            case '>=':
                if ($attributeValue >= $value) {
                    $result[ ] = $this;
                }
                break;
            case '<':
                if ($attributeValue < $value) {
                    $result[ ] = $this;
                }
                break;
            case '<=':
                if ($attributeValue <= $value) {
                    $result[ ] = $this;
                }
                break;
            default:
                if ($this->count() > 0) {
                    foreach ($this->children() as $line => $child) {
                        $element = $child->getElementsByAttribute($attribute, $value);
                        if ($element) {
                            $result[ ] = $element;
                        }
                    }
                }
                break;
        }

        return $result;
    }

    /**
     * Define the title of the shape
     *
     * The first title element will be considered as document title.
     *
     * Is defined as alternative text in browser.
     *
     * @param string $title
     *
     * @return void
     */
    public function setTitle($title)
    {
        if (!$this->title) {
            $this->addChild('title', $title);
        } else {
            $this->title = $title;
        }
    }

    /**
     * Return the title of element
     *
     * @return string the title of element
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Define the description of the element
     *
     * @param string $desc
     *
     * @return void
     */
    public function setDescription($desc)
    {
        if (!$this->desc) {
            $this->addChild('desc', $desc);
        } else {
            $this->desc = $desc;
        }
    }

    /**
     * Return the description of element
     *
     * @return string the description of element
     */
    public function getDescription()
    {
        return $this->desc;
    }

    /**
     * Returns s formated xml
     *
     * @param   string $xml the xml text to format
     * @param   boolean $debug set to get debug-prints of RegExp matches
     *
     * @return string formatted XML
     *
     * @copyright TJ
     * @link kml.tjworld.net
     * @link http://forums.devnetwork.net/viewtopic.php?p=213989
     * @link http://recursive-design.com/blog/2007/04/05/format-xml-with-php/
     */
    protected function prettyXML($xml)
    {
        // add marker linefeeds to aid the pretty-tokeniser
        // adds a linefeed between all tag-end boundaries
        $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);

        // now pretty it up (indent the tags)
        $tok = strtok($xml, "\n");
        $formatted = ''; // holds pretty version as it is built
        $pad = 0; // initial indent
        $matches = array( ); // returns from preg_matches()

        /*
         * pre- and post- adjustments to the padding indent are made, so changes can be applied to
         * the current line or subsequent lines, or both
         */
        while ($tok !== false) {// scan each line and adjust indent based on opening/closing tags
            // test for the various tag states
            if (preg_match('/.+<\/\w[^>]*>$/', $tok, $matches)) {// open and closing tags on same line
                $indent = 0; // no change
            } elseif (preg_match('/^<\/\w/', $tok, $matches)) { // closing tag
                $pad--; //  outdent now
            } elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $tok, $matches)) {// opening tag
                $indent = 1; // don't pad this one, only subsequent tags
            } else {
                $indent = 0; // no indentation needed
            }

            // pad the line with the required number of leading spaces
            $prettyLine = str_pad($tok, strlen($tok) + $pad, ' ', STR_PAD_LEFT);
            $formatted .= $prettyLine . "\n"; // add to the cumulative result, with linefeed
            $tok = strtok("\n"); // get the next token
            $pad += $indent; // update the pad size for subsequent lines
        }

        return $formatted; // pretty format
    }

    /**
     * Output or return svg as xml
     *
     * @param string|null $filename path to a destination file for xml
     * @param boolean $humanReadable flag should xml be formatted for humans
     *
     * @return string|void
     */
    public function asXML($filename = null, $humanReadable = true)
    {
        if ($filename) {
            parent::asXML($filename);
            return;
            // ----- END -----
        }
        


        // define if xml is humanReadable or not
        if ($humanReadable) {
            return $this->prettyXML(parent::asXML());
            // ----- END -----
        }



        return parent::asXML();
        // ----- END -----
    }

    /**
     * Remove an element by it's id.
     *
     * @param string $id
     *
     * @return void
     */
    public function removeElementById($id)
    {
        $this->removeElement($this->getElementById($id));
    }

    /**
     * Remove element
     *
     * @param $node
     *
     * @return void
     */
    public function removeElement($node)
    {
        $dom = dom_import_simplexml($node);
        $dom->parentNode->removeChild($dom);
    }
}

#create the function if it not exists php < 5.3
if (!function_exists('mime_content_type')) {

    /**
     * Get Mime type from file
     *
     * @param $filename path to file
     *
     * @return string mime type
     */
    function mime_content_type($filename)
    {
        //TODO need better list
        $mime_types = array(
            'txt'  => 'text/plain',
            'htm'  => 'text/html',
            'html' => 'text/html',
            'php'  => 'text/html',
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'json' => 'application/json',
            'xml'  => 'application/xml',
            'swf'  => 'application/x-shockwave-flash',
            'flv'  => 'video/x-flv',
            // images
            'png'  => 'image/png',
            'jpe'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg'  => 'image/jpeg',
            'gif'  => 'image/gif',
            'bmp'  => 'image/bmp',
            'ico'  => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif'  => 'image/tiff',
            'svg'  => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            // archives
            'zip'  => 'application/zip',
            'rar'  => 'application/x-rar-compressed',
            'exe'  => 'application/x-msdownload',
            'msi'  => 'application/x-msdownload',
            'cab'  => 'application/vnd.ms-cab-compressed',
            // audio/video
            'mp3'  => 'audio/mpeg',
            'qt'   => 'video/quicktime',
            'mov'  => 'video/quicktime',
            // adobe
            'pdf'  => 'application/pdf',
            'psd'  => 'image/vnd.adobe.photoshop',
            'ai'   => 'application/postscript',
            'eps'  => 'application/postscript',
            'ps'   => 'application/postscript',
            // ms office
            'doc'  => 'application/msword',
            'rtf'  => 'application/rtf',
            'xls'  => 'application/vnd.ms-excel',
            'ppt'  => 'application/vnd.ms-powerpoint',
            // open office
            'odt'  => 'application/vnd.oasis.opendocument.text',
            'ods'  => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = explode('.', $filename);
        $ext = strtolower(array_pop($ext));

        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[ $ext ];
        }
        
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        
        return 'application/octet-stream';
    }
}