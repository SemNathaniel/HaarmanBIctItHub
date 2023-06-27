<?php
session_start();
require_once('config.php');
require_once(ROOT_URL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'db.class.php');
require_once(ROOT_URL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'user.class.php');
require_once(ROOT_URL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'content.class.php');
require_once('mainController.php');
if(file_exists('initialize.php')){
    require_once('initialize.php');
}
$dbObj = new db();
$userObject = new user();
$contentObject = new content();
$results = '';
$userStatus = '';
$loginLogout = '';
$navBar = '';
$bodyText = '';
$bodyImage = '';
$titleName = '';
$mModules = array();
$pathToHome = '';
user::isUserLoggedIn();
$userStatus = user::isUserLoggedIn();
$results = $dbObj->selectFunction("SELECT paginaTitel FROM `paginadata`;");
 foreach($results as $result){
    $navBar .= '<a href="index.php?modules=' . $result[0] . '">' . $result[0] . '</a>';
    array_push($mModules, $result[0]);
}
$navBar .= '<a href="index.php?modules=teams">teams</a><a href="index.php?modules=contact">contact</a>';
$results = mainControllerFunction($mModules);
if($_SESSION['userStatus'] == 1){
    $navBar .= '<a href="index.php?modules=createNew">create new</a><a href="index.php?modules=edit">edit</a>';
    $loginLogout .= '<a href="index.php?modules=logout" style="float: right;text-decoration: none;color: white;background-color: rgb(70,0,0);border: 2px solid rgb(40,0,0);">log out</a>';
} else {
    $loginLogout .= '<a href="index.php?modules=login" style="float: right;text-decoration: none;color: white;background-color: rgb(70,0,0);border: 2px solid rgb(40,0,0);">log in</a>';
}
$bodyText .= $results['text'];
if(isset($results['img'])){
    if(!empty($results['img'])){
        $bodyImage = $results['img'];
    }
}
$titleName .= $results['title'];
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <title>' . $titleName . '</title><!--Vul opdracht naam in en de week-->
    <link href="Style.css" rel="stylesheet"><!--Css werkt met class attribute-->
</head>
<body>
<header>
    ' . $loginLogout . '
    <div class="siteNaamEnTitel">
    <h3 class="siteTitel">' . $titleName . '</h3>
    </div>
    <div class="siteNavigatiebalk">
        ' . $navBar . '
    </div>
</header>
<main>
    ' . $bodyText . '
    ' . $bodyImage . '
</main>
<footer>
</footer>
</body>
</html>';
echo $html;