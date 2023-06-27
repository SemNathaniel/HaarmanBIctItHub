<?php
function mainControllerFunction($givenTitleArray){
    $userObject = new user();
    $errorArray = array(0 => false, 'text' => '<strong>ERROR 404</strong><br>Klik <a href="index.php?modules=home">hier!</a> om terug te keren naar de hoofdpagina', 'title' => 'ERROR');
    $mainControllerContentObject = new content();
    if(isset($_GET['modules'])){
        if($_GET['modules'] != 'login' && $_GET['modules'] != 'teams' && $_GET['modules'] != 'edit' && $_GET['modules'] != 'createNew' && $_GET['modules'] != 'logout' && $_GET['modules'] != 'contact'){
            $amountOfTitles = count($givenTitleArray);
            foreach($givenTitleArray as $givenTitle){
                $amountOfTitles--;
                if($_GET['modules'] == $givenTitle){
                    return $mainControllerContentObject->turnDataToHtml($_GET['modules']);
                } elseif($amountOfTitles == 0) {
                    return $errorArray;
                }
            }
        } elseif($_GET['modules'] == 'login' && $_SESSION['userStatus'] != 1 || $_GET['modules'] == 'edit' && $_SESSION['userStatus'] == 1 || $_GET['modules'] == 'createNew' && $_SESSION['userStatus'] == 1 || $_GET['modules'] == 'contact'){
            return require_once(ROOT_URL . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $_GET['modules'] . DIRECTORY_SEPARATOR . 'index.php');
        } elseif($_GET['modules'] == 'login' && $_SESSION['userStatus'] == 1){
            return array(0 => true, 'title' => 'al ingelogd', 'text' => 'U bent al ingelogd!<br>log eerst uit voordat u opnieuw inlogd!');
        } elseif($_GET['modules'] == 'logout' && $_SESSION['userStatus'] == 1){
            $userObject->logoutUser();
            $_SESSION['userStatus'] = 0;
            return array(0 => 'logout', 'title' => 'logged out', 'text' => 'U bent succesvol uitgelogd!');
        } elseif($_GET['modules'] == 'logout' && $_SESSION['userStatus'] != 1 || $_GET['modules'] == 'edit' && $_SESSION['userStatus'] != 1 || $_GET['modules'] == 'createNew' && $_SESSION['userStatus'] != 1){
            return array(0 => true, 'title' => 'Log eerst in', 'text' => 'U moet ingelogd zijn om van deze pagina gebruik te maken');
        } elseif(isset($_GET['teams']) || $_GET['modules'] == 'teams'){
            return require_once(ROOT_URL . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'teams' . DIRECTORY_SEPARATOR . 'index.php');
        } else {
            return $errorArray;
        }
    } elseif(isset($_GET['team'])){
        return require_once(ROOT_URL . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'teams' . DIRECTORY_SEPARATOR . 'index.php');
    } elseif(isset($_GET['dataToEdit']) && $_SESSION['userStatus'] != 1){
        return array(0 => true, 'title' => 'Log eerst in', 'text' => 'U moet ingelogd zijn om van deze pagina gebruik te maken');
    }
    else {
        return $mainControllerContentObject->turnDataToHtml(null, null, null, true);
    }
}
?>