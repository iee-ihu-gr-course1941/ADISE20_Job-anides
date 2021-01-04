


//$("#submitID").click(CheckValue); // Χρηση JQuery για οταν πατηθει το submit 

$(function (){
    createTable();
    fill_board();
   // $("#submitID").click(CheckValue); // Χρηση JQuery για οταν πατηθει το submit
});

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
        var t='<table id="table">';
        for (var row=6 ; row>0 ; row--){
            t += '<tr>';
            for (var cell=0 ; cell<7 ; cell++){
                t+= '<td  id="cell_'+row+'_'+cell+'"></td>'; 
            }
            t+='</tr>';
        }
        t+='</table>';
        // var p='<p id="playertrun">Παιζει πρωτος ο κιτρινος!</p>';
        //$('#tableDiv').html(p);
        $('#tableDiv').html(t);
}        

//Περασμα το json αρχειου
function fill_board(){
   $.ajax({url:"Score4.php/board/", success: fill_board_by_data});
       
}

function fill_board_by_data(data){
    for (var item=0 ; item<data.length ; item++){

    }
}



//Γεμισμα του κελιου με το καταληλο χρωμα
/* function ColorisedTheCell(){
    var cell=document.getElementById('moveCell').value; //Το κελι
    var row= //Η γραμμη που θα χρωματιστει
    var player= //ο παιχτης που παιζει
    var tableID=document.getElementById('table');

    switch (player){
        case 'r':
            tableID.rows[row].cells[cell].style.backgroundColor="red";
            break;
        case 'w':
            tableID.rows[row].cells[cell].style.backgroundColor="yellow";
            break;
    }
    
    }
    
} */ 



//Ελεγχος για το αμα τελειωσε το παιχνιδι


//Αποστολη την κινησης

