<?php
$textToReturn = '';
$fileName = time();
$fileDestination = ROOT_URL;
$dbObj = new db();
$contentObject = new content();
if(!empty($_POST)){
    if(!empty($_POST['newTitle']) && !empty($_POST['newText']) && !empty($_FILES['newImage']['size']) && isset($_POST['teamOrModule'])){
        $fileSize = $_FILES['newImage']['size'];
        if($fileSize > 0){
            $file = pathinfo($_FILES['newImage']['name']);
            if(!empty($file['extension']) && $file['extension'] == 'png' || $file['extension'] == 'jpg'){
                $extension = '.' . $file['extension'];
                $fileDestination .= DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $fileName . $extension;
                if(!file_exists($fileDestination)){
                    if(move_uploaded_file($_FILES['newImage']['tmp_name'], $fileDestination)){
                        if($_POST['teamOrModule'] == 'team'){
                            $result = $dbObj->otherSqlFunction("INSERT INTO `teamsdata`(`teamNaam`, `tekstvak1`, `afbeelding1`) VALUES ('" . $_POST['newTitle'] . "','" . $_POST['newText'] . "','" . $fileName . $extension . "');");
                            print_r($result);
                            if($result[0] != true){
                                $textToReturn = 'check alle data die je aangemaakt hebt<br>of dat er geen duplicaten zijn<br>';
                            } else {
                                header('Location: index.php?modules=teams');
                                exit;
                            }
                        } elseif($_POST['teamOrModule'] == 'module'){
                            $result = $dbObj->otherSqlFunction("INSERT INTO `paginadata`(`paginaTitel`, `tekstvak1`, `afbeelding1`) VALUES ('" . $_POST['newTitle'] . "','" . $_POST['newText'] . "','" . $fileName . $extension . "');");
                            if($result[0] != true){
                                $textToReturn = 'check alle data die je aangemaakt hebt<br>of dat er geen duplicaten zijn<br>';
                            } else {
                                header('Location: index.php?modules=' . $_POST['newTitle']);
                                exit;
                            }
                        }
                    }
                }
            }
        }
    } elseif(!empty($_POST['newTitle']) && !empty($_POST['newTitle'])){
        if($_POST['teamOrModule'] == 'team'){
            $result = $dbObj->otherSqlFunction("INSERT INTO `teamsdata`(`teamNaam`, `tekstvak1`, `afbeelding1`) VALUES ('" . $_POST['newTitle'] . "','" . $_POST['newText'] . "','');");
            if($result[0] != true){
                $textToReturn = 'check alle data die je aangemaakt hebt<br>of dat er geen duplicaten zijn<br>';
            } else {
                header('Location: index.php?modules=teams');
                exit;
            }
        } elseif($_POST['teamOrModule'] == 'module'){
            $result = $dbObj->otherSqlFunction("INSERT INTO `paginadata`(`paginaTitel`, `tekstvak1`, `afbeelding1`) VALUES ('" . $_POST['newTitle'] . "','" . $_POST['newText'] . "','');");
            if($result[0] != true){
                $textToReturn = 'check alle data die je aangemaakt hebt<br>of dat er geen duplicaten zijn<br>';
            } else {
                header('Location: index.php?modules=' . $_POST['newTitle']);
                exit;
            }
        }
    }
}
$textToReturn .= '<form action="index.php?modules=createNew" method="post" enctype="multipart/form-data">Nieuwe module of nieuw team?<br><input type="radio" required name="teamOrModule" id="TOM" value="module"><label for="TOM">New Module</label><br><input type="radio" required name="teamOrModule" id="TOM" value="team"><label for="TOM">New Team</label><br><br>Titel: <input type="text" name="newTitle"><br><br>content:<br><textarea class="textEdit" name="newText"></textarea><br>U kan alleen maar files uploaden met de extensie ".jpg" of ".png"!<br>Afbeelding: <input type="file" name="newImage"><br><input type="submit" value="Aanpassingen aanbrengen" name="submitEdit"></form>';
return array(0 => true, 'title' => 'edit', 'text' => $textToReturn);