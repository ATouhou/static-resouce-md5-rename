<?php 
//非覆盖式文件md5(考虑到md5太长，且更新版本并不多,取前五位就足够了)批量打包工具 @author bajian
$path='resource/';//要打包文件目录
$targetPath='result/';//打包后文件目录
$filesnames = scandir($path);

echo "begin! \n";
$count=count($filesnames);
for ($i=0; $i <$count ; $i++) { 
	$filePath=$path.$filesnames[$i];
	$pathinfo = pathinfo($filePath);
	if (!$pathinfo['extension']) continue;
	$rsa=substr(md5_file($filePath),0,5);

	if ($rsa) {
		$newName=$pathinfo['filename'].'_'.$rsa.'.'.$pathinfo['extension'];
		copy($filePath,$targetPath.$newName);
		echo $newName." complete \n";
	}

}
echo "total complete! \n";
 ?>