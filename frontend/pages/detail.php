<?php
require_once 'system/db.inc.php';
$id = (int)@$_GET['id'];
$matches = getFutureMatches($id);
$bestuur= getManagement($id);
$sfeerfoto=getSfeerFoto($id);
function getClubInfo(int $id): array|bool
{ 
  
    $sql = "SELECT * FROM clubs
    -- left join external_references on clubs.id = external_references.club_id
    -- left join reference_types on external_references.reference_type_id = reference_types.id 
    -- bovenstaande 2 rgels werken niet, name wordt dan main url
    WHERE clubs.id = :id;";

    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute([
        ":id" => $id
    ]);
   
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getClubUrl(int $id): array|bool
{ 
  
    $sql = "SELECT * FROM clubs
    left join external_references on clubs.id = external_references.club_id
    left join reference_types on external_references.reference_type_id = reference_types.id 
    WHERE clubs.id = :id;";

    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute([
        ":id" => $id
    ]);
   
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getFutureMatches(int $id): array|bool
{ 
  
    $sql = "SELECT clubs.id,clubs.name as clubname, team_1_id,team_2_name as opponent, date FROM baseball.matches
left join teams on team_1_id = teams.id
left join clubs on club_id
where date > NOW()
and team_1_id = :id
and clubs.id = :idc
order by date asc
limit 3";

    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute([
        ":id" => $id,
        ":idc" => $id,
    ]);
   
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getManagement($id){
    $sql = "SELECT role_name as role, CONCAT(firstname, ' ', lastname) as fullname  FROM baseball.management 
left join management_roles on management.management_role_id = management_roles.id
where club_id = :id
and  show_on_club = 1";
    
        $stmt = connectToDatabase()->prepare($sql);
        $stmt->execute([
            ":id" => $id,
        ]);
       
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSfeerFoto($id){
    $sql = "SELECT * FROM baseball.clubs
left join media on clubs.id = media.club_id
where show_on_club = 1
and club_id = :id
limit 1"; //weg te halen later
        
            $stmt = connectToDatabase()->prepare($sql);
            $stmt->execute([
                ":id" => $id,
            ]);
           
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


// print '<pre>';
// print_r(getSfeerFoto($id));
// print '</pre>';
// exit;

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
        <div class="container">
            <div>
                <div>
                    <img src="<?= getClubInfo($id)['logo_url']?>">
                    <h1><?= getClubInfo($id)['name']?></h1>
                </div>
                <div>
                    <?php foreach($sfeerfoto as $foto): ?>
                        <img src="<?=$foto['media_url'] ?>" alt="sfeerfoto">
                    <?php endforeach ?>
                </div>
                <div>
                    <h3>check out our socials</h3>
                    <div>
                <i class="fa-sharp fa-solid fa-envelope"></i>
                <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-instagram"></i>
                    </div>
                    <div>
                    <h3>Clubwebsite</h3>
                    <p><a href="<?= getClubUrl($id)['reference']?>">click me!</a></p>
                    </div>
                </div>
            </div>
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
            <?php foreach($bestuur as $lid): ?>

            <li>
                <h3><?=$lid['role']?></h3>
                <p><?=$lid['fullname']?></p>
            </li>
                
            <?php endforeach ?>
           
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
                <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Visitors</th>
                                <th>Hometeam</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($matches as $match): ?>
                        <tr>
                            <td><?= $match['date']?></td>
                            <td><?= $match['opponent']?></td>
                            <td><?= getClubInfo($id)['name']?></td>
                        </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
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
</div>
    </main>
</body>

</html>