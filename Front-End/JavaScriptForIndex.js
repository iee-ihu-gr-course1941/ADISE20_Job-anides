
//Συναρτηση Ελεγχου πληθους γραμματων σε text
function LengthCheck(objID){
    //Αρχικοποιηση μεταβλητων
    var objValue=objID.value; //Η τιμη του objID  

    if (objValue.length!=1 || objValue==""){  //ελεγχος για το πληθος των γραμματων
        return true;     
    }
    return false;
    
}

//Συναρτηση Ελεγχου Τιμης 
function CheckValue() {
    var cellID=document.getElementById('moveCell');                           
    var CellValue=parseInt(cellID.value);
    
    if ( (isNaN(CellValue)) || (LengthCheck(cellID)) || (CellValue<0) || (CellValue>6) ){
        alert("Λαθος Καταχωρηση! Δωσε σωστη τιμη στην στηλη!");
    }
    

           
    
}

//Δημιουργια πινακα
function createTable(){
        var tableDiv=document.getElementById('tableDiv'); 
        var p=document.createElement("p");
        p.setAttribute("id", "playerTurn");
        p.innerHTML="Παιζει ο πρωτος παιχτης";
        tableDiv.appendChild(p);
        var table=document.createElement("table");
        for (row=0;row<6;row++){
            var tr=document.createElement("tr");
            for (cell=0;cell<7;cell++){
                var td=document.createElement("td");
                tr.appendChild(td);
            }
            table.appendChild(tr);
        }
        tableDiv.appendChild(table);
        table.setAttribute("id", "table");
}        

//Γεμισμα του κελιου με το καταληλο χρωμα
//function ColorisedTheCell(){
  //  var cell=document.getElementById('moveCell').value; //Το κελι
    //var row= //Η γραμμη που θα χρωματιστει
    //var player= //ο παιχτης που παιζει
    //var tableID=document.getElementById('table');

   // if (player=='r'){
     //   tableID.rows[row].cells[cell].style.backgroundColor="red";
    //}else if (player=='y'){
     //   tableID.rows[row].cells[cell].style.backgroundColor="yellow";
    //}
    
//}


//Αποστολη την κινησης

