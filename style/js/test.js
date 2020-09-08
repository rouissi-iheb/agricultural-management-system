$(document).ready(function(){

    $("#sip0").change(function() { 
        if($(this).val()=="1"){ 
            $("#qtemax0").attr("value","13"); 
            $("#prixv0").attr("value","20");
        } else if($(this).val()=="2"){
             $("#qtemax0").attr("value","56"); 
             $("#prixv0").attr("value","30"); 
        } else if($(this).val()=="3"){ 
            $("#qtemax0").attr("value","60"); 
            $("#prixv0").attr("value","10000"); 
        } else if($(this).val()=="4"){ 
            $("#qtemax0").attr("value","0"); 
            $("#prixv0").attr("value","200"); 
        } else if($(this).val()=="5"){ 
            $("#qtemax0").attr("value","0"); 
            $("#prixv0").attr("value","20"); 
        }
    });
    var sp1 =$("#sip1")
    sp1.change(function() { 
        var sip1 = $(this).val();
        var qtemax1 = $("#qtemax1");
        var prixv1 = $("#qtemax1");
        if(sip1=="1"){ 
            qtemax1.attr("value","13"); 
            prixv1.attr("value","20");
        } else if(sip1=="2"){
            qtemax1.attr("value","56"); 
            prixv1.attr("value","30"); 
        } else if(sip1=="3"){ 
            qtemax1.attr("value","60"); 
            prixv1.attr("value","10000"); 
        } else if(sip1=="4"){ 
            qtemax1.attr("value","0"); 
            prixv1.attr("value","200"); 
        } else if(sip1=="5"){ 
            qtemax1.attr("value","0"); 
            prixv1.attr("value","20"); 
        } 
    });



});