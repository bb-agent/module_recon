<?
$mod_name="recon";
$mod_version="1.2";
$mod_path="/usr/share/blackbulb/www/modules/$mod_name";
$mod_logs="$log_path/$mod_name.log"; 
$mod_logs_history="$mod_path/includes/logs/";
$mod_panel="show";
//$mod_isup="ls /var/www/$mod_name";
$mod_isup="ps auxww | grep -E 'mitmdump.+inject_recon' | grep -v -e grep";
$mod_alias="Recon";
# EXEC
$bin_danger = "/usr/share/blackbulb/bin/danger";
$bin_sudo = "/usr/bin/sudo";
$bin_mitmproxy = "/usr/local/bin/mitmdump";
$bin_iptables = "/sbin/iptables";
$bin_awk = "/usr/bin/awk";
$bin_grep = "/bin/grep";
$bin_sed = "/bin/sed";
$bin_conntrack = "/usr/sbin/conntrack";
$bin_cat = "/bin/cat";
$bin_echo = "/bin/echo";
$bin_ln = "/bin/ln";
$bin_killall = "/usr/bin/killall";
?>
