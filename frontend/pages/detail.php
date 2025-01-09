<?php
require_once 'system/db.inc.php';
$id = (int)@$_GET['id'];
$clubinfo = getClubInfo($id);
$matches = getFutureMatches($id);
$bestuur= getManagement($id);
$sfeerfoto=getSfeerFoto($id);
$locatie = getClubInfo($id);
$latitude = getClubInfo($id)['latitude']; // deze in url zetten van google maps
$longitude = getClubInfo($id)['longitude']; // deze in url zetten van google maps
$socials = getSocials($id);
$maxID = maxID();
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

function getSocials($id){
    $sql = "select clubs.id,clubs.name as clubname ,reference as sociallink,reference_types.name as linkname,is_social   FROM clubs
left join external_references on clubs.id = external_references.club_id
left join reference_types on external_references.reference_type_id = reference_types.id
where clubs.id = :id
and is_social = 1;";

$stmt = connectToDatabase()->prepare($sql);
            $stmt->execute([
                ":id" => $id,
            ]);
           
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
     
}

function maxID(){
    $sql = "SELECT max(id) as max_id FROM baseball.clubs";
    $stmt = connectToDatabase()->prepare($sql);
    
    // Execute the query
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if 'max_id' is set in the result
    if (isset($result['max_id']) && $result['max_id'] !== null) {
        return (int) $result['max_id'];
    } 
    }



if($id > $maxID) {
    header("Location:/frontend/pages/404.php");
}

// print '<pre>';
// print_r(getSfeerFoto($id)[0]['media_url']);
// print '</pre>';
// exit;

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0, user-scalable=yes">

    <!-- Facebook Meta Tags -->
<meta property="og:url" content="http://localhost:5173/frontend/pages/detail.php?id=<?=$id?>">
<meta property="og:type" content="website">
<meta property="og:title" content="The Belgian Diamond - <?= $clubinfo['name']?> ">
<meta property="og:description" content="extra info about <?= $clubinfo['name']?> you can find them in <?= $clubinfo['city']?>">
<meta property="og:image" content="  <?= $sfeerfoto[0]['media_url']?>">

<meta name="keywords" content="Baseball, Belgian baseballClubs, master-detailpage,belgische baseballclubs, honkbal">
<meta name="robots" content="index, follow">




    <title>Belgian Diamond - <?= getClubInfo($id)['name']?></title>
    <link rel="stylesheet" href="/frontend/css/detail.css">
    <script src="/frontend/js/script.js" defer type="module"></script>
</head>

<body>
    <?php include('frontend/partials/header.inc.php') ?>
   

   
    <main>
        <div class="container basic">
            <div>
                <div>
                    <div>
                    <img src="<?= getClubInfo($id)['logo_url']?>">
                    </div>
                    <h1><?= getClubInfo($id)['name']?></h1>
                </div>
                <div>
                    <?php foreach($sfeerfoto as $foto): ?>
                        <img src="<?=$foto['media_url'] ?>" alt="sfeerfoto <?= getClubInfo($id)['name']?>">
                    <?php endforeach ?>
                </div>
                <div>
                    <h3>check out our socials</h3>
                    <div>
                    <?php

if (!empty($socials)) {
    echo '<ul>';
    foreach ($socials as $social) {
        
        $socialLink = $social['sociallink']; 
        $linkName = strtolower($social['linkname']); // Convert link name to lowercase

        
        $iconClass = '';
        switch ($linkName) {
            case 'instagram':
                $iconClass = 'fa-brands fa-instagram';
                break;
            case 'facebook':
                $iconClass = 'fa-brands fa-facebook';
                break;
            case 'youtube':
                $iconClass = 'fa-brands fa-youtube';
                break;
        }
        echo '<li>';
        echo '<a href="' . $socialLink . '" target="_blank">';
        echo '<i class="' . $iconClass . '"></i>';
        echo '</a>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo "<p>The club-owner didn't share any socials.</p>";
}
?>
                    </div>
                    <div>
                    <h3>Clubwebsite</h3>
                        <p><a href="<?= getClubUrl($id)['reference']?>"><?= explode("www.",getClubUrl($id)['reference'])[1] ?></a></p>
                    </div>
                </div>
            </div>
        </div>
        <?php if(!empty(getClubInfo($id)['description'])): ?>
            
        <div class="container description">

        
            <div>
            
            <h2>Who we are!</h2>
            <input type="checkbox" id="readmore" name="readmore" class="readmore">
            
            <p><?= getClubInfo($id)['description'] ?></p>
            <label for="readmore">Read more</label>
        </div>
        <?php endif ?>
       
        </div>
        <div class="container extrainfo">
            <div>
                <div class="bestuur">
                    <h2>The pillars of our club</h2>
                    <ul>

                    <?php foreach($bestuur as $lid): ?>

                        <li>
                            <h3><?=$lid['role']?></h3>
                            <p><?=$lid['fullname']?></p>
                        </li>
                            
                    <?php endforeach ?>
                    
                    </ul>
                </div>
                        
                <div class="adress">
                <ul>
                    <h2>The Best place to play ball!</h2>
                    <li>
                                <h3>Provincie</h3>
                                <p><?= getClubInfo($id)['province']?></p>
                            </li>
                            <li>
                                <h3>Gemeente</h3>
                                <p><?= getClubInfo($id)['zip']?> <?= getClubInfo($id)['city']?></p>
                            </li>
                            <li>
                                <h3>Adres </h3>
                                <p><?= getClubInfo($id)['street']?> <?= getClubInfo($id)['address']?><?= getClubInfo($id)['bus']?></p>
                            </li>
                </ul>
                </div>
                <div class="games">
                    <h2>we want you to support our teams!</h2>
                    <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Visiting team</th>
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
            </div>
            <div class="gmap">
    <iframe 
        src="https://www.google.com/maps?q=<?=$latitude?>,<?=$longitude?>&hl=en&z=14&output=embed" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>
        </div>
        </div>
    <div>
</div>
    </main>
    <div>
    <ul>
    
</ul>
    </div>
    <footer>
        <div></div>
    </footer>
</body>
</html>