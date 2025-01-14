<?php

require_once 'backend/php_includes/upload.inc.php';

use \Site\Admin\Upload;
use \Site\Admin\MimeType;

print '<pre>';
print_r($_SERVER);
print '</pre>';

print '<pre>';
print_r($_FILES);
print '</pre>';


$upload = (new Upload('file'))
    ->setAllowedType(MimeType::IMAGE_PNG);

if ($upload->hasFile()) {
    if ($upload->hasError()) {
        print "Error";
        print $upload->getErrorMsg();
    } else {
        print 'File Upload...';
        var_dump($upload->move('/uploads'));
    }
}

print '<pre>';
var_dump($upload);
print '</pre>';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form enctype="multipart/form-data" method="post">
        <div>
            <label for="file">Select a file:</label>
            <input type="file" id="file" name="file" />
        </div>
        <div>
            <button type="submit" name="submit">Upload</button>
        </div>
    </form>
    <img src="<?= $upload->getFinalDest() ?>" alt="">
</body>

</html>