<?php
require_once("database.class.php");
class Journal extends Database
{
function __construct(){
    parent::__construct();
}
//fonction ajout journal qui ajout un journal ala base puis retourne la valeur de son idov
function add($type,$idc,$idp,$qte,$prix,$montantpayee,$tva,$ddp){
    //1ere etape : ajouter la commande a la table journale
    if($type != "Facilite"){
        $req = "insert into journal(idp,qte,prix,montantpayee,date,tva) values(?,?,?,?,?,?)";  
        $res = $this->pdo->prepare($req);
        $res->execute(array($idp,$qte,$prix,$montantpayee,$ddp,$tva));   
    }else{
        //ajouter a l'order vente en cas de facilite 
        $req = "insert into order_vente (idc,listeidp,date,listeqte,prixTotale,verif) values(?,?,?,?,?,?)";  
        $res = $this->pdo->prepare($req);
        $res->execute(array($idc,$idp,$ddp,$qte,$prix,0));
        //Retourner l'id de l'ordre vente
        $req = "select max(id) from order_vente";
        $res = $this->pdo->prepare($req);
        $res->execute(array($qte,$idp));
        $idov =  $res->fetchAll(PDO::FETCH_ASSOC)["0"]["max(id)"];
        //Ajout payment a la table facilité
        $req = "insert into facilite (idc,idov,date,montantpayee) values(?,?,?,?)";
        $res = $this->pdo->prepare($req);
        $res->execute(array($idc,$idov,$ddp,$montantpayee)); 
        //--------------------------------------------------------------------------------------------------
        $req = "insert into journal (idc,idov,idp,qte,prix,montantpayee,date,tva) values(?,?,?,?,?,?,?,?)";
        $res = $this->pdo->prepare($req);
        $res->execute(array($idc,$idov,$idp,$qte,$prix,$montantpayee,"20".date("y-m-d"),$tva));
    }
    //2eme etape , pour chaque produit vendu , on deminue son quantité dans le stock
    $lp = explode("|",$idp);
    $lq = explode("|",$qte);
    $longeur  = count($lp)-1;
    for ($i=0; $i < $longeur; $i++) { 
        $old = $this->getResteStockProduit($lp[$i]);
        $new = $old - $lq[$i];
        $this->setNewProduitQte($lp[$i],$new);
    }
    return $idov;
}
private function setNewProduitQte($idp,$qte){
    $req = "update produit set qte = ? where id= ?";
    $res = $this->pdo->prepare($req);
    return $res->execute(array($qte,$idp));
}
private function getResteStockProduit($idp){
    $req = "select qte from produit where id = ?";
    $res = $this->pdo->prepare($req);
    $res->execute(array($idp));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["qte"];
}
//fonction utilise l'id du client pour retourner tous ses informations 
function GetData($id){
    $res = $this->pdo->prepare("select * from journal where id= ?");
    $res->execute(array($id));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"];
}

function getPrix($idp){
    $res = $this->pdo->prepare("select prix_vente from produit where id= ?");
    $res->execute(array($idp));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["prix_vente"];
}
function getMaxQte($idp){
    $res = $this->pdo->prepare("select qte from produit where id= ?");
    $res->execute(array($idp));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["qte"];
}
function liste(){
    $res = $this->pdo->prepare("select * from journal");
    $res->execute(array());
    $r = $res->fetchAll(PDO::FETCH_ASSOC);
    $ar = array();
    $i = 0;
    foreach($r as $row){
        $row["client"] = $this->getClient($row['idc'])["nom"]." ".$this->getClient($row['idc'])["prenom"];
        $row["action"] = '<a target="_blank" title="Imprimer Facture" class="fa fa-file-text btn btn-primary" href="facture.php?idj='.$row["id"] .'"></a><a target="_blank" title="Mettre a jour" class="fa fa-refresh  btn btn-danger" href="updateJournal.php?idj='.$row["id"] .'&idc='.$row["idc"].'&idov='.$row["idov"].'"></a>';
        $lp = explode("|",$row["idp"]);
        $lq = explode("|",$row["qte"]);
        $lon = count($lp) -1 ;
        $html = "";
        $j=0;
        for($j=0;$j<$lon;$j++){
            $iddp = intval($lp[$j]);
            $html = $html.' '.$this->getProduit($iddp)["label"] . '    '.$this->getFornisseurName($this->getProduit(intval($lp[$j]))["idf"]).' ( '.$lq[$j].' )  <br>';
            echo ($j);
        }
        $row["produit"] = $html;
        //dernier etape
        $ar[$i] = $row;
        $i++;
    }
    return $ar;
}
function getClient($idc){
    $res = $this->pdo->prepare("select * from client where id= ? ");
    $res->execute(array($idc));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"];
}
function getProduit($idp){
    $res = $this->pdo->prepare("select * from produit where id= ? ");
    $res->execute(array($idp));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"];
}

function getFornisseurName($idf){
    $res = $this->pdo->prepare("select nom from fornisseur where id= ? ");
    $res->execute(array($idf));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["nom"];
}

function getMontantTotalByDate($date){
    $res = $this->pdo->prepare("select sum(montantpayee) from journal where date= ? and idc IS NULL");
    $res->execute(array($date));
    $x1 =  $res->fetchAll(PDO::FETCH_ASSOC)["0"]["sum(montantpayee)"];
    $res = $this->pdo->prepare("select sum(montantpayee) from facilite where date= ? ");
    $res->execute(array($date));
    $x2 =  $res->fetchAll(PDO::FETCH_ASSOC)["0"]["sum(montantpayee)"];
    return floatval($x1) + floatval($x2);
}

function TableauUpdate($idj){
    $res = $this->pdo->prepare("select * from journal where id = ? ");
    $res->execute(array($idj));
    $r = $res->fetchAll(PDO::FETCH_ASSOC)["0"];
    $lp = explode("|",$r["idp"]);
    $lq = explode("|",$r["qte"]);
    $longeur  = count($lp)-1;
    for ($i=0; $i < $longeur; $i++) { 
        echo '
            <tr>
                <td>'.$this->getProduit($lp[$i])["label"].' - '.$this->getFornisseurName($this->getProduit($lp[$i])["idf"]).'<input type="text" name="idp[]" hidden value="'.$lp[$i].'"></td>
                <td><input name="qte[]" class="form-control" type="number" value="'.$lq[$i].'" max="'.$lq[$i].'"></td>
            </tr>
        ';
    }
}
//-----------------------------------------------------------------

function update($idj,$idp,$qte){
    $prixtotale = 0;
    $oldPrixTotale = 0;
    $montantpayee = 0;
    $oldMontantPayee =0 ;
    
    $res = $this->pdo->prepare("select * from journal where id = ? ");
    $res->execute(array($idj));
    $r = $res->fetchAll(PDO::FETCH_ASSOC)["0"];
    $idc = $r["idc"];
    $oldMontantPayee = $r["montantpayee"];
    $oldPrixTotale = $r["prix"];
    $oldListeProduit = explode("|",$r["idp"]);
    $oldListeQuantite = explode("|",$r["qte"]);
    $long = count($oldListeProduit) - 1;
    $newListeQuantite = $qte;
    $finalListeQuantiteProduit = array(); // pour mettre a jours a table produit
    $finallisteQuantite = "";//new liste produit pour mettre a jours journal / ordre vente
    for($i=0;$i<$long;$i++){
        if($oldListeQuantite[$i] > $newListeQuantite[$i]){
            $finalListeQuantiteProduit[$i] = floatval($oldListeQuantite[$i]) - floatval($newListeQuantite[$i]);
        }else{
            $finalListeQuantiteProduit[$i]  = floatval($oldListeQuantite[$i]);
        }
        $finallisteQuantite = $finallisteQuantite.$newListeQuantite[$i]."|";
        $prixtotale = $prixtotale  + (floatval($this->getPrix($idp[$i])) * floatval($qte[$i]));
    }

    if($idc == ""){
        //normal
        //update journal
        $req = "update journal set qte = ?  , prix = ? , montantpayee = ? where id= ?";
        $res = $this->pdo->prepare($req);
        $res->execute(array($finallisteQuantite,$prixtotale,$prixtotale,$idj));
        //update table produit
        for($i=0;$i<$long;$i++){
            $res = $this->pdo->prepare("select qte from produit where id = ? ");
            $res->execute(array($idp[$i]));
            $rqte = $res->fetchAll(PDO::FETCH_ASSOC)["0"]["qte"];

            $nqte = $rqte + $finalListeQuantiteProduit[$i];

            $req = "update produit set qte = ?  where id= ?";
            $res = $this->pdo->prepare($req);
            $res->execute(array($nqte,$idp[$i]));
            return $oldPrixTotale - $prixtotale;
        }
    }else{
        //facilite
         //update journal
         $req = "update journal set qte = ? , date = ? , prix = ?  where id= ?";
         $res = $this->pdo->prepare($req);
         $res->execute(array($finallisteQuantite,"20".date("y-m-d"),$prixtotale,$idj));
         //update table produit
         for($i=0;$i<$long;$i++){
             $res = $this->pdo->prepare("select qte from produit where id = ? ");
             $res->execute(array($idp[$i]));
             $rqte = $res->fetchAll(PDO::FETCH_ASSOC)["0"]["qte"];
 
             $nqte = $rqte + $finalListeQuantiteProduit[$i];
 
             $req = "update produit set qte = ?  where id= ?";
             $res = $this->pdo->prepare($req);
             $res->execute(array($nqte,$idp[$i]));
        }
        
             $req = "update order_vente set listeqte = ?, date = ? , prixTotale = ? where id= ?";
             $res = $this->pdo->prepare($req);
             $res->execute(array($finallisteQuantite,"20".date("y-m-d"),$prixtotale,$r["idov"]));
             return $oldMontantPayee - $prixtotale;
    }
    
}






}
?>