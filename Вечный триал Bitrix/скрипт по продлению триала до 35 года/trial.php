<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

$CHKSTR =  "ET04IS00X1IR2T1I7B";
$CHKSTR2 = "a1B7Ra01Ka2d4A0Bra0";
$NEWDATE = "12312035";  // 31 декабря 2035 года
$CHKSTR[6]  = $NEWDATE[0];
$CHKSTR[16] = $NEWDATE[1];
$CHKSTR[9]  = $NEWDATE[2];
$CHKSTR[2]  = $NEWDATE[3];
$CHKSTR[12] = $NEWDATE[4];
$CHKSTR[7]  = $NEWDATE[5];
$CHKSTR[14] = $NEWDATE[6];
$CHKSTR[3]  = $NEWDATE[7];
$CHKSTR2[6]  = $NEWDATE[0];
$CHKSTR2[3]  = $NEWDATE[1];
$CHKSTR2[1]  = $NEWDATE[2];
$CHKSTR2[14] = $NEWDATE[3];
$CHKSTR2[10] = $NEWDATE[4];
$CHKSTR2[18] = $NEWDATE[5];
$CHKSTR2[7]  = $NEWDATE[6];
$CHKSTR2[12] = $NEWDATE[7];
$keystr  = 'DO_NOT_STEAL_OUR_BUS';
$keystr2 = 'thRH4u67fhw87V7Hyr12Hwy0rFr';
$i = 0;
$i2 = 0;
$STRSTR = '';
$STRSTR2 = '';
for ($ii = 0; $ii < strlen($CHKSTR); $ii++)
{
        $STRSTR  .= chr(ord($CHKSTR[$ii]) ^ ord($keystr[$i]));
        if ($i == strlen($keystr)-1) $i = 0;
        else $i++;
}
for ($ii = 0; $ii < strlen($CHKSTR2); $ii++)
{
        $STRSTR2 .= chr(ord($CHKSTR2[$ii]) ^ ord($keystr2[$i2]));
        if ($i2 == strlen($keystr2)-1) $i2 = 0;
        else $i2++;
}
COption :: SetOptionString("main","admin_passwordh",base64_encode($STRSTR2));
file_put_contents("./bitrix/modules/main/admin/define.php", '<?define("TEMPORARY_CACHE", "'.base64_encode($STRSTR).'");?>');
echo '<br><br><br>***OptionString***<br>'.base64_encode($STRSTR2).'<br>';
echo '<br><br><br>***TEMPORARY_CACHE***<br>'.base64_encode($STRSTR).'<br>';
echo '<br><br><br> test test test test test';

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>