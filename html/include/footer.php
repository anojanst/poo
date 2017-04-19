


                    <?php
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
