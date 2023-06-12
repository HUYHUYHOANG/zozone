<?php

function MakePrintString2($iRecLineChars, $strBuf, $strPrice)
{
    $strValue = '';
    $iSpace = $iRecLineChars - strlen($strBuf) - strlen($strPrice);
    $tab = "";
    if ($iSpace > 0) {
        while (strlen($tab) < $iSpace) {
            $tab = $tab . " ";
        }
    }
    $strValue = $strBuf . $tab . $strPrice;
    return $strValue;
}

function MakePrintString2HasWidth($iRecLineChars, $strBuf, $strBuf2)
{
    $strValue = '';
    $iSpaceForStrBuf = $iRecLineChars - strlen($strBuf2) * 2;
    $tab  = "";
    $i = 0;
    $k = 0;
    if ($iSpaceForStrBuf >= strlen($strBuf) * 2) {
        $k = ceil($iSpaceForStrBuf - strlen($strBuf) * 2) / 2 + 1;
        for ($i = 0; $i <= $k; $i++) {
            $tab = $tab . " ";
        }
    } else if ($iSpaceForStrBuf < strlen($strBuf) * 2) {
        $strBuf = substr($strBuf, 0, $iSpaceForStrBuf);
    }
    $strValue = $strBuf . $tab . $strBuf2;
    return $strValue;
}

function MakePrintString4($iRecLineChars, $str1, $str2, $str3, $str4, $bFormatToDecimal = True)
{
    $cDecimalSeparator = ",";
    $strValue = '';
    $iSpace1  = floor($iRecLineChars / 4);
    $iSpace2  = $iSpace1;
    $iSpace3  = $iSpace1;
    $iSpace4 = $iSpace1;

    if ($iSpace1 + $iSpace2 + $iSpace3 + $iSpace4 < $iRecLineChars) {
        $iSpace2 = $iSpace2 + 1;
    }

    if ($iSpace1 + $iSpace2 + $iSpace3 + $iSpace4 < $iRecLineChars) {
        $iSpace3 = $iSpace3 + 1;
    }

    if ($iSpace1 + $iSpace2 + $iSpace3 + $iSpace4 < $iRecLineChars) {
        $iSpace4 = $iSpace4 + 1;
    }

    if ($iSpace1 + $iSpace2 + $iSpace3 + $iSpace4 < $iRecLineChars) {
        $iSpace1 = $iSpace1 + 1;
    }

    $iSpace1 = $iSpace1 - 1;
    $iSpace2 = $iSpace2 + 1;

    if ($bFormatToDecimal = True) {
        if ($str2 <> "") {
            $str2 = str_replace(".", $cDecimalSeparator, $str2);
        }

        if ($str3 <> "") {
            $str3 = str_replace(".", $cDecimalSeparator, $str3);
        }


        if ($str4 <> "") {
            $str4 = str_replace(".", $cDecimalSeparator, $str4);
        }
    }
    $tab  = " ";
    while (strlen($str1) < $iSpace1) {
        $str1 = $str1 . $tab;
    }

    while (strlen($str2) < $iSpace2) {
        $str2 = $tab . $str2;
    }

    while (strlen($str3) < $iSpace3) {
        $str3 = $tab . $str3;
    }
    while (strlen($str4) < $iSpace4) {
        $str4 = $tab . $str4;
    }
    $strValue = $str1 . $str2 . $str3 . $str4;

    return $strValue;
}