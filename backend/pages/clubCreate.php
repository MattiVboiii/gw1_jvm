<?php

use Site\Admin\MimeType;
use Site\Admin\Upload;

include 'backend/partials/header.inc.php';
require_once 'system/db.inc.php';
require_once 'backend/php_includes/upload.inc.php';


$logoUpload = (new Upload('inputLogoUpload'))
    ->setAllowedType(MimeType::IMAGE_PNG)
    ->setAllowedType(MimeType::IMAGE_JPEG)
    ->setAllowedType(MimeType::IMAGE_WEBP);
$logoURL = $_POST['inputLogoUrl'] ?? null;
$name = $_POST['inputName'] ?? null;
$description = $_POST['inputDescription'] ?? null;
$province = $_POST['inputProvince'] ?? null;
$city = $_POST['inputCity'] ?? null;
$zip = $_POST['inputZip'] ?? null;
$street = $_POST['inputStreet'] ?? null;
$address = $_POST['inputAddress'] ?? null;
$bus = $_POST['inputBus'] ?? null;
$longitude = new TryToFloat($_POST['inputLongitude'] ?? '');
$latitude = new TryToFloat($_POST['inputLatitude'] ?? '');
$errors = [];
$showUploadNotification = false;

$isAlphaNumeric = fn($input) => preg_match('/^[A-Z0-9 ]+$/i', $input);
$isAlpha = fn($input) => preg_match('/^[A-Z \-]+$/i', $input);
$isTel = fn($input) => preg_match('/^\\+?[1-9][0-9]{7,14}$/', $input);

if (isset($_POST['submit'])) {
    if (!$name) $errors['name'] = 'Name is required';
    elseif (strlen($name) > 255) $errors['name'] = 'Name has a maximum length of 255 characters';
    elseif (!$isAlpha($name)) $errors['name'] = 'Name can not contain numbers or special characters (except -)';
    elseif (!isUniqClubName($name)) $errors['name'] = 'Name is no longer available.';

    if (!$province) $errors['province'] = 'Province is required';
    elseif (strlen($province) > 45) $errors['province'] = 'Province has a maximum length of 45 characters';
    elseif (!$isAlpha($province)) $errors['province'] = 'Province can not contain numbers or special characters (except -)';

    if (!$city) $errors['city'] = 'City is required';
    elseif (strlen($city) > 45) $errors['city'] = 'City has a maximum length of 45 characters';
    elseif (!$isAlpha($city)) $errors['city'] = 'City can not contain numbers or special characters (except -)';

    if (!$zip) $errors['zip'] = 'Zip is required';
    elseif (strlen($zip) > 20) $errors['zip'] = 'Zip has a maximum length of 20 characters';
    elseif (!$isAlphaNumeric($zip)) $errors['zip'] = 'Zip must be alphanumeric';

    if (!$street) $errors['street'] = 'Street is required';
    elseif (strlen($street) > 45) $errors['street'] = 'Street has a maximum length of 45 characters';
    elseif (!$isAlphaNumeric($street)) $errors['street'] = 'Street must be alphanumeric';

    if (!$address) $errors['address'] = 'Address is required';
    elseif (strlen($address) > 20) $errors['address'] = 'Address has a maximum length of 20 characters';
    elseif (!$isAlphaNumeric($address)) $errors['address'] = 'Address must be alphanumeric';

    if ($bus) {
        if (strlen($bus) > 20) $errors['bus'] = 'Bus has a maximum length of 20 characters';
        elseif (!$isAlphaNumeric($bus)) $errors['bus'] = 'Bus must be alphanumeric';
    }

    // arbitrary high length to not inhibit normal users, but still inhibit malicious ones.
    if (strlen($description) > 4000) $errors['description'] = 'Description has a maximum length of 4000 characters';

    if (!$latitude->input) $errors['latitude'] = 'Latitude is required.';
    elseif (!$latitude->isNum) $errors['latitude'] = 'Latitude must be a number';
    elseif (abs($latitude->val) > 90) $errors['latitude'] = 'Latitude must be between -90° en 90°.';

    if (!$longitude->input) $errors['longitude'] = 'Longitude is required.';
    elseif (!$longitude->isNum) $errors['longitude'] = 'Longitude must be a number';
    if (abs($longitude->val) > 180) $errors['longitude'] = 'Longitude must be between -180° en 180°.';

    if ($logoUpload->hasFile()) {
        if ($logoUpload->hasError()) {
            $errors['logoUpload'] = $logoUpload->getErrorMsg();
        } else {
            try {
                $uploadedFilePath = $logoUpload->move('/uploads');
                if (!$uploadedFilePath) $errors['logoUpload'] = 'Something went wrong with the file upload.';
                else {
                    $logoURL = $uploadedFilePath;
                    $showUploadNotification = true;
                }
            } catch (\Exception $e) {
                $errors['logoUpload'] = $e;
            }
        }
    }

    if (!$logoURL && empty($errors['logoUpload'])) $errors['logoUpload'] = 'Logo is required';

    if ($errors) {
        addDangerAlert('Some club fields are incorrect.');
    } else {
        $newId = $success = createClub(
            $name,
            $province,
            $zip,
            $city,
            $street,
            $address,
            $bus,
            $logoURL,
            $longitude->val,
            $latitude->val,
            $description
        );
        if ($success) {
            redirectWithSuccessAlert('/admin/clubs', "Created club #$newId : $name");
        } else {
            addDangerAlert('Something went critically wrong, no club was created.');
        }
    }

    if ($showUploadNotification) addSuccessAlert('Successfully Uploaded your image.');
}

class TryToFloat
{
    public bool $isNum;
    public string|float $input;
    public float $val;
    function __construct(string|float $val)
    {
        $this->input = $val;
        $val = is_string($val)
            ? str_replace(',', '.', $val)
            : $val;
        $this->isNum = is_numeric($val);
        $this->val = (float)$val;
    }
}

$makeGetValidationClass = function ($isSubmitted) use ($errors) {
    return function (string $errorKey) use ($errors, $isSubmitted) {
        if (!$isSubmitted) return;
        return isset($errors[$errorKey])
            ? 'is-invalid'
            : 'is-valid';
    };
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require 'backend/partials/head.inc.php' ?>
    <title>Admin - Clubs: create</title>
    <link rel="stylesheet" href="/backend/css/clubForm.css">
    <script defer type="module" src="/backend/js/clubEdit-modal.js"></script>
    <script type="module" src="/backend/js/clubEdit-roleCreate.js"></script>
</head>

<body>
    <?php renderHeader(NAV::CLUBS) ?>
    <main>
        <div class="container d-flex flex-column gap-5">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title fs-3">Create Club</h1>
                </div>
                <div class="card-body">

                    <form method="post" enctype="multipart/form-data" class="container-fluid">
                        <?php $getValidationClass = $makeGetValidationClass(isset($_POST['submit'])) ?>
                        <fieldset class="mb-3">
                            <div class="img-container img-thumbnail m-auto mb-3">
                                <img src="<?= $logoURL ?>" alt="Club logo" id="img-logo"
                                    onerror="this.onerror=null;this.src='/backend/images/default-logo.png'">
                            </div>
                            <legend class="mb-3">Club info</legend>
                            <div class="mb-3">
                                <?php $logoInputValue = 'Upload logo... (' . implode(', ', array_map(fn($t) => $t->name(), $logoUpload->getAllowedTypes())) . ')' ?>
                                <label for="inputLogoUpload" class="form-label visually-hidden">Upload logo... (.png/.jpeg/.webp) </label>
                                <div id="logoUploadHelp" class="form-text mb-1"><?= $logoInputValue ?></div>
                                <input class="form-control <?= $makeGetValidationClass(isset($errors['logoUpload']))('logoUpload') ?>" type="file" id="inputLogoUpload" name="inputLogoUpload" aria-describedby="logoUploadHelp" onchange="setfilename(this.value);">
                                <div class="invalid-feedback">
                                    <?= $errors['logoUpload'] ?>
                                </div>
                            </div>
                            <input type="hidden" name="inputLogoUrl" value="<?= $logoURL ?>">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control <?= $getValidationClass('name') ?>" name="inputName" id="inputName" placeholder="name..." value="<?= $name ?>">
                                <label for="inputName" class="form-label">Name</label>
                                <div class="invalid-feedback">
                                    <?= $errors['name'] ?>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control <?= $getValidationClass('description') ?>" placeholder="Leave a club description here" name="inputDescription" id="inputDescription"><?= $description ?></textarea>
                                <label for="inputDescription">Description</label>
                                <div class="invalid-feedback">
                                    <?= $errors['description'] ?>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="mb-3 row g-3">
                            <legend class="mb-0">Club Location</legend>
                            <div class="col-md-5 col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control <?= $getValidationClass('province') ?>" name="inputProvince" id="inputProvince" placeholder="province..." value="<?= $province ?>">
                                    <label for="inputProvince" class="form-label">Province</label>
                                    <div class="invalid-feedback">
                                        <?= $errors['province'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-7">
                                <div class="form-floating">
                                    <input type="text" class="form-control <?= $getValidationClass('city') ?>" name="inputCity" id="inputCity" placeholder="city..." value="<?= $city ?>">
                                    <label for="inputCity" class="form-label">City</label>
                                    <div class="invalid-feedback">
                                        <?= $errors['city'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-5">
                                <div class="form-floating">
                                    <input type="text" class="form-control <?= $getValidationClass('zip') ?>" name="inputZip" id="inputZip" placeholder="zip..." value="<?= $zip ?>">
                                    <label for="inputZip" class="form-label">zip</label>
                                    <div class="invalid-feedback">
                                        <?= $errors['zip'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control <?= $getValidationClass('street') ?>" name="inputStreet" id="inputStreet" placeholder="street..." value="<?= $street ?>">
                                    <label for="inputStreet" class="form-label">Street</label>
                                    <div class="invalid-feedback">
                                        <?= $errors['street'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control <?= $getValidationClass('address') ?>" name="inputAddress" id="inputAddress" placeholder="address..." value="<?= $address ?>">
                                    <label for="inputAddress" class="form-label">address</label>
                                    <div class="invalid-feedback">
                                        <?= $errors['address'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control <?= $getValidationClass('bus') ?>" name="inputBus" id="inputBus" placeholder="bus..." value="<?= $bus ?>">
                                    <label for="inputBus" class="form-label">Bus</label>
                                    <div class="invalid-feedback">
                                        <?= $errors['bus'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control <?= $getValidationClass('latitude') ?>" name="inputLatitude" id="inputLatitude" placeholder="latitude..." value="<?= $latitude->input ?>">
                                    <label for="inputLatitude" class="form-label">Latitude</label>
                                    <div class="invalid-feedback">
                                        <?= $errors['latitude'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control <?= $getValidationClass('longitude') ?>" name="inputLongitude" id="inputLongitude" placeholder="Longitude..." value="<?= $longitude->input ?>">
                                    <label for="inputLongitude" class="form-label">Longitude</label>
                                    <div class="invalid-feedback">
                                        <?= $errors['longitude'] ?>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="submit" class="btn btn-success">Create</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>