
//Συναρτηση Ελεγχου πληθους γραμματων σε text
function LengthCheck(objID){
    //Αρχικοποιηση μεταβλητων
    var objValue=objID.value; //Η τιμη του objID
    var objStyle="" //Μεταβληξτηγια το αμα ειναι στηλη η γραμμη 
    
    switch (objID){                         /*Case για την ευρεση αμα μιλαμε για σειρα η στηλη */
        case moveRow:
            objStyle="για την γραμμη"; 
            break;
        case moveCell:
            objStyle="για την στηλη";
            break;
    }

    if (objValue.length!=1 || objValue==""){  //ελεγχος για το πληθος των γραμματων
        objValue="";
        alert("Δωσε εναν αριθμο "+objStyle);
        return false;     
    }
    return true;
    
}
//Συναρτηση Ελεγχου Τιμης 
function CheckValue(objID) {
    if (objID==moveRow){                       //Ελεγχος για πιο Obj μιλαμε
        var RowValue=parseInt(objID.value);
        if (isNaN(RowValue)){                  //Ελεγχος για αμα δωσει κενο μετα το parse το καινο μετατρεπεται σε NaN στοιχειο
            return false;
        }
        if ((RowValue<=-1) || (RowValue>=6)){  //Ελεγχος για την τιμη του Row
            alert ("Τιμη πανω απο τα ορια 0-5");
            //objValue="";
            return false;
        }
    }else{
        var CellValue=parseInt(objID.value);  
        if (isNaN(CellValue)){                  //Ελεγχος για αμα δωσει κενο μετα το parse το καινο μετατρεπεται σε NaN στοιχειο
            return false;
        }
        if ((CellValue<=-1) || (CellValue>=7)){     //Ελεγχος για την τιμη του Cell
            alert ("Τιμη πανω απο τα ορια 0-6");
            objValue="";
            return false;
            
        }
    }       
    return true;

}




/* Μεθοδος για το αμαη τιμη του tag με id moveID (input-text) ειναι επιτρεπτη */
function CheckParameters (){ 
    var textRowID=document.getElementById('moveRow'); //ID row
    var textCellID=document.getElementById('moveCell'); //ID cell
    LengthCheck(textRowID);
    LengthCheck(textCellID);
    if (!CheckValue(textRowID)){ //ΕΛεγχος για αμα δωθει λαθος τιμη να ξαναγινει το text κενο
        textRowID.value="";
    }    
    if (!CheckValue(textCellID)){  //ΕΛεγχος για αμα δωθει λαθος τιμη να ξαναγινει το text κενο
        textCellID.value="";
    } 
    return true; 


    /* ΚΩΔΙΚΑ ΓΙΑ HTML ESCAPING */
}
