<?php
include 'backend/partials/header.inc.php';
require_once 'system/db.inc.php';

$clubs = getClubs();

if (isset($_POST['submitClubDeletion'], $_POST['inputDeletionClubId'])) {
    $deletionId = (int)$_POST['inputDeletionClubId'];
    $deletionClubName = $_POST['inputDeletionClubName'] ?? '';

    $deletionCount = $success = deleteClub($deletionId);

    // every option redirect because this form is too dangerous to risk re-submission;
    if ($deletionCount > 1) {
        redirectWithDangerAlert("/admin/clubs", "Multiple deletions were made.<br> - This should never have happened.<br> - Please contact support.<br> - $deletionCount deletions were made.");
    } elseif ($success) {
        redirectWithSuccessAlert("/admin/clubs", "Deleted club #$deletionId: $deletionClubName");
    } elseif ($deletionCount === 0) {
        redirectWithWarningAlert("/admin/clubs", 'No deletions were made.<br> - Club might already be deleted.');
    } else {
        redirectWithDangerAlert("/admin/clubs", "Something went critically wrong.<br>#$deletionId: $deletionClubName<br>was not deleted.");
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "backend/partials/head.inc.php" ?>
    <title>Admin - Clubs</title>
    <link rel="stylesheet" href="/backend/css/clubs.css">
    <script type="module" src="/backend/js/club-modals.js" defer></script>
</head>

<body>
    <?php renderHeader(NAV::CLUBS) ?>
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="card-title fs-3">Club List</h1>
                    <a href="/admin/clubs/create" class="btn btn-success">Create Club</a>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr class="fw-bold fs-5">
                                            <th scope="col"><span class="text-subtle">#</span></th>
                                            <th scope="col">Logo</th>
                                            <th scope="col">Name</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Province</th>
                                            <th scope="col" class="d-none d-sm-table-cell">Address</th>
                                            <th scope="col" class="d-none d-md-table-cell">Description</th>
                                            <th scope="col" class="fit"><span class="d-none d-md-inline">Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clubs as $club): ?>
                                            <tr>
                                                <th class="fw-bold" scope="row"><span class="text-subtle"><?= $club['id'] ?></span></th>
                                                <td>
                                                    <img src="<?= $club['logo_url'] ?>" alt="logo <?= $club['name'] ?>">
                                                </td>
                                                <td>
                                                    <?= $club['name'] ?>
                                                </td>
                                                <td class="d-none d-lg-table-cell">
                                                    <?= $club['province'] ?>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <span class="d-lg-none"><?= $club['province'] ?></span><br class="d-lg-none">
                                                    <?= $club['zip'] . ' ' . $club['city'] ?><br>
                                                    <?= $club['street'] . ' ' . $club['address'] ?>
                                                </td>
                                                <td class="d-none d-md-table-cell">
                                                    <span type="button" class="btn badge rounded-pill"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-club-description"
                                                        data-club-name="<?= $club['name'] ?>">・・・</span>
                                                    <p hidden><?= $club['description'] ?></p>
                                                </td>
                                                <td class="actions fit">
                                                    <div class="no-wrap d-none d-md-block">
                                                        <a href="/club/<?= $club['id'] ?>" target="_blank" class="btn btn-outline-secondary bg-secondary-subtle btn-sm">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a href="/admin/clubs/edit/<?= $club['id'] ?>" class="btn btn-outline-primary bg-primary-subtle btn-sm">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <button class="btn btn-outline-danger bg-danger-subtle btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-club-deletion"
                                                            data-club-id="<?= $club['id'] ?>"
                                                            data-club-name="<?= $club['name'] ?>">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </button>
                                                    </div>
                                                    <div class="btn-group dropstart d-md-none">
                                                        <span type="button" class="dropdown-toggle fs-4 pe-1 ps-2 text-subtle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </span>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="/club/<?= $club['id'] ?>" target="_blank">
                                                                    <i class="fa-solid fa-eye text-subtle"></i>
                                                                    Preview
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="/admin/club/edit/<?= $club['id'] ?>">
                                                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <span class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal-club-deletion"
                                                                    data-club-id="<?= $club['id'] ?>"
                                                                    data-club-name="<?= $club['name'] ?>">
                                                                    <i class="fa-regular fa-trash-can text-danger"></i>
                                                                    Delete
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" role="status" aria-live="polite">Showing 1 to <?= count($clubs) ?> of <?= count($clubs) ?> entries</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-club-description" tabindex="-1" aria-labelledby="club-description-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="club-description-label">Description: ...</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-club-deletion" tabindex="-1" aria-labelledby="club-deletion-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-danger-subtle text-danger-emphasis border-danger-subtle">
                        <div class="modal-header border-danger-subtle">
                            <h1 class="modal-title fs-5 d-flex gap-3 align-items-center fw-bold" id="club-deletion-label">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                DELETING: ...
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body ">
                            <p></p>
                        </div>
                        <div class="modal-footer border-danger-subtle">
                            <form method="post">
                                <input type="hidden" name="inputDeletionClubId" id="inputDeletionClubId">
                                <input type="hidden" name="inputDeletionClubName" id="inputDeletionClubName">
                                <button type="submit" class="btn btn-danger" name="submitClubDeletion">Confirm Deletion</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>