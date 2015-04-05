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
