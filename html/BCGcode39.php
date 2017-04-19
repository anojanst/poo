<?php
define('IN_CB', true);

include_once('include/function.php');



?>
<!DOCTYPE html>
<html>
    <head>

        <script src="jquery-1.7.2.min.js"></script>
        <script src="barcode.js"></script>
    </head>
    <body >

<?php
$default_value = array();
$default_value['filetype'] = 'PNG';
$default_value['dpi'] = 72;
$default_value['scale'] = isset($defaultScale) ? $defaultScale : 1;
$default_value['rotation'] = 0;
$default_value['font_family'] = 'Arial.ttf';
$default_value['font_size'] = 8;
$default_value['text'] = '';
$default_value['a1'] = '';
$default_value['a2'] = '';
$default_value['a3'] = '';

$filetype = $default_value['filetype'];
$dpi = $default_value['dpi'];
$scale = intval($default_value['scale']);
$rotation = intval($default_value['rotation']);
$font_family = $default_value['font_family'];
$font_size = intval($default_value['font_size']);
$text = $default_value['text'];

registerImageKey('filetype', $filetype);
registerImageKey('dpi', $dpi);
registerImageKey('scale', $scale);
registerImageKey('rotation', $rotation);
registerImageKey('font_family', $font_family);
registerImageKey('font_size', $font_size);
registerImageKey('text', stripslashes("$_REQUEST[barcode]"));

// Text in form is different than text sent to the image



$default_value['checksum'] = '';
$checksum = $default_value['checksum'];
registerImageKey('checksum', $checksum);
registerImageKey('code', 'BCGcode39');

                        $finalRequest = '';
                        foreach (getImageKeys() as $key => $value) {
                            $finalRequest .= '&' . $key . '=' . urlencode($value);
                        }
                        if (strlen($finalRequest) > 0) {
                            $finalRequest[0] = '?';
                        }
						
$date=date("Y-m-d"); 
$name = substr($_REQUEST['name'], 0, 15);  // returns "abcde"
if($_REQUEST['type']=="INDIA TAMIL"){ 
	$price=$_REQUEST['price']*3.75;
}
elseif($_REQUEST['type']=="INDIA ENGLISH"){ 
	$price=$_REQUEST['price']*3.5;
}
else{
	$price=$_REQUEST['price'];
}
?>
<style>
.vertical-text {
	transform: rotate(90deg);
	transform-origin: left top 0;
}
</style>
<div style="width: 4.3cm; height: 2cm; border: 1px black solid;">
	<img src="../images/logo1.png" alt="Barcode Image" style="position: absolute; top: 10.5mm; left: 0.3cm; width: 0.8cm;"/>
	<p style="text-align: left; margin-top: 0mm; margin-left: 2mm; font-size: 12px;"><strong>P</strong>oobalasingham <strong>B</strong>ook <strong>D</strong>epot</p>	
	<p style="position: absolute; top: 0.4cm; font-size: 11px; text-align: left; left:0.3cm;"><?php echo $name; ?></div>
	<img src="image.php<?php echo $finalRequest; ?>" alt="Barcode Image" style="width: 2.8cm; position: absolute; top: 1.1cm; left: 1.5cm;"/>
	<div style="position: absolute; top: 0.7cm; left: 2.9cm; font-size: 12px; z-index:100;"><strong>Rs. <?php echo $price; ?></strong></div>
	<div style="position: absolute; top: 18.5mm; left: 0.5cm; font-size: 11px; z-index:100;"><?php echo $date; ?></div>
</div>
    </body>
</html>
