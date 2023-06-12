<?php
error_reporting(E_ALL);

require_once '../../includes/config.php';
require_once '../../includes/sql_builder/idiorm.php';
require_once '../../includes/db.php';
require_once '../../includes/functions/func.global.php';
/*require_once '../../includes/functions/func.users.php';
require_once '../../includes/functions/func.customers.php';
require_once '../../includes/functions/func.sqlquery.php';*/

//$debug = isset($_GET['debug']);
$debug = 1;
$url = "{$config['site_url']}mailing-list" . ($debug ? "?debug=yes" : "");
$output = CUrlFetch::fetchURL($url, $debug);
if($debug) echo $output;

file_put_contents("cron-log.txt", date("Y-m-d H:i:s") . "\r\n---------\r\n" . $output);

//*********************************************************************************************/
//**FETCH URL USING CURL**/
class CUrlFetch{
    public static function fetchURL($url, $output = 0){
        // Initiate the curl session
        $ch = curl_init();
        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $url);
        // Removes the headers from the output
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // Return the output instead of displaying it directly
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Execute the curl session
        $output = curl_exec($ch);
        // Close the curl session
        curl_close($ch);
        // Return the output as a variable
        if(isset($output) && $output)
            return $output;
    }
}
?>