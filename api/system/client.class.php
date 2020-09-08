<?php
require_once("database.class.php");
class Client extends Database
{
function __construct(){
    parent::__construct();
}

//fonction ajout client qui ajout un client ala base puis retourne la valeur de son id 
function add($nom,$prenom,$adresse,$telephone){
    $req = "insert into client(nom,prenom,adresse,telephone) values(?,?,?,?)";
    $res = $this->pdo->prepare($req);
    $res->execute(array($nom,$prenom,$adresse,$telephone));
    $req = "select max(id) from client";
    $res = $this->pdo->prepare($req);
    $res->execute();
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["max(id)"];
}
//ajout ancien client 
function addOld($nom,$prenom,$adresse,$telephone,$mtp,$mdp,$ddp){
    $req = "insert into client(nom,prenom,adresse,telephone) values(?,?,?,?)";
    $res = $this->pdo->prepare($req);
    $res->execute(array($nom,$prenom,$adresse,$telephone));

    $req = "select max(id) from client";
    $res = $this->pdo->prepare($req);
    $res->execute();
    $idc = $res->fetchAll(PDO::FETCH_ASSOC)["0"]["max(id)"];
    
    $req = "insert into order_vente(idc,date,prixTotale,verif) values(?,?,?,?)";
    $res = $this->pdo->prepare($req);
    $res->execute(array($idc,$ddp,$mtp,0));

    $res = $this->pdo->prepare("select max(id) from order_vente");
    $res->execute();
    $idov = $res->fetchAll(PDO::FETCH_ASSOC)["0"]["max(id)"];

    $req = "insert into facilite (idc,idov,date,montantpayee) values (?,?,?,?)";
    $res = $this->pdo->prepare($req);
    $res->execute(array($idc,$idov,$ddp,$mdp));
}



//fonction utilise l'id du client pour retourner tous ses informations 
function showData($id){
    $res = $this->pdo->prepare("select * from client where id= ?");
    $res->execute(array($id));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"];
}






function showSelectList(){
    $res = $this->pdo->prepare("select * from client");
    $res->execute(array());
    $arr = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($arr as $client) {
        echo '<option value="'.$client['id'].'">'.$client['nom'].' '.$client['prenom'].' - '.$client['telephone'].'</option>';
    }
}



private function montantRestant($idc){
    //determiner les id des ordre vente en cours (non payee) et les metre dans un tableau $arr
    $res = $this->pdo->prepare("select id from order_vente where verif = 0 and idc = ?");
    $res->execute(array($idc));
    $r = $res->fetchAll(PDO::FETCH_ASSOC);
    $arr = array();
    $i=0;
    foreach($r as $row){
        $arr[$i] = $row['id'];
        $i++;
    }

    //calculer la somme des montant payee pour les ordre vente non payee
    $sommePayee = 0;
    foreach($arr as $idov){
        $res = $this->pdo->prepare("select sum(montantpayee) from facilite where idov = ? ");
        $res->execute(array($idov));
        $sommePayee = $sommePayee + floatval($res->fetchAll(PDO::FETCH_ASSOC)["0"]["sum(montantpayee)"]);
    }


    $res = $this->pdo->prepare("select sum(prixTotale) from order_vente where verif = 0 and idc = ?");
    $res->execute(array($idc));
    $prixTotale = floatval($res->fetchAll(PDO::FETCH_ASSOC)["0"]["sum(prixTotale)"]);
    return $prixTotale - $sommePayee;
}

function dernierDatePaymen($idc){
    $res = $this->pdo->prepare("select max(id) from facilite where idc = ?");
    $res->execute(array($idc));
    $maxid =  $res->fetchAll(PDO::FETCH_ASSOC)["0"]["max(id)"];

    $res = $this->pdo->prepare("select date from facilite where id=?  and idc = ?");
    $res->execute(array($maxid,$idc));
    $dern = $res->fetchAll(PDO::FETCH_ASSOC)["0"]["date"];
    if($dern == ""){
        return "non disponible";
    }else{
        return $dern;
    }
}


// fonction returne une liste de tous les clients 
function liste(){
    $res = $this->pdo->prepare("select max(id) from client");
    $res->execute(array());
    $r = $res->fetchAll(PDO::FETCH_ASSOC);

    $res = $this->pdo->prepare("select * from client");
    $res->execute(array());
    $r = $res->fetchAll(PDO::FETCH_ASSOC);
    $ar = array();
    $i = 0;
    foreach($r as $row){
        $row["action"] = '<a target="_blank" title="plus des setaiiles" class="fa fa-indent btn btn-primary" href="DetaillesClient.php?id='.$row["id"] .'"></a>  <a target="_blank" title="ajout payment" class="fa fa-credit-card btn btn-success" href="paymentClient.php?id='.$row["id"] .'"></a>';
        $row["ddp"] = $this->dernierDatePaymen($row["id"] );
        $row["reste"] = $this->montantRestant($row["id"] )." DT";
        $arr[$i] = $row;
        $i++;
    }
    return $arr;
}
}
?>
