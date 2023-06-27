<?php
$results = array();
$queryFalse = 0;
$lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lobortis scelerisque fermentum dui faucibus in ornare quam viverra. Vulputate mi sit amet mauris. Donec et odio pellentesque diam. Sit amet mauris commodo quis imperdiet massa. Eu tincidunt tortor aliquam nulla facilisi cras fermentum odio. Volutpat consequat mauris nunc congue. Ornare arcu dui vivamus arcu felis bibendum ut tristique. Nunc mattis enim ut tellus elementum sagittis vitae et. Tempor commodo ullamcorper a lacus vestibulum sed arcu non. Ut morbi tincidunt augue interdum velit euismod in. Id diam maecenas ultricies mi eget mauris pharetra et ultrices. Enim praesent elementum facilisis leo vel fringilla est. Integer feugiat scelerisque varius morbi enim nunc faucibus a. Laoreet suspendisse interdum consectetur libero. Tristique et egestas quis ipsum.

Adipiscing tristique risus nec feugiat in fermentum. Commodo nulla facilisi nullam vehicula ipsum. Blandit turpis cursus in hac habitasse platea dictumst quisque. Integer enim neque volutpat ac tincidunt vitae semper quis lectus. Urna nec tincidunt praesent semper feugiat nibh sed pulvinar proin. Elit ut aliquam purus sit amet luctus venenatis lectus magna. Ornare arcu dui vivamus arcu felis bibendum ut. Morbi tempus iaculis urna id volutpat lacus. Cursus mattis molestie a iaculis. Sit amet luctus venenatis lectus magna fringilla. Arcu non odio euismod lacinia at. Adipiscing vitae proin sagittis nisl. Lacinia at quis risus sed. Massa id neque aliquam vestibulum morbi blandit cursus.

Tellus at urna condimentum mattis pellentesque id nibh. Vestibulum morbi blandit cursus risus. Sem fringilla ut morbi tincidunt. Cursus euismod quis viverra nibh cras pulvinar. Pulvinar mattis nunc sed blandit. Elementum tempus egestas sed sed risus pretium quam. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere lorem. Odio aenean sed adipiscing diam donec adipiscing tristique risus nec. Tellus molestie nunc non blandit massa. Mauris vitae ultricies leo integer malesuada.';
$dbObj = new db();
$queryArray = array(
    'tableQuery' => array(
        "CREATE TABLE IF NOT EXISTS `klanten_contact`(
            id INT(9) AUTO_INCREMENT PRIMARY KEY,
            email_adres VARCHAR(50),
            data TEXT
        );",
        "CREATE TABLE IF NOT EXISTS `teamsdata`(
            teamId INT(9) AUTO_INCREMENT PRIMARY KEY,
            teamNaam VARCHAR(20) UNIQUE,
            tekstvak1 TEXT,
            afbeelding1 TEXT
        );",
        "CREATE TABLE IF NOT EXISTS `paginadata`(
            paginaId INT(9) AUTO_INCREMENT PRIMARY KEY,
            paginaTitel VARCHAR(20) UNIQUE,
            tekstvak1 TEXT,
            afbeelding1 TEXT
        );",
        "CREATE TABLE IF NOT EXISTS `users`(
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
            username varchar(20) NOT NULL UNIQUE,
            userpass varchar(1000) NOT NULL
        );"
    ),
    'recordQuery' => array(
        "INSERT INTO `teamsdata`
        (teamNaam, tekstvak1, afbeelding1)
        VALUES
        ('A1', 'Hallo dit is de teampagina van de A1 wees welkom', '');",
        "INSERT INTO `paginadata`
        (paginaTitel, tekstvak1, afbeelding1)
        VALUES
        ('home', '" . $lorem . "', '');",
        "INSERT INTO `users`
        (username, userpass)
        VALUES
        ('admin', PASSWORD('root'));"
    )
    
);
foreach($queryArray['tableQuery'] as $tableQuery){
    array_push($results, $dbObj->otherSqlFunction($tableQuery));
}
foreach($queryArray['recordQuery'] as $recordQuery){
    array_push($results, $dbObj->otherSqlFunction($recordQuery));
}
foreach($results as $result){
    if($result[0] == false){
        $queryFalse++;
    }
}
if($queryFalse == 0){
    unlink('initialize.php');
}