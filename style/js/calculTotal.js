function calcul()
{
//x=document.getElementById("prixachat");p=(1*x.value); // le prix
//x=document.getElementById("qte").value;s=(1*x.value); // le taux de TVA
//t=(p*s); // On calcule
t=document.getElementById("prixachat").value*document.getElementById("qte").value;
x=document.getElementById("prixtotal");x.value=t; // On affecte
};
