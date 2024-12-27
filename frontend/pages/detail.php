<?php
require_once 'system/db.inc.php';
$id = (int)@$_GET['id'];
function getClubInfo(int $id): array|bool
{ 
  
    $sql = "SELECT * FROM clubs
    WHERE clubs.id = :id;";

    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute([
        ":id" => $id
    ]);
   
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getClubVoorzitter(int $id): array|bool
{ 
  global $voorzitter;
    $sql = "SELECT * FROM baseball.clubs
left join management
on clubs.id = management.club_id
left join management_roles
on management_role_id = management_roles.id
where clubs.id = $id
AND management_roles.role_name = 'secretaris Generaal';";

    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute();
   
    return $voorzitter = $stmt->fetch(PDO::FETCH_ASSOC);
}

function getClubSecretarisGeneraal(int $id): array|bool
{ 
  
    $sql = "SELECT * FROM baseball.clubs
left join management
on clubs.id = management.club_id
left join management_roles
on management_role_id = management_roles.id
where clubs.id = $id
AND management_roles.role_name = 'Voorzitter';";

    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute();
   
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function getClubPenningMeester(int $id): array|bool
{ 
  
    $sql = "SELECT * FROM baseball.clubs
left join management
on clubs.id = management.club_id
left join management_roles
on management_role_id = management_roles.id
where clubs.id = $id
AND management_roles.role_name = 'penningmeester';";

    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute();
   
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/frontend/css/detail.css">
</head>

<body>
    <?php include('frontend/partials/header.inc.php') ?>
   

   
    <main>
        <h1><?= getClubInfo($id)['name']?></h1>
        <div>
            <div>
                <img src="<?= getClubInfo($id)['logo_url']?>">
            </div>
            <!-- <div>
                <img src="https://picsum.photos/id/237/200/300" alt="sfeerfoto">
                sfeerfoto
            </div> -->
        </div>
        <div>
        <div>
            <h2>gegevens van de club</h2><br>
            <ul>
                <li>
                    <h3>Provincie</h3>
                    <p><?= getClubInfo($id)['province']?></p>
                </li>
                <li>
                    <h3>Gemeente</h3>
                    <p>postcode <br><?= getClubInfo($id)['zip']?> <?= getClubInfo($id)['city']?></p>
                </li>
                <li>
                    <h3>Adres (Straat + Huisnummer)</h3>
                    <p><?= getClubInfo($id)['street']?> <?= getClubInfo($id)['address']?><?= getClubInfo($id)['bus']?></p>
                </li>
            </ul>
        </div>

        <div>
        <ul>
            <h2>het bestuur</h2>
            <li>
                <h3>Voorzitter</h3>
                <p><?= !isset(getClubVoorzitter($id)['firstname']) 
                        ? "no info given" 
                        : getClubVoorzitter($id)['firstname']; ?> <?= !isset(getClubVoorzitter($id)['lastname']) 
                        ? "" 
                        : getClubVoorzitter($id)['lastname']; ?></p></p>
            </li>
            <li>
                <h3>Secretaris generaal</h3>
                <p><?= !isset(getClubSecretarisGeneraal($id)['firstname']) 
                        ? "no info given" 
                        : getClubSecretarisGeneraal($id)['firstname']; ?> <?= !isset(getClubSecretarisGeneraal($id)['lastname']) 
                        ? "" 
                        : getClubSecretarisGeneraal($id)['lastname']; ?></p>
            </li>
            <li>
                <h3>penningMeester</h3>
                <p> 
                    <?= !isset(getClubPenningMeester($id)['firstname']) 
                        ? "no info given" 
                        : getClubPenningMeester($id)['firstname']; ?> 
                        <?= !isset(getClubPenningMeester($id)['lastname']) 
                        ? "" 
                        : getClubPenningMeester($id)['lastname']; ?>
                </p>
            </li>
            <li>
                <h3>Hoofdcoach</h3>
                <p>ne coach</p>
            </li>
            <li>
                <h3>Hulpcoach</h3>
                <p>nog nen coach</p>
            </li>
            <li>
                <h3>andere</h3>
                <p>belangrijke persoon maar geen idee in welke functie</p>
            </li>
        </ul>
        </div>
        </div>
        <div>
            <div>
                <h2>we want you to support our teams!</h2>
                <ul>
                    <li>eerste wedstrijd</li>
                    <li>tweede wedstrijd</li>
                    <li>derde wedstrijd</li>
                </ul>
            </div>
            <div>
            <h2>we want you to have fun at our upcomming events</h2>
                <ul>
                    
                    <li>eerste evenement</li>
                    <li> tweede evenement</li>
                    <li>derde evenement</li>
                </ul>
            </div>
        </div>
    <div>
<form action="post">
    <label for="surname">Surname *</label><br>
    <input type="text" id="surname" name="surname" placeholder="please insert Surname"><br><br>
    <label for="firstname">Firstname*</label><br>
    <input type="text" id="firstname" name="firstname" placeholder="please insert firstname"><br><br>
    <label for="email">Email*</label><br>
    <input type="text" id="email" name="email" placeholder="please insert your email adress"><br><br>
    <label for="phone">Telefoon</label><br>
    <input type="text" id="phone" name="phone" placeholder="please insert your phonenumber"><br><br>
</form>
</div>
    </main>
</body>

</html>