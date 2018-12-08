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
include "../../../login_check.php";
include "../../../config/config.php";
include "../_info_.php";
include "../../../functions.php";

//include "options_config.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["service"], "../msg.php", $regex_extra);
    regex_standard($_GET["action"], "../msg.php", $regex_extra);
    regex_standard($_GET["page"], "../msg.php", $regex_extra);
    regex_standard($io_action, "../msg.php", $regex_extra);
    regex_standard($_GET["mac"], "../msg.php", $regex_extra);
    regex_standard($_GET["install"], "../msg.php", $regex_extra);
}

$service = $_GET['service'];
$action = $_GET['action'];
$page = $_GET['page'];
$mac =  strtoupper($_GET['mac']);
$install = $_GET['install'];
$port = 9999;

if($service == $mod_name) {
    
    if ($action == "start") {
        
	// START MODULE
        
        // COPY LOG
        if ( 0 < filesize( $mod_logs ) ) {
            $exec = "cp $mod_logs $mod_logs_history/".gmdate("Ymd-H-i-s").".log";
            exec_blackbulb($exec);
            
            $exec = "echo '' > $mod_logs";
            exec_blackbulb($exec);
        }
	
	$exec = "chmod 777 ../www.recon/db/";
	exec_blackbulb($exec);
	
	$exec = "$bin_iptables -t nat -A PREROUTING -p tcp --destination-port 80 -j REDIRECT --to-port $port";
	exec_blackbulb($exec);
	
        $exec = "ln -s $mod_path/www.recon /var/www/recon";
        exec_blackbulb($exec);
		
		//$exec = "$bin_mitmproxy -T --host -s 'inject_recon.py $io_in_ip' > /dev/null 2 &";
		$exec = "$bin_mitmproxy --port $port -T --host -s 'inject_recon.py $io_in_ip' >> $mod_logs &";
        exec_blackbulb($exec);
		
    } else if($action == "stop") {
	
		// STOP MODULE
        
		$exec = "$bin_iptables -t nat -D PREROUTING -p tcp --destination-port 80 -j REDIRECT --to-port $port";
		exec_blackbulb($exec);
		
        $exec = "rm /var/www/recon";
        exec_blackbulb($exec);
		
		$exec = "ps aux|grep -E 'mitmdump.+inject_recon' | grep -v grep | awk '{print $2}'";
		exec($exec,$output);
		
		$exec = "kill " . $output[0];
		exec_blackbulb($exec);
	
		// COPY LOG
        if ( 0 < filesize( $mod_logs ) ) {
            $exec = "cp $mod_logs $mod_logs_history/".gmdate("Ymd-H-i-s").".log";
            exec_blackbulb($exec);
            
            $exec = "echo '' > $mod_logs";
            exec_blackbulb($exec);
        }
	
    }

}

if ($install == "install_$mod_name") {

    $exec = "chmod 755 install.sh";
    exec_blackbulb($exec);
    
    $exec = "$bin_sudo ./install.sh > $log_path/install.txt &";
    exec_blackbulb($exec);

    header("Location: ../../install.php?module=$mod_name");
    exit;
}

$filename = $file_users;

if ($page == "status") {
    header('Location: ../../../action.php');
} else {
    header("Location: ../../action.php?page=$mod_name");
}

?>
