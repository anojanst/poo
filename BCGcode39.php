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
    <body>

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
registerImageKey('text', stripslashes("anojan"));

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
                    ?>
<img src="image.php<?php echo $finalRequest; ?>" alt="Barcode Image" />

        </form>

    </body>
</html>
