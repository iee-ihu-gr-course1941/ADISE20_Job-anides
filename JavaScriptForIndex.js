



/* Μεθοδος ελεγχου της τιμης του tag με id moveID (input-text) */
function CheckValue (){ 
    var textRowID=document.getElementById('moveRow'); //ID row
    var textRowValue=textBoxID.value; //row value
    var textCellID=document.getElementById('moveCell'); //ID cell
    var textCellValue=textCellID.value; //cell value 
    // Ελεγχος για αμα το textRowValue ειναι πανω απο τα αρηθμιτηκα ορια
    var RowValue=parseInt(textRowValue);
    if ((RowValue<-1) || (RowValue>6)){
        alert ("Τιμη πανω απο τα ορια 0-5");
        return false;
    }
    // Ελεγχος για αμα το textCellValue ειναι πανω απο τα αρηθμιτηκα ορια
    var CellValue=parseInt(textCellValue);
    if ((CellValue<-1) || (CellValue>7)){
        alert ("Τιμη πανω απο τα ορια 0-6");
        return false;
    }
    return true;
}
