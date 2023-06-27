<?php
$textToReturn = '';
$teamArray = array();
$moduleArray = array();
$fileName = time();
$fileDestination = ROOT_URL;
$dbObj = new db();
$contentObject = new content();
if(!empty($_POST) && isset($_SESSION['teamOrModule'])){
    if(isset($_POST['delete'])){
        if($_POST['delete'] == 'delete' && !empty($_POST['editTitle']) && !empty($_POST['editText'])){
            if($_POST['editTitle'] == 'DELETE' && $_POST['editText'] == 'DELETE'){
                if($_SESSION['teamOrModule'] == 'team'){
                    $result = $dbObj->selectFunction("SELECT teamId FROM `teamsdata` WHERE `teamNaam` = '" . $_GET['dataToEdit'] . "'");
                    if($result[0][0] != 1){
                        $dbObj->otherSqlFunction("DELETE FROM `teamsdata` WHERE `teamNaam` = '" . $_GET['dataToEdit'] . "';");
                    } else {
                        $textToReturn .= '<strong>Dit team mag niet verwijderd worden pas hem aan</strong><br>';
                    }
                } elseif($_SESSION['teamOrModule'] == 'module'){
                    $result = $dbObj->selectFunction("SELECT paginaId FROM `paginadata` WHERE `paginaTitel` = '" . $_GET['dataToEdit'] . "'");
                    if($result[0][0] != 1){
                    $dbObj->otherSqlFunction("DELETE FROM `paginadata` WHERE `paginaTitel` = '" . $_GET['dataToEdit'] . "';");
                    } else {
                        $textToReturn .= '<strong>Deze module mag niet verwijderd worden pas hem aan</strong><br>';
                    }
                }
            }
        }
    } elseif(!empty($_POST['editTitle']) && !empty($_POST['editText']) && !empty($_FILES['editImage']['size'])){
        $fileSize = $_FILES['editImage']['size'];
        if($fileSize > 0){
            $file = pathinfo($_FILES['editImage']['name']);
            if(!empty($file['extension']) && $file['extension'] == 'png' || $file['extension'] == 'jpg'){
                $extension = '.' . $file['extension'];
                $fileDestination .= DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $fileName . $extension;
                if(!file_exists($fileDestination)){
                    if(move_uploaded_file($_FILES['editImage']['tmp_name'], $fileDestination)){
                        if($_SESSION['teamOrModule'] == 'team'){
                            $result = $dbObj->otherSqlFunction("UPDATE `teamsdata` SET `teamNaam`='" . $_POST['editTitle'] . "',`tekstvak1`='" . $_POST['editText'] . "',`afbeelding1`='" . $fileName . $extension . "' WHERE `teamNaam` = '" . $_GET['dataToEdit'] . "';");
                            if($result[0] != true){
                                $textToReturn = 'check alle data die je aangepast hebt<br>';
                            } else {
                                header('Location: index.php?modules=teams');
                                exit;
                            }
                        } elseif($_SESSION['teamOrModule'] == 'module'){
                            $result = $dbObj->otherSqlFunction("UPDATE `paginadata` SET `paginaTitel`='" . $_POST['editTitle'] . "',`tekstvak1`='" . $_POST['editText'] . "',`afbeelding1`='" . $fileName . $extension . "' WHERE `paginaTitel` = '" . $_GET['dataToEdit'] . "';");
                            if($result[0] != true){
                                $textToReturn = 'check alle data die je aangepast hebt<br>';
                            } else {
                                header('Location: index.php?modules=' . $_POST['editTitle']);
                                exit;
                            }
                        }
                    }
                }
            }
        }
    } elseif(!empty($_POST['editTitle']) && !empty($_POST['editText'])){
        if($_SESSION['teamOrModule'] == 'team'){
            $result = $dbObj->otherSqlFunction("UPDATE `teamsdata` SET `teamNaam`='" . $_POST['editTitle'] . "',`tekstvak1`='" . $_POST['editText'] . "',`afbeelding1`='' WHERE `teamNaam` = '" . $_GET['dataToEdit'] . "';");
            if($result[0] != true){
                $textToReturn = 'check alle data die je aangepast hebt<br>';
            } else {
                header('Location: index.php?modules=teams');
                exit;
            }
        } elseif($_SESSION['teamOrModule'] == 'module'){
            $result = $dbObj->otherSqlFunction("UPDATE `paginadata` SET `paginaTitel`='" . $_POST['editTitle'] . "',`tekstvak1`='" . $_POST['editText'] . "',`afbeelding1`='' WHERE `paginaTitel` = '" . $_GET['dataToEdit'] . "';");
            if($result[0] != true){
                $textToReturn = 'check alle data die je aangepast hebt<br>';
            } else {
                header('Location: index.php?modules=' . $_POST['editTitle']);
                exit;
            }
        }
    }
}
$results = $dbObj->selectFunction("SELECT teamNaam FROM `teamsdata`;");
if($results[0] != false){
    $textToReturn .= 'Kies een van de volgende teams om aan te passen<br>';
    foreach($results as $result){
        $textToReturn .= '<a href="index.php?modules=edit&dataToEdit=' . $result[0] . '" style="color: black;padding:2px; border: black 1px solid;">' . $result[0] . '</a>';
        array_push($teamArray, $result[0]);
    }
} else {
    $textToReturn .= 'Eén of meerdere teams konden niet worden opgehaald!<br>Meld dit aub bij de beheerder!';
}
$results = $dbObj->selectFunction("SELECT paginaTitel FROM `paginadata`;");
if($results[0] != false){
    $textToReturn .= '<br>Of kies een module om aan te passen!<br>';
    foreach($results as $result){
        $textToReturn .= '<a href="index.php?modules=edit&dataToEdit=' . $result[0] . '" style="color: black;padding:2px; border: black 1px solid;">' . $result[0] . '</a>';
        array_push($moduleArray, $result[0]);
    }
} else {
    $textToReturn .= 'Eén of meerdere modules kon niet worden opgehaald! <br>Meld dit aub bij de beheerder!14';
}
if(isset($_GET['dataToEdit'])){
    foreach($teamArray as $team){
        if($_GET['dataToEdit'] == $team){
            $textToReturn .= $contentObject->turnDataToHtml(null, $_GET['dataToEdit'], 1);
            $_SESSION['teamOrModule'] = 'team';
        }
    }
    foreach($moduleArray as $module){
        if($_GET['dataToEdit'] == $module){
            $textToReturn .= $contentObject->turnDataToHtml($_GET['dataToEdit'], null, 1);
            $_SESSION['teamOrModule'] = 'module';
        }
    }
}
return array(0 => true, 'title' => 'edit', 'text' => $textToReturn);
?>