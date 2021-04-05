<?php
	require_once __DIR__."/../Requires/00-php_init.php";
	//
$sTable='wf3';
$obPDO=new Requires\DBTools();
$obPDO->init();
//
// $arFieldNames=$obPDO->funGetNameOfColumns($sTable);
// echo'<br> - $arFieldNames = ';
// var_dump($arFieldNames);

//-----------------------------------
// ***  LECTURE SANS argument... ***
// -- OK --V
// $arRows=$obPDO->execSqlQuery("select * from $sTable");
// -- NOK --V ... LECTURE AVEC argument en tableau 'simple', ':' devant la KEY...
// $arRows=$obPDO->execSqlQuery("select * from :$sTable",[":$sTable"=>$sTable]);
// -- NOK --V ... LECTURE AVEC argument en tableau 'simple', PAS ':' devant la KEY...
// $arRows=$obPDO->execSqlQuery('select * from :param',['param'=>$sTable]);
// -- NOK --V ... LECTURE AVEC argument en tableau 'simple', PAS ':' devant la KEY...
// $arRows=$obPDO->execSqlQuery('select * from ?',[$sTable]);
// echo'<br> - $arRows = ';
// var_dump($arRows);

//------------------------------------
// ***  ECRITURE AVEC argument... ***
//------------------------------------
// -- NOK --V
// $obPDO->execSqlQuery("update $sTable set priority=:p1 where ".$sTable."_id=:p2",['p1'=>'33','p2'=>'4']);
// -- OK --V
$obPDO->execSqlQuery("update $sTable set priority=?,url=? where ".$sTable."_id=?",['0','uRl','4']);


//--------------------------------------
// *** METHODE SANS CLASS PERSONNEL ***
//--------------------------------------
$dbPDOConnect=new PDO('mysql:host=127.0.0.1:8889;dbname=portfolio','root','root');
//-- OK --V
// $stQuery=$dbPDOConnect->prepare("select * from $sTable");
// $stQuery->execute();
//-- NOK --V
// $stQuery=$dbPDOConnect->prepare('select * from table=?');
// $stQuery->execute([$sTable]);
//--
// $stQuery=$dbPDOConnect->prepare('select * from :param');
// $stQuery->execute(['param'=>$sTable]);
// $stQuery->execute([':param'=>$sTable]);
//--
// $stQuery->bindParam('param',$sTable);
// $stQuery->execute();
//--
// -- OK --V
// $sRequest=$dbPDOConnect->prepare("update $sTable set priority=? where ".$sTable."_id=?");
// $sRequest->execute(['33','4']);

// $arAllRows=$stQuery->fetchall( );
// echo'<br> - $arAllRows = ';
// var_dump($arAllRows);
?>