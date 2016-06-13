<?
/*
    Copyright (C) 2013-2016 xtr4nge [_AT_] gmail.com

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
include "../../../login_check.php";
include "../../../config/config.php";
include "../../../functions.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["type"], "../../../msg.php", $regex_extra);
    regex_standard($_GET["id_details"], "../../../msg.php", $regex_extra);
}

?>

<link rel="stylesheet" href="../../css/jquery-ui.css" />
<link rel="stylesheet" href="../../css/style.css" />
<link rel="stylesheet" href="../../../../style.css" />

<?

function sec_cleanHTML($var) {
	$var = str_replace("'", "", $var);
	//return htmlentities($var);
    return htmlspecialchars($var);
}

function sec_cleanTAGS($var) {
	$var = strip_tags($var);
	$var = str_replace("'", "", $var);
	$var = str_replace("\"", "", $var);
	$var = str_replace(";", "", $var);
	return strip_tags($var);
}

function getDetails() {
    // Create (connect to) SQLite database in file

    $file_db = new PDO('sqlite:db/db.sqlite3');
    // Set errormode to exceptions
    //$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT * FROM details ORDER BY time DESC;";
    
    $result = $file_db->query($sql);
    
    //print_r($result);
    
    $rowarray = $result->fetchall(PDO::FETCH_ASSOC);
    
    echo "<table class='general'>";
    echo "  <tr>
                <td><b>time</b></td>
                <td><b>remote_addr</b></td>
                <td><b>remote_mac</b></td>
                <td><b>plugins</b></td>
            </tr>";
    foreach($rowarray as $row) {
        $p_id = sec_cleanHTML($row["id"]);
        $p_remote_addr = sec_cleanHTML($row["remote_addr"]); // user_agent, remote_addr, remote_mac, time
        $p_remote_mac = sec_cleanHTML($row["remote_mac"]);
        $p_user_agent = sec_cleanHTML($row["user_agent"]);
        $p_time = sec_cleanHTML($row["time"]);
        echo "<tr>
            <td style='background-color:#DDD; padding-right:10px' nowrap>$p_time</td>
            <td style='background-color:#DDD; padding-right:10px' nowrap>$p_remote_addr</td>
            <td style='background-color:#DDD; padding-right:10px'><a href='output.php?type=getclientdetails&id_details=$p_id'>$p_remote_mac</a></td>
            <td style='background-color:#DDD; padding-right:10px'><a href='output.php?type=getplugins&id_details=$p_id'>plugins</a></td>
        </tr>";
    }
    echo "</table>";
    
    $file_db = null;
}

function getClientDetails($id_details) {
    // Create (connect to) SQLite database in file

    $file_db = new PDO('sqlite:db/db.sqlite3');
    // Set errormode to exceptions
    //$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT * FROM details WHERE id = '$id_details';";
    
    $result = $file_db->query($sql);
    
    //print_r($result);
    
    $rowarray = $result->fetchall(PDO::FETCH_ASSOC);
    
    
    echo "<table class='general'>";
    /*
    echo "  <tr>
                <td><b>time</b></td>
                <td><b>remote_addr</b></td>
                <td><b>remote_mac</b></td>
                <td><b>plugins</b></td>
            </tr>";
    */
    foreach($rowarray as $row) {
        $p_id = sec_cleanHTML($row["id"]);
        $p_remote_addr = sec_cleanHTML($row["remote_addr"]); // user_agent, remote_addr, remote_mac, time
        $p_remote_mac = sec_cleanHTML($row["remote_mac"]);
        $p_user_agent = sec_cleanHTML($row["user_agent"]);
        $p_time = sec_cleanHTML($row["time"]);
        /*
        echo "<div>";
        echo "<b>time:</b> " . $p_time . "<br>";
        echo "<b>remote_addr:</b> " . $p_remote_addr . "<br>";
        echo "<b>remote_mac:</b> " . $p_remote_mac . "<br>";
        echo "<b>user_agent:</b> " . $p_user_agent . "<br>";
        echo "</div>";
        */
        /*
        echo "<tr>
                <td style='background-color:#DDD; padding-right:10px' nowrap>$p_time</td>
                <td style='background-color:#DDD; padding-right:10px' nowrap>$p_remote_addr</td>
                <td style='background-color:#DDD; padding-right:10px'>$p_remote_mac</td>
                <td style='background-color:#DDD; padding-right:10px'><a href='output.php?type=getplugins&id_details=$p_id'>plugins</a></td>
            </tr>";
        */  
        echo "
            <tr>
                <td style='background-color:#DDD; padding-right:10px'>time</td>
                <td style='background-color:#DDD; padding-right:10px'>$p_time</td>
            </tr>
            <tr>
                <td style='background-color:#DDD; padding-right:10px'>remote_addr</td>
                <td style='background-color:#DDD; padding-right:10px'>$p_remote_addr</td>
            </tr>
            <tr>
                <td style='background-color:#DDD; padding-right:10px'>remote_mac</td>
                <td style='background-color:#DDD; padding-right:10px'>$p_remote_mac</td>
            </tr>
            <tr>
                <td style='background-color:#DDD; padding-right:10px'>user_agent</td>
                <td style='background-color:#DDD; padding-right:10px'>$p_user_agent</td>
            </tr>
            ";
        
    }
    echo "</table>";
    
    $file_db = null;
}

function getPlugins($id_details) {
    // Create (connect to) SQLite database in file

    $file_db = new PDO('sqlite:db/db.sqlite3');
    // Set errormode to exceptions
    //$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT * FROM plugins ORDER BY time DESC;";
    $sql = "SELECT * FROM plugins WHERE id_details = '$id_details';";
    
    $result = $file_db->query($sql);
    
    $rowarray = $result->fetchall(PDO::FETCH_ASSOC);
    
    echo "<table>";
    echo "  <tr>
                <td><b>time</b></td>
                <td><b>name</b></td>
                <td><b>filename</b></td>
                <td><b>version</b></td>
            </tr>";
    foreach($rowarray as $row) {
        $p_name = sec_cleanHTML($row["name"]);
        $p_filename = sec_cleanHTML($row["filename"]);
        $p_description = sec_cleanHTML($row["description"]);
        $p_version = sec_cleanHTML($row["version"]);
        $p_time = sec_cleanHTML($row["time"]);
        echo "<tr>
            <td style='background-color:#DDD; padding-right:10px' nowrap>$p_time</td>
            <td style='background-color:#DDD; padding-right:10px'>$p_name</td>
            <td style='background-color:#DDD; padding-right:10px'>$p_filename</td>
            <td style='background-color:#DDD; padding-right:10px'>$p_version</td>
        </tr>";
    }
    echo "</table>";
    
    $file_db = null;
}

function sqlAddPlugins() {
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:db/db.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                           PDO::ERRMODE_EXCEPTION);
    
    $p_name = sec_cleanTAGS($_POST["p_name"]);
    $p_filename = sec_cleanTAGS($_POST["p_filename"]);
    $p_description = sec_cleanTAGS($_POST["p_description"]);
    $p_version = sec_cleanTAGS($_POST["p_version"]);
    $p_time = sec_cleanTAGS($_POST["p_time"]);
    
    $p_name = sec_cleanTAGS($_GET["p_name"]);
    $p_filename = sec_cleanTAGS($_GET["p_filename"]);
    $p_description = sec_cleanTAGS($_GET["p_description"]);
    $p_version = sec_cleanTAGS($_GET["p_version"]);
    $p_time = sec_cleanTAGS($_GET["p_time"]);
    
    $sql = "INSERT INTO plugins 
            (name, filename, description, version, time) 
            values 
            ('$p_name', '$p_filename', '$p_description', '$p_version', '$p_time');";
    
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

function searchClient() {
    $file_db = new PDO('sqlite:db/db.sqlite3');
    // Set errormode to exceptions
    
    $sql = "SELECT * FROM details;";
    
    $result = $file_db->query($sql);
    
    print_r($result);
}

$type = $_GET["type"];
$id_details = $_GET["id_details"];

if($type == "getplugins") {
    getPlugins($id_details);
} else if($type == "getclientdetails") {
    getClientDetails($id_details);
} else {
    getDetails();
}
?>