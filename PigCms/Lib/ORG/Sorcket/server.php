<?php
// prevent the server from timing out
set_time_limit(0);

// include the web sockets server script (the server is started at the far bottom of this file)
require 'class.PHPWebSocket.php';

// when a client sends data to the server
function wsOnMessage($clientID, $message, $messageLength, $binary) {
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	$data = json_decode($message);
	// $con = (array)$data[0];
	$client_object = (array)$data[1];

	// check if message length is 0
	if ($messageLength == 0) {
		$Server->wsClose($clientID);
		return;
	}

	$arr = array(
		'cid' => $clientID,
	);
	$mes2 = json_encode($arr);

	//The speaker is the only person in the room. Don't let them feel lonely.
	if ( sizeof($Server->wsClients) == 1 ){
		$Server->wsSend($clientID, $mes2);
	}
	else{
		if($client_object['ip'] == 'all'){
			foreach ( $Server->wsClients as $id => $client ){
				if ( $id != $clientID ){
					$Server->wsSend($id, $message);
				}
			}
		}else{
			//Send the message to everyone but the person who said it
			foreach ( $Server->wsClients as $id => $client ){
				if ( $id == $client_object['ip'] ){
					// $Server->wsSend($id, "Visitor $clientID ($ip) said \"$message\"");
					$Server->wsSend($id, $message);
				}
			}
				// if ( $id != $clientID )
				// 	$Server->wsSend($id, "Visitor $clientID ($ip) said \"$message\"");
		}
	}
}

// when a client connects
function wsOnOpen($clientID)
{
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	$Server->log( "$ip ($clientID) has connected.".date('Y-m-d H:i:s',time()));

	//Send a join notice to everyone but the person who joined
	$data = array(
		'clientID' => $clientID,
	);
	$message = json_encode($data);

	foreach ( $Server->wsClients as $id => $client )
	if ( $id != $clientID ){
		$Server->wsSend($id, $message);
		$Server->log($id, "Visitor $clientID ($ip) has joined the room.".date('Y-m-d H:i:s',time()));
	}else{
		$data = array(
			'myID' => $clientID,
		);
		$message = json_encode($data);
		$Server->wsSend($id, $message);
	}
}

// when a client closes or lost connection
function wsOnClose($clientID, $status) {
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	$Server->log( "$ip ($clientID) has disconnected.".date('Y-m-d H:i:s',time()));

	//Send a user left notice to everyone in the room
	foreach ( $Server->wsClients as $id => $client )
		$Server->log($id, "Visitor $clientID ($ip) has left the room.".date('Y-m-d H:i:s',time()));
}

// start the server
$Server = new PHPWebSocket();
$Server->bind('message', 'wsOnMessage');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');
// for other computers to connect, you will probably need to change this to your LAN IP or external IP,
// alternatively use: gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME']))
$result = $Server->wsStartServer('192.168.1.120', 4000);
// $result = $Server->wsStartServer('120.26.64.122', 4000);
// $result = $Server->wsStopServer();
return $result;

?>