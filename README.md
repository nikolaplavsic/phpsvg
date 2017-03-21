# phpsvg
Edit and create SVG Documents using OO PHP

## Features:

- Open and edit SVG and SVGZ (GZipped)
- Generate thumbnails or export to PNG, JPG, GIF,PS,EPS,PDF
- Support embebed or linked images.
- Use php features: SimpleXMLElement, GZip, Gd, Imagemagick.
- Can use inkscape to export some image formats.

Is in development.
## Code example:

```php
require_once "svglib.php";



$svg = SVGDocument::getInstance( 'resource/apple.svg' ); //open to edit

//$svg = SVGDocument::getInstance( ); //default read to use



$rect = #create a new rect with, x and y position, id, width and heigth, and the style

$rect = SVGRect::getInstance( 0, 5, 'myRect', 228, 185, new SVGStyle( array( 'fill'   => 'red', 'stroke' => 'blue' ) ) );

$svg->addShape( $rect );



$text = SVGText::getInstance( 22, 50, 'myText', 'This is a text', $style );



$svg->asXML('output/output.svg'); //output to svg file

$svg->export('output/output.png'); //export as png

$svg->export('output/thumb32x32.png',32,32); //export thumbnail

$svg->output(); //echo with header to browser

?>
```
