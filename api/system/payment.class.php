<?php
require_once("database.class.php");
class Payment extends Database
{
    function __construct(){
        parent::__construct();
    }
    function add($idc,$idov,$montant){
        //total payee
        $res = $this->pdo->prepare("select sum(montantpayee) from facilite where idov = ?");
        $res->execute(array($idov));
        $OVTotalPayee = $res->fetchAll(PDO::FETCH_ASSOC)["0"]["sum(montantpayee)"];
        //somme totale de l'ordre vente 
        $res = $this->pdo->prepare("select prixTotale from order_vente where id = ?");
        $res->execute(array($idov));
        $OVTotalPayee = $res->fetchAll(PDO::FETCH_ASSOC)["0"]["prixTotale"];
        //reste a payee 
        $reste = $OVTotalPayee - ($OVTotalPayee + $montant );
        //si reste = 0 an va mettre a jours la table order_vente , le champ verif sera 1 (cad c bon tous est payee)
        if($reste<=0){
            $res = $this->pdo->prepare("update order_vente set verif = ? where idov = ?");
            $res->execute(array(0,$idov));
            $res->fetchAll(PDO::FETCH_ASSOC)["0"]["sum(montantpayee)"];
        }
        $res = $this->pdo->prepare("insert into facilite(idc,idov,date,montantpayee) values(?,?,?,?)");
        $res->execute(array($idc,$idov,"20".date("y-m-d"),$montant));
        $res->fetchAll(PDO::FETCH_ASSOC);
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
    function detaillesNonPayee($idc){
        $res = $this->pdo->prepare("select id from order_vente where verif = 0 and idc = ?");
        $res->execute(array($idc));
        $r = $res->fetchAll(PDO::FETCH_ASSOC);
        $idOV = array();
        $i=0;
        foreach($r as $row){
            $idOV[$i] = $row['id'];
            $i++;
        }
        foreach($idOV as $idov){
            $res = $this->pdo->prepare("select sum(montantpayee) from facilite where idov = ? ");
            $res->execute(array($idov));
            $TotaleRecue = floatval($res->fetchAll(PDO::FETCH_ASSOC)["0"]["sum(montantpayee)"]);

            $res = $this->pdo->prepare("select * from order_vente where id = ?");
            $res->execute(array($idov));
            $det = $res->fetchAll(PDO::FETCH_ASSOC)["0"];

            
            $idDesProduits = explode("|",$det["listeidp"]);
            $LiDesQuantite = explode("|",$det["listeqte"]);
            $longeur = count($idDesProduits)-1;
            $resteTotale = floatval($det["prixTotale"])-floatval($TotaleRecue);
            echo '
            <tr>
				<td rowspan="'.$longeur.'">'.$det["id"].'</td>
				<td rowspan="'.$longeur.'">'.$det["date"].'</td>
				<td>'.$this->getNomProduit($idDesProduits[0]).'</td>
				<td>'.$LiDesQuantite[0].'</td>
				<td rowspan="'.$longeur.'">'.$det["prixTotale"].' DT</td>
				<td rowspan="'.$longeur.'">'.$TotaleRecue.' DT</td>
				<td rowspan="'.$longeur.'">'.$resteTotale.' DT</td>
				<form action="api/POSTS/payment.php?paymentClient&ajout" method="POST">
                    <td rowspan="'.$longeur.'">
                        <input class="form-control" type="text" required name="montant" id="f'.$det["id"].'"> 
                        <input type="text" value="'.$det["id"].'" name="idov"hidden> 
                        <input type="text" value="'.$idc.'" name="idc" hidden>
                    </td>
                    <td rowspan="'.$longeur.'">
                        <input type="text" id="'.$det["id"].'" hidden value="'.$resteTotale.'">
                        <button class="fa fa-credit-card btn btn-success" onclick="return verif(\'f'.$det["id"].'\',\''.$det["id"].'\')" type="submit"></button>
                        
                    </td>
				</form>
			</tr>
            ';
            if($i>1){
                for($i=1;$i<=$longeur;$i++){
                    if($idDesProduits[$i] != ""){
                        echo '
                        <tr>
                            <td>'.$this->getNomProduit($idDesProduits[$i]).'</td>
                            <td>'.$LiDesQuantite[$i].'</td>
                        </tr>
                        ';
                    }
                    
                }
            }
            
        }
    }
    private function getNomProduit($idp){
        $res = $this->pdo->prepare("select label from produit where id = ?");
        $res->execute(array($idp));
        return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["label"];
    }

    function detaillesTotales($idc){
        $res = $this->pdo->prepare("select id from order_vente where idc = ?");
        $res->execute(array($idc));
        $r = $res->fetchAll(PDO::FETCH_ASSOC);
        $idOV = array();
        $i=0;
        foreach($r as $row){
            $idOV[$i] = $row['id'];
            $i++;
        }
        foreach($idOV as $idov){
            $res = $this->pdo->prepare("select sum(montantpayee) from facilite where idov = ? ");
            $res->execute(array($idov));
            $TotaleRecue = floatval($res->fetchAll(PDO::FETCH_ASSOC)["0"]["sum(montantpayee)"]);
            $res = $this->pdo->prepare("select * from order_vente where id = ?");
            $res->execute(array($idov));
            $det = $res->fetchAll(PDO::FETCH_ASSOC)["0"];
            $idDesProduits = explode("|",$det["listeidp"]);
            $LiDesQuantite = explode("|",$det["listeqte"]);
            $longeur = count($idDesProduits)-1;
            $resteTotale = floatval($det["prixTotale"])-floatval($TotaleRecue);
            echo '
            <tr>
				<td rowspan="'.$longeur.'">'.$det["id"].'</td>
				<td rowspan="'.$longeur.'">'.$det["date"].'</td>
				<td>'.$this->getNomProduit($idDesProduits[0]).'</td>
				<td>'.$LiDesQuantite[0].'</td>
				<td rowspan="'.$longeur.'">'.$det["prixTotale"].' DT</td>
				<td rowspan="'.$longeur.'">'.$TotaleRecue.' DT</td>
				<td rowspan="'.$longeur.'">'.$resteTotale.' DT</td>
			</tr>
            ';
            if($i>1){
                for($i=1;$i<=$longeur;$i++){
                    if($idDesProduits[$i] != ""){
                        echo '
                        <tr>
                            <td>'.$this->getNomProduit($idDesProduits[$i]).'</td>
                            <td>'.$LiDesQuantite[$i].'</td>
                        </tr>
                        ';
                    }
                    
                }
            }
            
        }
    }
    function HistoriquePayment($idc){
        $res = $this->pdo->prepare("select * from facilite where idc = ?");
        $res->execute(array($idc));
        $r = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($r as $row) {
            echo '
                <tr>
                    <th>'.$row['id'].'</th>
                    <th>'.$row['idov'].'</th>
                    <th>'.$row['date'].'</th>
                    <th>'.$row['montantpayee'].' DT</th>
                </tr>
            
            ';
        }
    }
}
?>