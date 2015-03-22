
function sendDetails(p_user_agent, p_remote_addr, p_remote_mac, p_time) {
	
	var server = location.host;
	
	$.ajax({
		type: 'POST',
		url: 'http://'+server+'/recon/sql.php',
		data: 'p_type=details&p_user_agent='+p_user_agent+'&p_remote_addr='+p_remote_addr+'&p_remote_mac='+p_remote_mac+'&p_time='+p_time,
		dataType: 'json',
		success: function (data) {
			console.log(data);
			alert(p_name);
		}
	});
}

function searchIP(client_conn) {
	
	var server = location.host;
	
	$.ajax({
		type: 'POST',
		url: 'http://'+server+'/recon/sql.php',
		data: 'p_type=searchIP&client_conn='+client_conn,
		dataType: 'json',
		success: function (data) {
			//console.log(data);
			getPlugins(data, server)
			
		}
		
	});
		
}

function sendPlugins(p_id_details, p_name, p_filename, p_description, p_version, p_time) {
	
	var server = location.host;
	
	$.ajax({
		type: 'POST',
		url: 'http://'+server+'/recon/sql.php',
		data: 'p_type=plugins&p_name='+p_name+'&p_id_details='+p_id_details+'&p_filename='+p_filename+'&p_description='+p_description+'&p_version='+p_version+'&p_time='+p_time,
		dataType: 'json',
		success: function (data) {
			console.log(data);
			alert(p_name);
		}
	});
}

function getPlugins(id_details) {
	
	var server = location.host;
	
	//document.write(id_details);
	
	var L = navigator.plugins.length;
	
	document.write(
	  L.toString() + " Plugin(s)<br>" + "Name | Filename | description<br>"
	);
	
	p_time = "";
	
	for(var i = 0; i < L; i++) {
	  sendPlugins(id_details, navigator.plugins[i].name, navigator.plugins[i].filename, navigator.plugins[i].description, navigator.plugins[i].version, p_time);
	  
	  document.write(
		navigator.plugins[i].name +
		" | " +
		navigator.plugins[i].filename +
		" | " +
		navigator.plugins[i].description +
		" | " +
		navigator.plugins[i].version +
		"<br>"
	  );
	}
}

//searchIP(client_conn);
