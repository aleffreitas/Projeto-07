function valida(){
    var frase=document.getElementById('usuario').value;
    if(frase.length>=3){
        document.getElementById('usuario').style.borderColor = "green";
        document.getElementById('cod').style.visibility="hidden";                    					
            return true;
    }else{					
        document.getElementById('cod').style.visibility="visible";
        document.getElementById('cod').style.color="red";
        document.getElementById('cod').style.fontSize="13px";
        document.getElementById('usuario').style.borderColor = "red";								
        return false;	
    }
    
}

function colore(){
    var frase=document.getElementById('senha').value;
    if(frase.length!=0){
        document.getElementById('senha').style.borderColor = "green";                           					
            return true;
    }else{	
        document.getElementById('senha').style.borderColor = "red";						
        return false;	
    }
}