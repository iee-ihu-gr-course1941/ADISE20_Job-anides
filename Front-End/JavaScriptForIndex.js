
var me={};
var game_status={};
var board={};
var last_update=new Date().getTime();
var timer=null;

$(function (){
    createTable();
    fill_board();
    
    $("#login").click(login_to_game);
    $('#reset').click( reset_board);
    $('#move').click( make_move);
	$('#moveDiv').hide();
    game_status_update();
    

  
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
    var u=$('#username').val();
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
            headers: {"X-Token": me.token},
			contentType: 'application/json',
			data: JSON.stringify( {username: u, player_colour: p_color}),
			success: login_result,
			error: login_error});
}

//Επιτυχης Εισοδος στο παιχνιδι
function login_result(data) {
	me = data[0];
    $('#loginDiv').hide();
	update_info();
	game_status_update();
}

//Αποτυχημενη Συνδεση στο παιχνιδι
function login_error(data,y,z,c) {
    var x = data.responseJSON;
	alert(x.errormesg);
}


//Ενημερωνει το παιδιο με id gameinfoDiv το ποιος παιχτης παιζει
function update_info(){
	$('#gameinfoDiv').html("I am Player: "+me.player_colour+", my name is "+me.username +'<br>Token='+me.token+'<br>Game state: '+game_status.status+', '+ game_status.player_turn+' must play now.');

}


//Μεταφορα δεδο με json 
function game_status_update() {
    clearTimeout(timer);
	$.ajax({url: "../Back-End/Score4.php/status/", success: update_status, headers: {"X-Token": me.token} });
}

//Κανη update το status του παιχνιδιου 
function update_status(data) {
    last_update=new Date().getTime();
    var game_status_old=game_status;
	game_status=data[0];
	update_info();
	if(game_status.player_turn==me.player_colour &&  me.player_colour!='') { //ισως χρειαστη αλλαγη σε null
		x=0;
        // do play
        if (game_status_old.player_turn!=me.player_colour){
            fill_board();
        }
		$('#moveDiv').show(1000);
		setTimeout(function() { game_status_update();}, 15000);
	} else {
		// must wait for something
		$('#moveDiv').hide(1000);
		setTimeout(function() { game_status_update();}, 4000);
	}
 	
}

//Δημιουργια πινακα
function createTable(){
        var t='<table id="table">';
        for (var row=0 ; row<6 ; row++){
            t += '<tr>';
            for (var cell=0 ; cell<7 ; cell++){
                t+= '<td  id="cell_'+row+'_'+cell+'"> Στηλη: '+cell+'</td>'; 
            }
            t+='</tr>';
        }
        t+='</table>';
        $('#tableDiv').html(t);
}        

//Περασμα το json αρχειου με get 
function fill_board(){
  // $.ajax({url:"../Back-End/Score4.php/board/", success: fill_board_by_data});
   $.ajax({url: "../Back-End/Score4.php/board/", 
		headers: {"X-Token": me.token},
			//dataType: "json",
			//contentType: 'application/json',
			//data: JSON.stringify( {token: me.token}),
			success: fill_board_by_data });
       
}

function fill_board() {
	$.ajax({url: "../Back-End/Score4.php/board/", 
		headers: {"X-Token": me.token},
		success: fill_board_by_data });
}

//Γεμισμα του board με τα χτοιχεια απο το json αρχειο που επεστρεψε η fill_board()[method:get] 
function fill_board_by_data(data){
    board=data;
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

//Φερνει τον πινακα στην default morfh toy (default_game_board) στην βαση
function reset_board() {
	$.ajax({url: "../Back-End/Score4.php/board/", method: 'POST',  success: fill_board_by_data });
	$('#moveDiv').hide();
	$('#loginDiv').show(2000);

}

//Αποστολη την κινησης
function make_move(){
    CheckValue()
    var move=$('#moveCell').val();
    $.ajax({url:"../Back-End/Score4.php/board/column/"+move,
            method: 'PUT',
            dataType: "json",
            contentType: 'application/json',
            data: JSON.stringify( {cell: move}),
            headers: {"X-Token": me.token},
            success: move_result,
            error: login_error});

}

//Εμφανιση κινησης
function move_result(data){
    game_status_update();
	fill_board_by_data(data);
}
