<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="hospital.css">
    <link rel="stylesheet" href="card/card_hospital.css">
</head>

<body onload="getHospital()">
    <?php

    session_start();
    if (empty($_SESSION['username'])) {
        require_once("navigation_bar.html");
    } else {
        require_once("navigation_bar_after.html");
    }

    require_once("donor_controller.php");

    $rumah_sakit_data = readAllRumahSakit();
    $bloodtype = $_GET['bloodtype'];

    if (is_numeric($bloodtype)) {
        $bloodtype_id = $_GET['bloodtype'] + 1;
        $bloodtype = readGolDarahByID($bloodtype_id);
        if ($bloodtype_id % 2 !== 0) {
            $bloodtype_plus = $bloodtype;
            $bloodtype_negative = readGolDarahByID($bloodtype_id + 1);
        } else {
            $bloodtype_plus = readGolDarahByID($bloodtype_id - 1);
            $bloodtype_negative = $bloodtype;
        }
    } else {
        $bloodtype .= '+';
        $bloodtype_id = getGolDarahID($bloodtype);
        $bloodtype_plus = readGolDarahByID($bloodtype_id);
        $bloodtype_negative = readGolDarahByID($bloodtype_id + 1);
    }
    ?>

    <div class="container">
        <section class="hero">
            <h1><?= $bloodtype ?></h1>
            <label>Tagline</label>
            <div class="hero_btn">
                <a href="hospital.php?bloodtype=<?= getGolDarahID($bloodtype_plus) - 1 ?>" class="btn"><?= $bloodtype_plus ?></a>
                <a href="hospital.php?bloodtype=<?= getGolDarahID($bloodtype_negative) - 1 ?>" class="btn"><?= $bloodtype_negative ?></a>
            </div>

            <div class="search">
                <form onsubmit="event.preventDefault();" role="search">
                    <label for="search">Search for stuff</label>
                    <input id="search" type="search" placeholder="Search..." autofocus required />
                    <button type="submit">Go</button>
                </form>
            </div>
        </section>

        <section class="hospital">
            <div class="main-content">
                <!-- <div class="card">
                    <h3 id="output">test</h3>
                    <div class="line"></div>
                    <p>
                        Contrary to popular belief, Lorem Ipsum is not simply random text.
                        It has roots in a piece of classical Latin
                    </p>
                </div> -->
                <?php
                for ($i = 0; $i < sizeof($rumah_sakit_data); $i++) {
                    $jumlah_donor = getJumlahDonorByRumahSakitID($i + 1, $bloodtype_id);
                ?>
                    <div class="card">
                        <h3><?= $rumah_sakit_data[$i]['nama'] ?>, <?= $rumah_sakit_data[$i]['domisili'] ?></h3>
                        <div class="line"></div>
                        <p><?= $rumah_sakit_data[$i]['alamat'] ?></p>
                        <h3>Jumlah Donor : <?= $jumlah_donor ?></h3>
                    </div>
                <?php
                }
                ?>
            </div>
        </section>
    </div>
    <script src="hospital_api/hospital_api.js"></script>
</body>

</html>