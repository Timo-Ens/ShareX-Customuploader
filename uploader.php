<?php
// Settings
$myname			= "Your-name-here"; // Example: AgentJDG
$siteurl 		= "Your-site-url-here"; // Example: i.jimdegroot.me
$sitecolor		= "Your-site-color"; // Example: #316DFF
$randomthings   = array(
    "Standard thing number uno",
    "Standard thing number douzo",
    "Standard thing number treizo"
);
$rand           = array_rand($randomthings);
$description    = $randomthings[$rand];
$secret_key     = "Your-ShareX-password-here";
$sharexdir      = "";
$domain_url     = 'https://yourdomain.url/';
$lengthofstring = 8;

// Code not touch it! ;P

function RandomString($length) {
    $keys = array_merge(range(0, 9), range('a', 'z'));
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[mt_rand(0, count($keys) - 1)];
    }
    return $key;
}

if (isset($_POST['secret'])) {
    if ($_POST['secret'] == $secret_key) {
        $filename    = RandomString($lengthofstring);
        $target_file = $_FILES["sharex"]["name"];
        $fileType    = pathinfo($target_file, PATHINFO_EXTENSION);
        $content     = '
<html>
<head>
  <meta rel="image_src" content="https://' . $siteurl . '/' . $filename . '">
  <meta prefix="og: https://' . $siteurl . '" property="og:image" content="https://' . $siteurl . '/' . $filename . '.' . $fileType . '">
  <meta content="' . $myname . '" property="og:title">
  <meta content="' . $description . '" property="og:description">
  <meta name="twitter:image" content="https://' . $siteurl . '/' . $filename . '.' . $fileType . '">
  <meta content="https://' . $siteurl . '/' . $filename . '.' . $fileType . '" property="og:image">
  <meta name="theme-color" content="' . $sitecolor . '">
  <meta name="twitter:card" content="summary_large_image">
</head>
<body style="background-color:#000000;">
  <img style="-webkit-user-select: none;cursor: zoom-in;" src="https://' . $siteurl . '/' . $filename . '.' . $fileType . '"></img>
</body>
</html>';
        $fp          = fopen("$filename.html", "wb");
        fwrite($fp, $content);
        fclose($fp);
        if (move_uploaded_file($_FILES["sharex"]["tmp_name"], $sharexdir . $filename . '.' . $fileType)) {
            echo $domain_url . $sharexdir . $filename;
        } else {
            echo 'Wrong protocol.';
        }
    } else {
        echo 'Secret key wrong.';
    }
} else {
    echo 'No file given.';
}
?>
