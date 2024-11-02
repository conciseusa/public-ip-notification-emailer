<?php

include_once('../config/ip-config.php'); // locate in parent of checkout dir so a git pull will not have a conflict
if(!isset($msg_salt)) {
    echo 'config missing or malformed.';
    exit;
}


if(isset($_GET['loc']) && (preg_match('/^[a-zA-Z0-9]+$/', $_GET['loc']) > 0)) $loc = $_GET['loc'];
else $loc = FALSE;

if(isset($_GET['id']) && (preg_match('/^[a-zA-Z0-9]+$/', $_GET['id']) > 0)) $loc = $_GET['id'];
else $id = FALSE;

if(isset($_GET['cc']) && (preg_match('/^[a-zA-Z0-9]+$/', $_GET['cc']) > 0)) $cc = $_GET['cc'];
else $cc = FALSE;

if(isset($_GET['lanip']) && (preg_match('/^[a-zA-Z0-9.:]+$/', $_GET['lanip']) > 0)) $lanip = $_GET['lanip'];
else $lanip = FALSE;

if(!isset($_SERVER['REMOTE_ADDR'])) {
    echo 'Missing REMOTE Data.';
    exit;
}

if(!$loc || !$cc) {
    echo 'Missing Data.'.$loc.$cc;
    exit;
}

if($cc !== sha1($loc.$msg_salt)) {
    echo 'BCC.';
    exit;
}

echo 'SIP';

print_r(SQLite3::version());
class MyDB extends SQLite3 {
    function __construct() {
        $this->open('../config/ip-data.db');
    }
}

$db = new MyDB();
if(!$db) {
    echo $db->lastErrorMsg();
} else {
    echo "Opened database successfully\n";
}

// create table if not exists TableName (col1 typ1, ..., colN typN)


$sql =<<<EOF
    CREATE TABLE IF NOT EXISTS IPADDRS
    (ID INT PRIMARY KEY     NOT NULL,
    NAME           TEXT    NOT NULL,
    AGE            INT     NOT NULL,
    ADDRESS        CHAR(50),
    SALARY         REAL);
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Table created successfully\n";
   }
   $db->close();

if($to) {
    $to      = $to_email;
    $subject = $loc;
    if($id) $subject .= ' id: '.$id;
    $subject .= ' = '.$_SERVER['REMOTE_ADDR'];
    $message = $loc.' = '.$_SERVER['REMOTE_ADDR']."\r\n".date(DATE_RFC2822);
    if($lanip) $message .= "\r\n lanip: ".$lanip;
    $headers = 'From: '.$from_email."\r\n".
	       'Reply-To: '.$from_email."\r\n".
           'X-Mailer: PHP/'.phpversion();

    mail($to, $subject, $message, $headers);
}
