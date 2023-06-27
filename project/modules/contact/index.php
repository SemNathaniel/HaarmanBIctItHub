<?php
$dbObj = new db();
$textToReturn = '';
if(!empty($_POST)){
    if(!empty($_POST['email']) && !empty($_POST['txtArea'])){
        $result = $dbObj->otherSqlFunction("INSERT INTO `klanten_contact`(`email_adres`, `data`) VALUES ('" . $_POST['email'] . "','" . $_POST['txtArea'] . "');");
        if($result[0] != true){
            $textToReturn = 'check alle velden die je ingevuld hebt<br>';
        } else {
            $textToReturn .= 'Het formulier is verstuurd!';
            $_SESSION['formSent']--;
        }
    }
}
$form = '<form action="index.php?modules=contact" method="post">E-mail: <input type="email" name="email" required><br>Typ wat u ons wilt laten weten!<br><textarea required name="txtArea"></textarea><br><input type="submit" value="verzend formulier"></form>';
if(isset($_SESSION['formSent'])){
    if($_SESSION['formSent'] > 0){  
        $textToReturn .= $form;
    } elseif($_SESSION['formSent'] <= 0){
        $textToReturn .= '<br>U heeft helaas te vaak dit formulier opgestuurd!<br>Probeer het later opnieuw!';
    }
} else {
    $_SESSION['formSent'] = 3;
    $textToReturn .= $form;
}
return array(0 => true, 'title' => 'contact', 'text' => $textToReturn);
?>