<?php 
//非覆盖式文件md5批量打包工具 @author bajian
$path='resource/';//要打包文件目录
$targetPath='result/';//打包后文件目录
$filesnames = scandir($path);

echo "begin! \n";
$count=count($filesnames);
for ($i=0; $i <$count ; $i++) { 
	$filePath=$path.$filesnames[$i];
	$pathinfo = pathinfo($filePath);
	$rsa=md5_file($filePath);
	if ($rsa) {
		$newName=$pathinfo['filename'].'-'.$rsa.'.'.$pathinfo['extension'];
		copy($filePath,$targetPath.$newName);
		echo $newName." complete \n";
	}

}
echo "total complete! \n";
 ?>