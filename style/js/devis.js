
function GetData(type,geturl){
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": geturl,
        "method": "GET",
        "headers": {
            "content-type": "application/x-www-form-urlencoded"
        }
    }
    $.ajax(settings).done(function (response) {
        if(type=="1"){
            document.form1.prixv.value = response;
        }else{
            document.form1.qtemax.value= response;
        }
    });
}

function SetValues(){
    GetData("1","api/POSTS/journal.php?getPrix&idp=" + document.form1.idp.value);
    GetData("0","api/POSTS/journal.php?getMaxQte&idp=" + document.form1.idp.value);
}

function addElement(parentId, elementTag, elementId, html) {
// Adds an element to the document
    var p = document.getElementById(parentId);
    var newElement = document.createElement(elementTag);
    newElement.setAttribute('id', elementId);
    newElement.innerHTML = html;
    p.appendChild(newElement);

}

function addProduct(){
    var produit = document.form1.idp;
    var idProduit = document.form1.idp.value;
    var NomProduit = produit.options[produit.selectedIndex].text;
    var qte = document.form1.qte.value;
    var prixv  = document.form1.prixv.value;
    var qtemax = document.form1.qtemax.value;
    var listeIDP = document.form1.listeidp.value;
    var listeqte = document.form1.listeqte.value;
    var n = listeIDP.indexOf(idProduit+'|');
    var n2 = listeIDP.indexOf('|'+idProduit+'|');
    if((n!=-1) || (n2!=-1)){
        alert("Produit Deja Choisi");
        return false;
    }

    //test si la quantité a une valeur valid , non vide ou nigative ou 0
    if(qte == "" || Number(qte)<=0){
        alert("quantité invalid");
        return false;
    }
    //test si la quantité a ajouter existe dans le stock ou nn :
    var row = '<tr class="col-sm-12" id='+ idProduit +'> <td>'+ NomProduit +'</td><td>'+ qte +'</td> <td>'+ Number(prixv) +' DT</td> <td>'+ Number(prixv)*Number(qte) +' DT</td></tr>';
    addElement("items", "tr", "row", row);
    document.form1.prixtotal.value = Number(document.form1.prixtotal.value) + Number(prixv) * Number(qte);
    document.form1.listeidp.value = listeIDP + idProduit  +'|'; 
    document.form1.listeqte.value = listeqte + qte + '|';
    document.form1.qte.value="1";
}

function changeTVA(){
    prixtotale = document.form1.prixtotal.value;

    if(document.form1.tva == "1"){
        document.form1.prixtotal.value = Number(prixtotale);
    }else{
        document.form1.prixtotal.value = Number(prixtotale) + (Number(prixtotale) * 0.19);
    }
}

