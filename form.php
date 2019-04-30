<?php
$servername = " ";
$username = " ";
$password = " ";
$dbname = " ";
// Luodaan yhteys
$con = new wpdb($username, $password, $dbname, $servername);
if ($con->connect_error) {
    die("Connection failed:" . $con->connect_error);
}

// varmistus- ja ohjausviestit
$response = "";

$not_human = "Ihmistodennus ei onnistunut.";
$missing_content = "Täytä pakolliset kentät.";
$email_invalid = "Sähköpostiosoite virheellinen.";
$message_unsent = "Viestiä ei lähetetty. Yritä uudelleen.";
$message_sent = "Kiitos. Viestisi on lähetetty";

$nimi = $_POST["nimi"];
$logo = $_POST["logo"];
$voimassaoloaika = $_POST["voimassaoloaika"];
$viimeisen_leiman_teksti = $_POST["viimeisen_leiman_teksti"];
$leimamaara = $_POST["leimamaara"];
$selite = $_POST["selite"];
$vari = $_POST["vari"];
$base64logo;

$check = getimagesize($_FILES["logo"]["tmp_name"]);
if ($check !== false) {
    $base64logo = base64_encode(file_get_contents($_FILES["logo"]["tmp_name"]));
} else {
    echo "File is not an image.";
}
$con->insert("korttipohja", array(
    "nimi" => $nimi,
    "logo" => $base64logo,
    "voimassaoloaika" => $voimassaoloaika,
    "viimeisen_leiman_teksti" => $viimeisen_leiman_teksti,
    "leimamaara" => $leimamaara,
    "selite" => $selite,
    "vari" => $vari
), array(
    "%s", //nimi - string
    "%s", //logo - string
    "%d", // voimassaoloaika - date
    "%s", // viimeisen leiman teksti - string
    "%s", // selite - string
    "%s"  // väri - string
));
$con->close();
?>
 
<?php get_header(); ?>
 
<div id="primary" class="site-content">
    <div id="content" role="main">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                    <style type="text/css">
                        .error {
                            padding: 5px 9px;
                            border: 1px solid red;
                            color: red;
                            border-radius: 3px;
                        }

                        .success {
                            padding: 5px 9px;
                            border: 1px solid green;
                            color: green;
                            border-radius: 3px;
                        }

                        .form {
                            color: red;
                        }
                    </style>
                    <div id="respond">
                        <?php echo $response; ?>
                        <form action="<?php the_permalink(); ?>" method="post">
                            <fieldset>
                                <legend>Leimapassi</legend>
                                Nimi: <input type="text" name="nimi" maxlength="50" size="100" required>
                                <br />
                                Logo: <input type="file" name="logo" id="fileToUpload">
                                <br />
                                Voimassaoloaika: <input type="date" name="voimassaoloaika" min="2019-04-01" max="2090-12-31" size="100">
                                <br />
                                Palkinto: <input list="arvo" type="text" name="viimeisen_leiman_teksti" size="100">
                                <datalist id="arvo">
                                    <option value="100">ilmainen
                                    <option value="5">-5%                                    
                                    <option value="10">-10%                  
                                    <option value="15">-15%
                                    <option value="20">-20%
                                    <option value="25">-25%
                                    <option value="30">-30%
                                    <option value="35">-35%
                                    <option value="40">-40%
                                    <option value="45">-45%
                                    <option value="50">-50%
                                    <option value="55">-55%
                                    <option value="60">-60%
                                    <option value="65">-65%
                                    <option value="70">-70%
                                    <option value="75">-75%
                                    <option value="80">-80%
                                    <option value="85">-85%
                                    <option value="90">-90%
                                    <option value="95">-95%
                                </datalist>
                                <br />
                                Leimamaara: <input type="number" name="leimamaara" min="5" max="20" step="1" value="10" size="100">
                                <br />
                                Selite: <input type="text" name="selite" placeholder="saavutus, max 350merkkiä" maxlength="350" size="100">
                                <br />
                                Väri:
                                <table>
                                    <br />
                                    <tr>
                                        <th>
                                            <input type="checkbox" name="vari" value="1">Harmaa
                                        </th>
                                        <th>
                                            <input type="checkbox" name="vari" value="2">Keltainen
                                        </th>
                                        <th>
                                            <input type="checkbox" name="vari" value="3">Liila
                                        </th>
                                        <th>
                                            <input type="checkbox" name="vari" value="4">Pinkki
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <input type="checkbox" name="vari" value="5">Punainen
                                        </th>
                                        <th>
                                            <input type="checkbox" name="vari" value="6">Ruskea
                                        </th>
                                        <th>
                                            <input type="checkbox" name="vari" value="7">Sininen
                                        </th>
                                        <th>
                                            <input type="checkbox" name="vari" value="8">Vihreä
                                        </th>
                                    </tr>
                                </table>
                                <br />
                                <input type="reset" value="TYHJENNÄ">
                                <input type="submit" value="LÄHETÄ" name="submit">
                            </fieldset>
                        </form>
                    </div>
                </div><!-- .entry-content -->
            </article><!-- #post -->
        <?php endwhile; ?>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>