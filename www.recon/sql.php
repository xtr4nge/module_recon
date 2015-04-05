<? 
/*
    Copyright (C) 2013-2015 xtr4nge [_AT_] gmail.com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 
?>
<?

function createDB() {
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:db/db.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                           PDO::ERRMODE_EXCEPTION);
     
    $file_db->exec("CREATE TABLE IF NOT EXISTS details (
                        id INTEGER PRIMARY KEY, 
                        remote_addr TEXT, 
                        remote_mac TEXT,
                        user_agent TEXT,
                        time INTEGER)");
    
    $file_db->exec("CREATE TABLE IF NOT EXISTS plugins (
                        id INTEGER PRIMARY KEY,
                        id_details INTEGER,
                        name TEXT, 
                        filename TEXT,
                        description TEXT,
                        version TEXT,
                        time INTEGER)");
    
    $file_db = null;
}

function sqlAddDetails() {
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:db/db.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                           PDO::ERRMODE_EXCEPTION);
    
    $p_user_agent = $_POST["p_user_agent"];
    $p_remote_addr = $_POST["p_remote_addr"];
    $p_remote_mac = $_POST["p_remote_mac"];
    $p_time = $_POST["p_time"];
    
    $sql = "INSERT INTO details 
            (user_agent, remote_addr, remote_mac, time) 
            values 
            ('$p_user_agent', '$p_remote_addr', '$p_remote_mac', '$p_time');";
    
    $file_db->exec($sql);
    
    $file_db = null;
}

function sqlAddPlugins($id_details) {
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:db/db.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $p_id_details = $_POST["p_id_details"];
    $p_name = $_POST["p_name"];
    $p_filename = $_POST["p_filename"];
    $p_description = $_POST["p_description"];
    $p_version = $_POST["p_version"];
    $p_time = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO plugins 
            (id_details, name, filename, description, version, time) 
            values 
            ('$p_id_details', '$p_name', '$p_filename', '$p_description', '$p_version', '$p_time');";
    
    $file_db->exec($sql);
    
    $file_db = null;
}

function fileAction() {
    
    $p_user_agent = $_POST["p_user_agent"];
    $p_remote_addr = $_POST["p_remote_addr"];
    $p_remote_mac = $_POST["p_remote_mac"];
    
    $myFile = "save.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    
    $stringData = $p_user_agent . "\n";
    fwrite($fh, $stringData);
    $stringData = $p_remote_addr . "\n";
    fwrite($fh, $stringData);
    $stringData = $p_remote_mac . "\n";
    fwrite($fh, $stringData);
    
    fclose($fh);
}

function getMacAddress($p_ip) {
    $path = "/usr/share/fruitywifi/logs/dhcp.leases";
    
    $exec = "grep '$p_ip' $path | awk {'print $2'}";
    exec($exec, $output);

    return $output[0];
}

function searchIP($client_conn) {
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:db/db.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $p_remote_mac = $_POST["p_remote_mac"];
    $p_time = date('Y-m-d H:i:s');
    
    $p_user_agent = $_SERVER['HTTP_USER_AGENT'];
    //$p_remote_addr = $_SERVER['REMOTE_ADDR'];
    $p_remote_addr = $client_conn;
    
    $p_remote_mac = getMacAddress($p_remote_addr);
    
    $sql = " SELECT count(*) as num FROM details WHERE remote_mac = '$p_remote_mac' AND user_agent = '$p_user_agent'; ";   
    $result = $file_db->query($sql);
    $row = $result->fetch(PDO::FETCH_NUM);
    
    if ($row[0] < 1) {
        
        //setDetails($p_remote_addr, $p_remote_mac, $p_user_agent);
        
        $sql = "INSERT INTO details 
                (user_agent, remote_addr, remote_mac, time) 
                values 
                ('$p_user_agent', '$p_remote_addr', '$p_remote_mac', '$p_time');";
        
        $file_db->exec($sql);
         
        $output[] = $file_db->lastInsertId();
        echo json_encode($output[0]);
    }

    $file_db = null;

}

function setDetails($p_remote_addr, $p_remote_mac, $p_user_agent) {

    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:db/db.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $p_time = date('Y-m-d H:i:s');
        
    $sql = "INSERT INTO details 
            (user_agent, remote_addr, remote_mac, time) 
            values 
            ('$p_user_agent', '$p_remote_addr', '$p_remote_mac', '$p_time');";
    
    $file_db->exec($sql);

    $file_db = null;
    
}

$p_type = $_POST["p_type"];
$client_conn = $_POST["client_conn"];

createDB();
if ($p_type == "details") {
    sqlAddDetails();    
} else if ($p_type == "plugins") {
    sqlAddPlugins();
} else if ($p_type == "searchIP") {
    searchIP($client_conn);
}
?>