<?php
require_once 'system/db.inc.php';

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
        <h1>club baseballos</h1>
        <div>
            <div>
                <img src="https://static.wbsc.org/upload/7784025f-15e3-9d72-ec0a-5cea1fb36fac.png" alt="foto van de club">
                foto van club
            </div>
            <div>
                <img src="https://picsum.photos/id/237/200/300" alt="sfeerfoto">
                sfeerfoto
            </div>
        </div>
        <div>
        <div>
            <h2>gegevens van de club</h2><br>
            <ul>
                <li>
                    <h3>Provincie</h3>
                    <p>De gegevens</p>
                </li>
                <li>
                    <h3>Postcode + Gemeente</h3>
                    <p>De gegevens</p>
                </li>
                <li>
                    <h3>Adres (Straat + Huisnummer)</h3>
                    <p>De gegevens</p>
                </li>
            </ul>
        </div>

        <div>
        <ul>
            <h2>het bestuur</h2>
            <li>
                <h3>Voorzitter</h3>
                <p>Joppe for presiden</p>
            </li>
            <li>
                <h3>Secretaris generaal</h3>
                <p>Matti for General</p>
            </li>
            <li>
                <h3>penningMeester</h3>
                <p> Marcus Licinius Crassus</p>
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