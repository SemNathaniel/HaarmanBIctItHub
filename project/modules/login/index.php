<?php
$textToReturn = '';
$title = '';
$image = '';
$result = null;
if(isset($_POST['username']) && isset($_POST['userpass']) && !empty($_POST)){
    $result = $userObject->userLogin($_POST['username'], $_POST['userpass']);
    if($result[0] == true){
        $textToReturn .= 'U bent succesvol ingelogd!<br><img src="images/ingelogd.jpg" width="480" height="400">';
        $title .= 'ingelogd!';
        $userStatus = 1;
    } else {
        $title .= 'inloggen';
        $textToReturn .= 'U kon niet worden ingelogd<br><form action="index.php?modules=login" method="post"><p>Log in alstublieft</p><input type="text" placeholder="username" name="username" value="' . $_POST['username'] . '"><br><input type="password" placeholder="password" name="userpass"><br><input type="submit"></form>';
    }
} else {
    $title .= 'inloggen';
    $textToReturn .= '<br><form action="index.php?modules=login" method="post"><p>Log in alstublieft</p><input type="text" placeholder="username" name="username"><br><input type="password" placeholder="password" name="userpass"><br><input type="submit"></form>';
}
return array(0 => true, 'title' => $title, 'text' => $textToReturn);
?>