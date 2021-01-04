
var me={};


$(function (){
    //createTable();
    //fill_board();
    $("#login").click(login_to_game);
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


//Εισοδος στο παιχνιδι
function login_to_game() {
	if($('#username').val()=='') {
		alert('You have to set a username');
		return;
	}
	var p_color = $('#pcolor').val();
	createTable()
	fill_board();	
	$.ajax({url: "../Back-End/Score4.php/players/"+p_color, 
			method: 'PUT',
			dataType: "json",
			contentType: 'application/json',
			data: JSON.stringify( {username: $('#username').val(), player_colour: p_color}),
			success: login_result,
			error: login_error});
}

//Επιτυχης Εισοδος στο παιχνιδι
function login_result(data) {
	me = data[0];
	$('#loginDiv').hide();
	//update_info();
	//game_status_update();
}

//Αποτυχημενη Συνδεση στο παιχνιδι
function login_error(data,y,z,c) {
	var x = data.responseJSON;
	alert(x.errormesg);
}

//function update_info(){
//	$('#game_info').html("I am Player: "+me.piece_color+", my name is "+me.username +'<br>Token='+me.token+'<br>Game state: '+game_status.status+', '+ game_status.p_turn+' must play now.');

//Δημιουργια πινακα
function createTable(){
        var t='<table id="table">';
        for (var row=5 ; row>-1 ; row--){
            t += '<tr>';
            for (var cell=0 ; cell<7 ; cell++){
                t+= '<td  id="cell_'+row+'_'+cell+'">  Στηλη: '+cell+'</td>'; 
            }
            t+='</tr>';
        }
        t+='</table>';
        $('#tableDiv').html(t);
}        

//Περασμα το json αρχειου με get 
function fill_board(){
   $.ajax({url:"../Back-End/Score4.php/board/", success: fill_board_by_data});
       
}

//Γεμισμα του board με τα χτοιχεια απο το json αρχειο που επεστρεψε η fill_board()[method:get] 
function fill_board_by_data(data){
    for (var i=0 ; i<data.length ; i++){
        var item=data[i];
        var id='#cell_'+ item.row + '_' + item.column;
        var color=item.tile_colour;
        switch (color){
            case '':
                $(id).css("background-color","white");
                break;
            case 'r':
                $(id).css("background-color","red");
                $(id).text("");
                break;
            case 'y':
                $(id).css("background-color","yellow");
                $(id).text("");
                break;
        }

    }
}






//Ελεγχος για το αμα τελειωσε το παιχνιδι


//Αποστολη την κινησης

