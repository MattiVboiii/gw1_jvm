<?php
include 'admin/partials/header.inc.php';
require_once 'system/db.inc.php';

$clubs = getClubs();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "admin/partials/head.inc.php" ?>
    <title>Admin - Clubs</title>
    <link rel="stylesheet" href="/admin/css/clubs.css">
    <script type="module" src="/admin/js/club-modals.js" defer></script>
</head>

<body>
    <?php renderHeader(NAV::CLUBS) ?>
    <main>
        <div class="card">
            <div class="card-header">
                <h1 class="card-title fs-3">Club List</h1>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-hover ">
                                <thead>
                                    <tr class="fw-bold fs-5">
                                        <th scope="col">#</th>
                                        <th scope="col">Logo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Province</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($clubs as $club): ?>
                                        <tr>
                                            <th class="fw-bold" scope="row"><?= $club['id'] ?></th>
                                            <td>
                                                <img src="<?= $club['logo_url'] ?>" alt="logo <?= $club['name'] ?>">
                                            </td>
                                            <td><?= $club['name'] ?></td>
                                            <td><?= $club['province'] ?></td>
                                            <td>
                                                <?= $club['zip'] . ' ' . $club['city'] ?><br>
                                                <?= $club['street'] . ' ' . $club['address'] ?>
                                            </td>
                                            <td>
                                                <span type="button" class="btn badge rounded-pill"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-club-description"
                                                    data-club-name="<?= $club['name'] ?>">・・・</span>
                                                <p hidden><?= $club['description'] ?></p>
                                            </td>
                                            <td>
                                                <a href="/frontend/pages/detail.php?id=<?= $club['id'] ?>" target="_blank" class="btn btn-secondary btn-sm">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
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
    </main>

</body>

</html>