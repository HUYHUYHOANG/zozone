<?php
/*$output = shell_exec('crontab -l');
echo '<br/>setup cron tab content:';
$cron_file = "/tmp/crontab.txt";
// Command
$cmd = "1 * * * * /opt/psa/admin/sbin/fetch_url 'https://demo.zozone.de/temp/cron.php'";
file_put_contents($cron_file, $output.$cmd.PHP_EOL);
// Thực hiện Cronjob
exec("crontab $cron_file");
echo 'done';
*/

$cmd = "* 1 * * * " . PHP_BINARY . " " . __DIR__ . "/cron.php";
$cmd = "*/5 * * * * " . PHP_BINARY . "/var/www/vhosts/hosting174889.ae810.netcup.net/zozone.de/httpdocs/php/ctrls/cron.php";


//echo 'delete cmd : ... ';
//echo CronShell::deleteCron($cmd);

echo '<Br/>LIST:<br>';

CronShell::listCrons();

//0 22 * * 1-5  --> At 22:00 on every day-of-week from Monday through Friday.
echo "<br/>Add: " . $cmd;
echo " : ";
echo CronShell::addCron($cmd) ? ' ok'  : ' failed';
die;

class CronShell{
    public static function addCron($cmd){
        if(self::cronExists($cmd)){
            //echo "<br/>command exists...<br/>"; return false;
        }
        $output = @shell_exec('crontab -l');
        $cron_file = "/tmp/crontab.txt";
        //@file_put_contents($cron_file, $output.$cmd.PHP_EOL);
        @file_put_contents($cron_file, $cmd.PHP_EOL);
        @exec("crontab {$cron_file}");
        return true;
    }

    public static function listCrons(){
        @exec('crontab -l', $crontab);
        //Find command
        if(is_array($crontab)){
            print_r($crontab);
        }
    }

    public static function cronExists($cmd){
        $cronjob_exists=false;
        
        @exec('crontab -l', $crontab);
        
        if(isset($crontab)&&is_array($crontab)){
            $crontab = array_flip($crontab);
            if(isset($crontab[$cmd])){
                $cronjob_exists=true;
            }
        }
        return $cronjob_exists;
    }

    public static function deleteCron($cmd){
        @exec('crontab -l', $crontab);
        //Find command
        if(is_array($crontab)){
            $key = array_search($cmd, $crontab);
            unset($crontab[$key]);
            echo '<br/>---------------------------';
            print_r($crontab);
            echo '---------------------------';
            echo 'delete by key ' . $key;
        }else echo 'not found';
        $cron_file = "/tmp/crontab.txt";
        @file_put_contents($cron_file, implode(PHP_EOL,$crontab));
        @exec("crontab $cron_file");
    }
}
?>