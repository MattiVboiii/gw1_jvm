<?php
include 'admin/partials/header.inc.php';
require_once 'system/db.inc.php';

$id = (int)($_POST['id'] ?? 0);
$id = 1;
$club = getClub($id);

if (!$club) {
    // redirect with error notice
    print "could not find club with id: $id";
    exit;
}

$logoURL = $_POST['inputLogoUrl'] /*?? $club['logo_url']*/;
$name = $_POST['inputName'] /*?? $club['name']*/;
$description = $_POST['inputDescription'] ?? $club['description'];
$province = $_POST['inputProvince'] ?? $club['province'];
$city = $_POST['inputCity'] ?? $club['city'];
$zip = $_POST['inputZip'] ?? $club['zip'];
$street = $_POST['inputStreet'] ?? $club['street'];
$address = $_POST['inputAddress'] ?? $club['address'];
$bus = $_POST['inputBus'] ?? $club['bus'];
$longitude = toFloat($_POST['inputLongitude'] ?? $club['longitude']);
$latitude = toFloat($_POST['inputLatitude'] ?? $club['latitude']);
$errors = [];

if (isset($_POST['submit'])) {
    $isAlphaNumeric = fn($input) => preg_match('/[A-Z0-9 ]/i', $input);
    $isAlpha = fn($input) => preg_match('/[A-Z \-]/i', $input);

    if (!$logoURL) $errors[] = 'Logo URL is required';
    elseif (strlen($logoURL) > 255) $errors[] = 'Logo URL has a maximum length of 255 characters';

    if (!$name) $errors[] = 'Name is required';
    elseif (strlen($name) > 255) $errors[] = 'Name has a maximum length of 255 characters';
    elseif (!$isAlpha($name)) $errors[] = 'Name can not contain numbers or special characters (except -)';

    if (!$province) $errors[] = 'Province is required';
    elseif (strlen($province) > 45) $errors[] = 'Province has a maximum length of 45 characters';
    elseif (!$isAlpha($province)) $errors[] = 'Province can not contain numbers or special characters (except -)';

    if (!$zip) $errors[] = 'Zip is required';
    elseif (strlen($zip) > 20) $errors[] = 'Zip has a maximum length of 20 characters';
    elseif (!$isAlphaNumeric($zip)) $errors[] = 'Zip must be alphanumeric';

    if (!$street) $errors[] = 'Street is required';
    elseif (strlen($street) > 45) $errors[] = 'Street has a maximum length of 45 characters';
    elseif (!$isAlphaNumeric($street)) $errors[] = 'Street must be alphanumeric';

    if (!$address) $errors[] = 'Address is required';
    elseif (strlen($address) > 20) $errors[] = 'Address has a maximum length of 20 characters';
    elseif (!$isAlpha($address)) $errors[] = 'Address must be alphanumeric';

    if (strlen($bus) > 20) $errors[] = 'Bus has a maximum length of 20 characters';
    elseif (!$isAlphaNumeric($bus)) $errors[] = 'Bus must be alphanumeric';

    // arbitrary high length to not inhibit normal users, but still inhibit malicious ones.
    if (strlen($description) > 4000) $errors[] = 'Name has a maximum length of 4000 characters';

    if (!$latitude) $errors[] = 'Latitude is required.';
    elseif (abs($latitude) > 90) $errors[] = 'Latitude must be between -90° en 90°.';

    if (!$longitude) $errors[] = 'Longitude is required.';
    if (abs($longitude) > 180) $errors[] = 'Longitude must be between -180° en 180°.';
}

function toFloat(string|float $val): float
{
    if (is_float($val)) return $val;
    return (float)str_replace(',', '.', $val);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require 'admin/partials/head.inc.php' ?>
    <title>Admin - Clubs</title>
</head>

<body>
    <?php renderHeader(NAV::CLUBS) ?>
    <main>
        <div class="card">
            <div class="card-header">
                <h1 class="card-title fs-3"><?= $club['name'] ?></h1>
            </div>
            <div class="card-body">
                <?php if ($errors): ?>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-start">
                            <h3 class="card-title fs-5">Errors</h3>
                            <span class="badge text-bg-danger rounded-pill"><?= count($errors) ?></span>
                        </div>
                        <div class="card-body">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li>
                                        <?= $error ?>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                <?php endif ?>

                <form method="post">
                    <fieldset class="mb-3">
                        <legend class="mb-3">Club info</legend>
                        <div class="form-floating mb-3">
                            <input type="url" class="form-control" name="inputLogoUrl" id="inputLogoUrl" placeholder="https://..." value="<?= $logoURL ?>">
                            <label for="inputLogoUrl" class="form-label">Logo URL</label>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" class="form-control" name="inputName" id="inputName" placeholder="name..." value="<?= $name ?>">
                            <label for="inputName" class="form-label">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a club description here" id="inputDescription"><?= $description ?></textarea>
                            <label for="inputDescription">Description</label>
                        </div>
                    </fieldset>
                    <fieldset class="mb-3">
                        <legend class="mb-3">Club Location</legend>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="inputProvince" id="inputProvince" placeholder="province..." value="<?= $province ?>">
                            <label for="inputProvince" class="form-label">Province</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="inputCity" id="inputCity" placeholder="city..." value="<?= $city ?>">
                            <label for="inputCity" class="form-label">City</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="inputZip" id="inputZip" placeholder="zip..." value="<?= $zip ?>">
                            <label for="inputZip" class="form-label">zip</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="inputStreet" id="inputStreet" placeholder="street..." value="<?= $street ?>">
                            <label for="inputStreet" class="form-label">Street</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="address..." value="<?= $address ?>">
                            <label for="inputAddress" class="form-label">address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="inputBus" id="inputBus" placeholder="bus..." value="<?= $bus ?>">
                            <label for="inputBus" class="form-label">Bus</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="inputLatitude" id="inputLatitude" placeholder="latitude..." value="<?= $latitude ?>">
                            <label for="inputLatitude" class="form-label">Latitude</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="inputLongitude" id="inputLongitude" placeholder="Longitude..." value="<?= $longitude ?>">
                            <label for="inputLongitude" class="form-label">Longitude</label>
                        </div>
                    </fieldset>



                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>


    </main>

</body>

</html>