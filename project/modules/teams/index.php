<?php
$teamTitle = 'teams';
$teamContent = '';
$teamImg = '';
$teamNames = array();
$dbObj = new db();
$results = $dbObj->selectFunction("SELECT teamNaam FROM `teamsdata`;");
if($results[0] != false){
    $teamContent .= 'Kies een van de volgende teams!<br>';
    foreach($results as $result){
        $teamContent .= '<a href="index.php?modules=teams&team=' . $result[0] . '" style="padding:2px; border: black 1px solid;">' . $result[0] . '</a>';
        array_push($teamNames, $result[0]);
    }
} else {
    $teamContent .= 'Eén of meerdere teams konden niet worden opgehaald!<br>Meld dit aub bij de beheerder!';
}
if(isset($_GET['team']) && isset($_GET['modules'])){
    if($_GET['modules'] == 'teams'){
        $result = $mainControllerContentObject->turnDataToHtml(null, $_GET['team']);
        $teamContent .= $result['text'];
        $teamTitle = $result['title'];
        (isset($result['img']))? $teamImg = $result['img'] : $teamImg = '';
    }
} elseif(isset($_GET['team']) && !isset($_GET['modules'])){
    $result = $mainControllerContentObject->turnDataToHtml(null, $_GET['team']);
    $teamContent .= $result['text'];
    $teamTitle = $result['title'];
    (isset($result['img']))? $teamImg = $result['img'] : $teamImg = '';
}
return array(0 => true, 'title' => $teamTitle, 'text' => $teamContent, 'img' => $teamImg);