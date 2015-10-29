<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('dateNow')){
	function dateNow($withtime=FALSE)
	{
		date_default_timezone_set('Asia/Jakarta');
		$str_format='';
		if($withtime==FALSE)
		{
			$str_format= date("Y-m-d");
		}else{
			$str_format= date("Y-m-d H:i:s");
		}
		return $str_format;
	}
}

if(!function_exists('dateString')){
	function dateString($tanggal)
	{
		$format = array(
		'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 'Apr' => 'April', 'May' => 'Mei', 'Jun' => 'Juni', 'Jul' => 'Juli', 'Aug' => 'Agustus', 'Sep' => 'September', 'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember'
		);
		$tanggal = date('d M Y', strtotime($tanggal));			
		return strtr($tanggal, $format);
	}
}

if(!function_exists('dateAddDay')){
	function dateAddDay($tgl,$days)
	{
		$date = new DateTime($tgl);
		$date->add(new DateInterval('P'.$days.'D'));
		$Date2 = $date->format('Y-m-d');
		return $Date2;
	}
}

if(!function_exists('dateAddYear')){
	function dateAddYear($tgl,$days)
	{
		$date = new DateTime($tgl);
		$date->add(new DateInterval('P'.$days.'Y'));
		$Date2 = $date->format('Y-m-d');
		return $Date2;
	}
}

if(!function_exists('dateTimeNow')){
	function dateTimeNow()
	{
		date_default_timezone_set('Asia/Jakarta');
		$str_format='';
		$str_format= date("H:i:s");

		return $str_format;
	}
}

if(!function_exists('dateIndoFormat')){
	function dateIndoFormat($datetime='',$withTime=FALSE)
	{
		$str_original_format=$datetime;
		$str_convert_format='';
		date_default_timezone_set('Asia/Jakarta');
		if(!empty($datetime) && $withTime==TRUE)
		{
			$str_convert_format=date('d M Y H:i:s',strtotime($datetime));
		}elseif(!empty($datetime) && $withTime==FALSE)
		{
			$str_convert_format=date('d M Y',strtotime($datetime));
		}else{
			$str_convert_format=date('d M Y H:i:s',strtotime(date("Y-m-d H:i:s")));
		}
		return $str_convert_format;
	}
}

if(!function_exists('dateDiff')){
	function dateDiff($date_1 , $date_2 , $differenceFormat = '%a')
	{
	  	$datetime1 = date_create($date_1);
		$datetime2 = date_create($date_2);

		$interval = date_diff($datetime1, $datetime2);

		return $interval->format($differenceFormat);
	}
}

if(!function_exists('dateMonthName')){
	function dateMonthName($mons)
	{
		$mons = array(1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember");

		$date = getdate();
		$month = $date['mon'];

		$month_name = $mons[$month];

		return $month_name;
	}
}

?>