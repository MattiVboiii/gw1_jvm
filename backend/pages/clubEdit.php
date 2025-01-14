<?php

use Site\Admin\MimeType;
use Site\Admin\Upload;

include 'backend/partials/header.inc.php';
require_once 'system/db.inc.php';
require_once 'backend/php_includes/upload.inc.php';

$id = (int)($_GET['id'] ?? 0);
$club = getClub($id);

if (!$club) {
    redirectWithDangerAlert('/admin/clubs', "could not find club with id: $id");
}


$logoUpload = (new Upload('inputLogoUpload'))
    ->setAllowedType(MimeType::IMAGE_PNG)
    ->setAllowedType(MimeType::IMAGE_JPEG)
    ->setAllowedType(MimeType::IMAGE_WEBP);
$logoURL = $_POST['inputLogoUrl'] ?? $club['logo_url'];
$name = $_POST['inputName'] ?? $club['name'];
$description = $_POST['inputDescription'] ?? $club['description'];
$province = $_POST['inputProvince'] ?? $club['province'];
$city = $_POST['inputCity'] ?? $club['city'];
$zip = $_POST['inputZip'] ?? $club['zip'];
$street = $_POST['inputStreet'] ?? $club['street'];
$address = $_POST['inputAddress'] ?? $club['address'];
$bus = $_POST['inputBus'] ?? $club['bus'];
$longitude = new TryToFloat($_POST['inputLongitude'] ?? $club['longitude']);
$latitude = new TryToFloat($_POST['inputLatitude'] ?? $club['latitude']);
$errors = [];
$showUploadNotification = false;

$isAlphaNumeric = fn($input) => preg_match('/^[A-Z0-9 ]+$/i', $input);
$isAlpha = fn($input) => preg_match('/^[A-Z \-]+$/i', $input);
$isTel = fn($input) => preg_match('/^\\+?[1-9][0-9]{7,14}$/', $input);

if (isset($_POST['submit'])) {
    if (!$name) $errors['name'] = 'Name is required';
    elseif (strlen($name) > 255) $errors['name'] = 'Name has a maximum length of 255 characters';
    elseif (!$isAlpha($name)) $errors['name'] = 'Name can not contain numbers or special characters (except -)';

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
        $success = updateClub(
            $id,
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
            redirectWithSuccessAlert('/admin/clubs', "Updated club #$id : $name");
        } elseif ($success === 0) {
            addWarningAlert('No updates were made.<br> - Club might already be updated. (most likely)<br> - Club might no longer exist.');
        } else {
            addDangerAlert('Something went critically wrong, no updates were made.');
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



$clubManagement = getClubManagement($id);
$managementRoles = getManagementRoles();

$idM = $_POST['inputIdM'] ?? null;
$roleIdM = $_POST['inputRoleIdM'] ?? null;
$roleDescriptionM = $_POST['inputRoleDescriptionM'] ?? null;
$firstNameM = $_POST['inputFirstNameM'] ?? null;
$lastNameM = $_POST['inputLastNameM'] ?? null;
$emailM = $_POST['inputEmailM'] ?? null;
$telM = $_POST['inputTelM'] ?? null;
$showOnClubM = isset($_POST['inputShowOnClubM']);
$submitM = isset($_POST['submitM']);

$makeShowVal = fn($id) => fn($post, $db) => ($submitM && ($idM == $id)) ? $post : $db;

if ($submitM) {
    if (!$roleIdM) $errors['roleIdM'] = 'Role is required.';
    elseif (!in_array($roleIdM, array_keys($managementRoles))) $errors['roleIdM'] = 'Invalid role Selected.';

    if ($roleDescriptionM) {
        if (strlen($roleDescriptionM) > 45) $errors['roleDescriptionM'] = 'Role description too long. (max: 45)';
    }

    if (!$firstNameM) $errors['firstNameM'] = 'First name is required';
    elseif (strlen($firstNameM) > 45) $errors['firstNameM'] = 'First name has a maximum length of 45 characters';
    elseif (!$isAlpha($firstNameM)) $errors['firstNameM'] = 'First name can not contain numbers or special characters (except -)';

    if (!$lastNameM) $errors['lastNameM'] = 'Last name is required';
    elseif (strlen($lastNameM) > 45) $errors['lastNameM'] = 'Last name has a maximum length of 45 characters';
    elseif (!$isAlpha($lastNameM)) $errors['lastNameM'] = 'Last name can not contain numbers or special characters (except -)';

    if ($emailM) {
        if (strlen($emailM) > 254) $errors['emailM'] = 'E-mail too long. (max: 254)';
        elseif (!filter_var($emailM, FILTER_VALIDATE_EMAIL)) $errors['emailM'] = 'Email is not valid.';
    }

    if ($telM) {
        if (!$isTel($telM)) $errors['telM'] = "Tel/gsm is invalid. Include the country code (ex: +32) and don't use spaces.";
    }

    if ($errors) {
        addDangerAlert('Some management fields are incorrect.');
    } else {
        $success = updateManagement(
            (int)$idM,
            (int)$roleIdM,
            $roleDescriptionM,
            $firstNameM,
            $lastNameM,
            $emailM,
            $telM,
            (int)$showOnClubM
        );
        if ($success) {
            redirectWithSuccessAlert("/admin/clubs/edit/$id", "Updated role #$idM : {$managementRoles[$roleIdM]} - $firstNameM $lastNameM");
        } elseif ($success === 0) {
            addWarningAlert('No updates were made.<br> - Role might already be updated. (most likely)<br> - Role might no longer exist.');
        } else {
            addDangerAlert('Something went critically wrong, no updates were made.');
        }
    }
}

$idMC = $_POST['inputIdMC'] ?? null;
$roleIdMC = $_POST['inputRoleIdMC'] ?? null;
$roleDescriptionMC = $_POST['inputRoleDescriptionMC'] ?? null;
$firstNameMC = $_POST['inputFirstNameMC'] ?? null;
$lastNameMC = $_POST['inputLastNameMC'] ?? null;
$emailMC = $_POST['inputEmailMC'] ?? null;
$telMC = $_POST['inputTelMC'] ?? null;
$showOnClubMC = isset($_POST['inputShowOnClubMC']);
$submitMC = isset($_POST['submitMC']);

if ($submitMC) {
    if (!$roleIdMC) $errors['roleIdMC'] = 'Role is required.';
    elseif (!in_array($roleIdMC, array_keys($managementRoles))) $errors['roleIdMC'] = 'Invalid role Selected.';

    if ($roleDescriptionMC) {
        if (strlen($roleDescriptionMC) > 45) $errors['roleDescriptionMC'] = 'Role description too long. (max: 45)';
    }

    if (!$firstNameMC) $errors['firstNameMC'] = 'First name is required';
    elseif (strlen($firstNameMC) > 45) $errors['firstNameMC'] = 'First name has a maximum length of 45 characters';
    elseif (!$isAlpha($firstNameMC)) $errors['firstNameMC'] = 'First name can not contain numbers or special characters (except -)';

    if (!$lastNameMC) $errors['lastNameMC'] = 'Last name is required';
    elseif (strlen($lastNameMC) > 45) $errors['lastNameMC'] = 'Last name has a maximum length of 45 characters';
    elseif (!$isAlpha($lastNameMC)) $errors['lastNameMC'] = 'Last name can not contain numbers or special characters (except -)';

    if ($emailMC) {
        if (strlen($emailMC) > 254) $errors['emailMC'] = 'E-mail too long. (max: 254)';
        elseif (!filter_var($emailMC, FILTER_VALIDATE_EMAIL)) $errors['emailMC'] = 'Email is not valid.';
    }

    if ($telMC) {
        if (!$isTel($telMC)) $errors['telMC'] = "Tel/gsm is invalid. Include the country code (ex: +32) and don't use spaces.";
    }

    if ($errors) {
        addDangerAlert('Some fields are incorrect in the "create new management position" form.');
    } else {
        $idMC = $success = createManagement(
            (int)$id,
            (int)$roleIdMC,
            $roleDescriptionMC,
            $firstNameMC,
            $lastNameMC,
            $emailMC,
            $telMC,
            (int)$showOnClubMC
        );
        if ($success) {
            redirectWithSuccessAlert("/admin/clubs/edit/$id", "created role #$idMC : {$managementRoles[$roleIdMC]} - $firstNameMC $lastNameMC");
        } else {
            addDangerAlert('Something went critically wrong, no new role was created.');
        }
    }
}

if (isset($_POST['submitRoleDeletion'], $_POST['inputRoleDeletionId'])) {
    $roleNameD = $_POST['inputRoleNameD'] ?? '';
    $firstNameD = $_POST['inputFirstNameD'] ?? '';
    $lastNameD = $_POST['inputLastNameD'] ?? '';
    $idD = $_POST['inputRoleDeletionId'];

    $fullName = "#$idD: $roleNameD - $firstNameD $lastNameD";

    $deletionCount = $success = deleteManagement((int)$_POST['inputRoleDeletionId']);

    // every option redirect because this form is too dangerous to risk re-submission;
    if ($deletionCount > 1) {
        redirectWithDangerAlert("/admin/clubs/edit/$id", "Multiple deletions were made.<br> - This should never have happened.<br> - Please contact support.<br> - $deletionCount deletions were made.");
    } elseif ($success) {
        redirectWithSuccessAlert("/admin/clubs/edit/$id", "Deleted role $fullName");
    } elseif ($deletionCount === 0) {
        redirectWithWarningAlert("/admin/clubs/edit/$id", 'No deletions were made.<br> - Role might already be deleted.');
    } else {
        redirectWithDangerAlert("/admin/clubs/edit/$id", "Something went critically wrong.<br>$fullName<br>was not deleted.");
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
    <title>Admin - Club:<?= $club['name'] ?></title>
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
                    <h1 class="card-title fs-3"><?= $club['name'] ?></h1>
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
                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="card-title fs-3">Management</h1>
                    <button type="button" id="btn-showRoleCreate" class="btn btn-success">Create New</button>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    <div class="accordion d-none" id="managementCreateAccordion">
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button <?= $submitMC ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-create" aria-expanded="<?= $submitMC ? 'true' : 'false' ?>" aria-controls="collapse-create">
                                    Create New Management Position
                                </button>
                            </h3>
                        </div>
                        <div id="collapse-create" class="accordion-collapse collapse <?= $submitMC ? 'show' : '' ?>" data-bs-parent="#managementCreateAccordion">
                            <div class="accordion-body bg-body-tertiary">
                                <form method="post" class="container-fluid">
                                    <?php $getValidationClass = $makeGetValidationClass($submitMC) ?>
                                    <fieldset class="row g-3">
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <select class="form-select <?= $getValidationClass('roleIdMC') ?>" name="inputRoleIdMC" id="inputRoleIdMC">
                                                    <?php foreach ($managementRoles as $id => $name): ?>
                                                        <!-- Weird fix to avoid a vite build error: -->
                                                        <!-- Unable to parse HTML; parse5 error code unexpected-character-in-attribute-name -->
                                                        <?php $selected = $roleIdMC == $id ? 'selected' : '' ?>
                                                        <?= "<option $selected value='$id'>$name</option>" ?>
                                                    <?php endforeach ?>
                                                </select>
                                                <label for="inputRoleIdMC">Role</label>
                                                <div class="invalid-feedback">
                                                    <?= $errors['roleIdMC'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <!-- Weird fix to avoid a vite build error: -->
                                                <!-- Unable to parse HTML; parse5 error code unexpected-character-in-attribute-name -->
                                                <?php $disabled = $roleIdMC != 7 ? 'disabled' : '' ?>
                                                <?php $validation = $getValidationClass('roleDescriptionMC') ?>
                                                <?= "<input type='text' $disabled class='form-control $validation' name='inputRoleDescriptionMC' id='inputRoleDescriptionMC' placeholder='role...' value='$roleDescriptionMC'>" ?>
                                                <label for="inputRoleDescriptionMC" class="form-label">Role Description</label>
                                                <div class="invalid-feedback">
                                                    <?= $errors['roleDescriptionMC'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control <?= $getValidationClass('firstNameMC') ?>" name="inputFirstNameMC" id="inputFirstNameMC" placeholder="first name..." value="<?= $firstNameMC ?>">
                                                <label for="inputFirstNameMC" class="form-label">First name</label>
                                                <div class="invalid-feedback">
                                                    <?= $errors['firstNameMC'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control <?= $getValidationClass('lastNameMC') ?>" name="inputLastNameMC" id="inputLastNameMC" placeholder="last name..." value="<?= $lastNameMC ?>">
                                                <label for="inputLastNameMC" class="form-label">Last name</label>
                                                <div class="invalid-feedback">
                                                    <?= $errors['lastNameMC'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-floating">
                                                <input type="email" class="form-control <?= $getValidationClass('emailMC') ?>" name="inputEmailMC" id="inputEmailMC" placeholder="email..." value="<?= $emailMC ?>">
                                                <label for="inputEmailMC" class="form-label">E-mail</label>
                                                <div class="invalid-feedback">
                                                    <?= $errors['emailMC'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-floating">
                                                <input type="tel" class="form-control <?= $getValidationClass('telMC') ?>" name="inputTelMC" id="inputTelMC" placeholder="tel..." value="<?= $telMC ?>">
                                                <label for="inputTelMC" class="form-label">Telephone / Gsm</label>
                                                <div class="invalid-feedback">
                                                    <?= $errors['telMC'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-check form-switch">
                                                <!-- Weird fix to avoid a vite build error: -->
                                                <!-- Unable to parse HTML; parse5 error code unexpected-character-in-attribute-name -->
                                                <?php $validation = $getValidationClass('showOnClubMC') ?>
                                                <?php $checked = $showOnClubMC == 1 ? 'checked' : '' ?>
                                                <?= "<input class='form-check-input $validation' type='checkbox' role='switch' name='inputShowOnClubMC' id='inputShowOnClubMC' $checked >" ?>
                                                <label class="form-check-label" for="inputShowOnClubMC">Show role in club section</label>
                                                <div class="invalid-feedback">
                                                    <?= $errors['showOnClubMC'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 d-flex justify-content-end gap-3">
                                            <button type="submit" name="submitMC" class="btn btn-success">Create</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="accordion" id="managementAccordion">

                        <?php foreach ($clubManagement as $position): ?>
                            <?php $showVal = $makeShowVal($position['id']) ?>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button <?= $idM == $position['id'] ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $position['id'] ?>" aria-expanded="<?= $idM == $position['id'] ? 'true' : 'false' ?>" aria-controls="collapse<?= $position['id'] ?>">
                                        <?= $managementRoles[$position['management_role_id']] . ' - ' . $position['firstname'] . ' ' . $position['lastname']  ?>
                                    </button>
                                </h3>
                            </div>
                            <div id="collapse<?= $position['id'] ?>" class="accordion-collapse collapse <?= $idM == $position['id'] ? 'show' : '' ?>" data-bs-parent="#managementAccordion">
                                <div class="accordion-body bg-body-tertiary">
                                    <form method="post" class="container-fluid">
                                        <?php $getValidationClass = $makeGetValidationClass($submitM) ?>
                                        <fieldset class="row g-3">
                                            <input type="hidden" name="inputIdM" value="<?= $position['id'] ?>">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <!-- Weird fix to avoid a vite build error: -->
                                                    <!-- Unable to parse HTML; parse5 error code unexpected-character-in-attribute-name -->
                                                    <?php $validation = $getValidationClass('roleIdM') ?>
                                                    <?php $positionId = $position['id'] ?>
                                                    <?= "<select class='form-select $validation' name='inputRoleIdM' id='inputRoleIdM$positionId'>" ?>
                                                    <?php foreach ($managementRoles as $id => $name): ?>
                                                        <!-- Weird fix to avoid a vite build error: -->
                                                        <!-- Unable to parse HTML; parse5 error code unexpected-character-in-attribute-name -->
                                                        <?php $selected = $showVal($roleIdM, $position['management_role_id']) == $id ? 'selected' : '' ?>
                                                        <?= "<option $selected value='$id'>$name</option>" ?>
                                                    <?php endforeach ?>
                                                    </select>
                                                    <label for="inputRoleIdM">Role</label>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['roleIdM'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <!-- Weird fix to avoid a vite build error: -->
                                                    <!-- Unable to parse HTML; parse5 error code unexpected-character-in-attribute-name -->
                                                    <?php $disabled = $showVal($roleIdM, $position['management_role_id']) != 7 ? 'disabled' : '' ?>
                                                    <?php $validation = $getValidationClass('roleDescriptionM') ?>
                                                    <?php $positionId = $position['id'] ?>
                                                    <?php $value = $showVal($roleDescriptionM, $position['role_description']) ?>
                                                    <?= "<input type='text' $disabled class='form-control $validation' name='inputRoleDescriptionM' id='inputRoleDescriptionM$positionId' placeholder='role...' value='$value'>" ?>
                                                    <label for="inputRoleDescriptionM" class="form-label">Role Description</label>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['roleDescriptionM'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control <?= $getValidationClass('firstNameM') ?>" name="inputFirstNameM" id="inputFirstNameM<?= $position['id'] ?>" placeholder="first name..." value="<?= $showVal($firstNameM, $position['firstname']) ?>">
                                                    <label for="inputFirstNameM" class="form-label">First name</label>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['firstNameM'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control <?= $getValidationClass('lastNameM') ?>" name="inputLastNameM" id="inputLastNameM<?= $position['id'] ?>" placeholder="last name..." value="<?= $showVal($lastNameM, $position['lastname']) ?>">
                                                    <label for="inputLastNameM" class="form-label">Last name</label>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['lastNameM'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control <?= $getValidationClass('emailM') ?>" name="inputEmailM" id="inputEmailM<?= $position['id'] ?>" placeholder="email..." value="<?= $showVal($emailM, $position['email']) ?>">
                                                    <label for="inputEmailM" class="form-label">E-mail</label>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['emailM'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-floating">
                                                    <input type="tel" class="form-control <?= $getValidationClass('telM') ?>" name="inputTelM" id="inputTelM<?= $position['id'] ?>" placeholder="tel..." value="<?= $showVal($telM, $position['tel']) ?>">
                                                    <label for="inputTelM" class="form-label">Telephone / Gsm</label>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['telM'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-check form-switch">
                                                    <!-- Weird fix to avoid a vite build error: -->
                                                    <!-- Unable to parse HTML; parse5 error code unexpected-character-in-attribute-name -->
                                                    <?php $validation = $getValidationClass('showOnClubM') ?>
                                                    <?php $positionId = $position['id'] ?>
                                                    <?php $checked = $showVal($showOnClubM, $position['show_on_club']) == 1 ? 'checked' : '' ?>
                                                    <?= "<input class='form-check-input $validation' type='checkbox' role='switch' name='inputShowOnClubM' id='inputShowOnClubM$positionId' $checked >" ?>
                                                    <label class="form-check-label" for="inputShowOnClubM">Show role in club section</label>
                                                    <div class="invalid-feedback">
                                                        <?= $errors['showOnClubM'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 d-flex justify-content-end gap-3">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-management-deletion"
                                                    data-idM="<?= $position['id'] ?>"
                                                    data-role="<?= $managementRoles[$position['management_role_id']] ?>"
                                                    data-firstNameM="<?= $position['firstname'] ?>"
                                                    data-lastNameM="<?= $position['lastname'] ?>"><i class="fa-regular fa-trash-can"></i></button>
                                                <button type="submit" name="submitM" class="btn btn-primary">Update</button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-management-deletion" tabindex="-1" aria-labelledby="management-deletion-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-danger-subtle text-danger-emphasis border-danger-subtle">
                    <div class="modal-header border-danger-subtle">
                        <h1 class="modal-title fs-5 d-flex gap-3 align-items-center fw-bold" id="management-deletion-label">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            WARNING: Role Deletion
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ">
                        <p></p>
                    </div>
                    <div class="modal-footer border-danger-subtle">
                        <form method="post">
                            <input type="hidden" name="inputRoleDeletionId" id="inputRoleDeletionId">
                            <input type="hidden" name="inputRoleNameD" id="inputRoleNameD">
                            <input type="hidden" name="inputFirstNameD" id="inputFirstNameD">
                            <input type="hidden" name="inputLastNameD" id="inputLastNameD">
                            <button type="submit" class="btn btn-danger" name="submitRoleDeletion">Confirm Deletion</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>