var Server;
var connect = 0;

$(document).ready(function() {

	console.log('Connecting...');
	// Server = new FancyWebSocket('ws://192.168.1.123:4000');
	Server = new FancyWebSocket('ws://121.40.231.46:4000');
	//Let the user know we're connected
	Server.bind('open', function() {
		console.log( "Connected." );
		// $('#check_connect').val(1)
		connect = 1;
	});

	//OH NOES! Disconnection occurred.
	Server.bind('close', function( data ) {
		// $.get('http://localhost/wg_tys/PigCms/Lib/ORG/Sorcket/server.php',function(data){
		// 	console.log(data);
		// })
		// $.get('http://mhyy.tzwg.net/PigCms/Lib/ORG/Sorcket/server.php',function(data){
		// 	console.log(data);
		// })
		console.log( "Disconnected." );
	});

	Server.connect();
});

function send( text ) {
  Server.send( 'message', text );
}
