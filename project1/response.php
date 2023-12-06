
<?php
$data = $_GET['datavalue'];

$a = array('Select', 'FB likes', 'FB Followers', 'FB Video Views', 'FB Group Members');
$b = array('Select', 'IG likes', 'IG Followers', 'IG Video Views');
$c = array('Select', 'YT likes', 'YT Subscribers', 'YT Video Views', 'YT Watch time');
$d = array('Select', 'TW likes', 'TW Followers', 'TW Video Views');
$e = array('Select', 'TT likes', 'TT Followers', 'TT Video Views');
$f = array('NOTHING');





switch ($data) {
    case "FaceBook":
        foreach ($a as $a1) {
            echo "<option>$a1</option>";
        }
        break;

    case "Instagram":
        foreach ($b as $b1) {
            echo "<option>$b1</option>";
        }
        break;

    case "Youtube":
        foreach ($c as $c1) {
            echo "<option>$c1</option>";
        }
        break;

    case "Twitter":
        foreach ($d as $d1) {
            echo "<option>$d1</option>";
        }
        break;

    case "TikTok":
        foreach ($e as $e1) {
            echo "<option>$e1</option>";
        }
        break;

    case "Others":
        foreach ($f as $f1) {
            echo "<option>$f1</option>";
        }
        break;
}
?>
