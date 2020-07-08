<?php
use Illuminate\Support\Carbon;
//use Config;
/**
 * Return a Carbon instance.
 */
function carbon(string $parseString = '', string $tz = null): Carbon
{
    return new Carbon($parseString, $tz);
}
/**
 * Return a formatted Carbon date.
 */
function humanize_date(Carbon $date, string $format = 'd F Y, H:i'): string
{
    return $date->format($format);
}

/**
 * Return a Combo status.
 */
function globalStatus(): array
{
    $rsAr = [];
    foreach (Config::get('settings.GLOBAL_STATUS') as  $status) {
        $rsAr[$status['code']] = $status['name'];
    }
    return $rsAr;
}

/**
 * Return a formatted name status.
 */
function nameStatus($code ): string
{
    $rsSt = '';
    $tmpGlobalStatus = globalStatus();
    if(isset($tmpGlobalStatus[$code]))
    {
        $rsSt = $tmpGlobalStatus[$code];
    }
    return $rsSt;
}


function nameHtmlStatus($code ): string
{
    $rsSt = '';
    $tmpGlobalStatus = globalStatus();
    if(isset($tmpGlobalStatus[$code]))
    {
        $rsSt = $tmpGlobalStatus[$code];
        if($rsSt==Config::get('settings.GLOBAL_STATUS.DISABLED.name') || $rsSt==Config::get('settings.GLOBAL_STATUS.SOLD.name')){
            $rsSt='<span style="color:red">'.$rsSt.'</span>';
        }
    }
    return $rsSt;
}
/**
 * Return a Combo status.
 */
function globalApprove(): array
{
    $rsAr_ = [];
    foreach (Config::get('settings.GLOBAL_APPROVE') as  $approve) {
        $rsAr_[$approve['code']] = $approve['name'];
    }
    return $rsAr_;
}



/**
 * Return a formatted name status.
 */
function nameApprove($code ): string
{
    $rsApprove = '';
    $tmpGlobalApprove = globalApprove();
    if(isset($tmpGlobalApprove[$code]))
    {
        $rsApprove = $tmpGlobalApprove[$code];
    }
    return $rsApprove;
}


function nameHtmlApprove($code ): string
{
    $rsApprove = '';
    $tmpGlobalApprove = globalApprove();
    if(isset($tmpGlobalApprove[$code]))
    {
        $rsApprove = $tmpGlobalApprove[$code];
        if($rsApprove==Config::get('settings.GLOBAL_APPROVE.DISABLED.name')){
            $rsApprove='<span style="color:red">'.$rsApprove.'</span>';
        }
    }
    return $rsApprove;
}

/**
 * Return a Combo status.
 */
function globalUserType(): array
{
    $rsAr = [];
    foreach (Config::get('settings.USER_TYPE') as  $status) {
        $rsAr[$status['code']] = $status['name'];
    }
    return $rsAr;
}

/**
 * Return a formatted name status.
 */
function nameUserType($code ): string
{
    $rsUt = '';
    $tmpGlobalUserType = globalUserType();
    if(isset($tmpGlobalUserType[$code]))
    {
        $rsUt = $tmpGlobalUserType[$code];
    }
    return $rsUt;
}

function nameHtmlUsertype($code ): string
{
    $rsUserType = '';
    $tmpGlobalUserType = globalUserType();
    if(isset($tmpGlobalUserType[$code]))
    {
        $rsUserType = $tmpGlobalUserType[$code];
        if($rsUserType==Config::get('settings.GLOBAL_APPROVE.DISABLED.name')){
            $rsUserType='<span style="color:red">'.$rsUserType.'</span>';
        }
    }
    return $rsUserType;
}


