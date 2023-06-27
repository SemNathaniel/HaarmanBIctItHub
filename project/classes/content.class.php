<?php
class content{
    public $dbObj = null;
    public $result = null;

    public function __construct(){
        $this->dbObj = new db();
    }

    public function turnDataToHtml($selectedModule = null, $selectedTeam = null, $toEdit = 0, $returnFirst = false){
        if($returnFirst != false){
            $this->result = $this->dbObj->selectFunction("SELECT * FROM `paginadata` WHERE 1 LIMIT 1;");
            if($this->result[0] != false){
                if($this->result[0][3] != ''){
                    return array(0 => true, 'title' => $this->result[0][1], 'text' => '<p class="text">' . $this->result[0][2] . '</p>', 'img' => '<img src="' . 'images' . DIRECTORY_SEPARATOR . $this->result[0][3] . '" class="bodyImg">');
                } else {
                    return array(0 => true, 'title' => $this->result[0][1], 'text' => '<p class="text">' . $this->result[0][2] . '</p>');
                }
            }
        }
        if($toEdit == 0){
            if($selectedModule != null && $selectedModule != 'teams'){
                $this->result = $this->dbObj->selectFunction("SELECT * FROM `paginadata` WHERE paginaTitel = BINARY('" . $selectedModule . "');");
                if($this->result[0] != false){
                    if($this->result[0][3] != ''){
                        return array(0 => true, 'title' => $this->result[0][1], 'text' => '<p class="text">' . $this->result[0][2] . '</p>', 'img' => '<img src="' . 'images' . DIRECTORY_SEPARATOR . $this->result[0][3] . '" class="bodyImg">');
                    } else {
                        return array(0 => true, 'title' => $this->result[0][1], 'text' => '<p class="text">' . $this->result[0][2] . '</p>');
                    }
                } else {
                    return array(0 => false, 'text' => '<strong>ERROR 404</strong><br>Klik <a href="index.php?modules=home">hier!</a> om terug te keren naar de hoofdpagina', 'title' => 'ERROR');
                }
            } elseif ($selectedTeam != null && $selectedModule == null || $selectedTeam != null && $selectedModule = 'teams'){
                $this->result = $this->dbObj->selectFunction("SELECT * FROM `teamsdata` WHERE teamNaam = '" . $selectedTeam . "';");
                if($this->result[0] != false){
                    if($this->result[0][3] != ''){
                        return array(0 => true, 'title' => $this->result[0][1], 'text' => '<p class="text">' . $this->result[0][2] . '</p>', 'img' => '<img src="' . 'images' . DIRECTORY_SEPARATOR . $this->result[0][3] . '" class="bodyImg">');
                    } else {
                        return array(0 => true, 'title' => $this->result[0][1], 'text' => '<p class="text">' . $this->result[0][2] . '</p>');
                    }
                } else {
                    return array(0 => false, 'text' => '<strong>ERROR 404</strong><br>Klik <a href="index.php?modules=home">hier!</a> om terug te keren naar de hoofdpagina', 'title' => 'ERROR');
                }
            }
        } else {
            if($selectedModule == null && $selectedTeam != null){
                return '<br><br><form action="index.php?modules=edit&dataToEdit=' . $selectedTeam . '" method="post" enctype="multipart/form-data">typ "DELETE" in de titel- en textbalk om verwijderen te bevestigen!<br><input type="checkbox" id="DEL" name="delete" value="delete"><label for="DEL">Delete</label><br>De Titel mag niet een duplicaat zijn van een andere titel!<br>titel: <input type="text" required name="editTitle" value="' . $selectedTeam . '"><br><br>content:<br><textarea required class="textEdit" name="editText"></textarea><br>U kan alleen maar files uploaden met de extensie ".jpg" of ".png"!<br>Afbeelding: <input type="file" name="editImage"><br><input type="submit" value="Aanpassingen aanbrengen" name="submitEdit">
                </form>';
            } elseif($selectedModule != null && $selectedTeam == null){
                return '<br><br><form action="index.php?modules=edit&dataToEdit=' . $selectedModule . '" method="post" enctype="multipart/form-data">typ "DELETE" in de titel- en textbalk om verwijderen te bevestigen!<br><input type="checkbox" id="DEL" name="delete" value="delete"><label for="DEL">Delete</label><br>titel: <input required type="text" name="editTitle" value="' . $selectedModule . '"><br><br>content:<br><textarea class="textEdit" required name="editText"></textarea><br>U kan alleen maar files uploaden met de extensie ".jpg" of ".png"!<br>Afbeelding: <input type="file" name="editImage"><br><input type="submit" value="Aanpassingen aanbrengen" name="submitEdit">
                </form>';
            }
        }
    }
}
?>