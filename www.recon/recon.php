<?

function regex_standard($var) {    
    $regex = "/(?i)(^[a-z0-9]{1,20})|(^$)/";
    if (preg_match($regex, $var) == 0) {
		echo "_error_";
        exit;
    } 
}

$client_conn = $_GET["client_conn"];
$server = $_SERVER["SERVER_ADDR"];

regex_standard($client_conn);

?>
<script src='jquery.js'></script>
<script src='inject.js'></script>
<script>searchIP('<?=$client_conn; ?>');</script>
