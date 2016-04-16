<?php 
//2.0增加uglifyjs2.0压缩160416 考虑到合并js的话全量更新很浪费用户流量，建议使用分开打包
//非覆盖式文件md5(考虑到md5太长，且更新版本并不多,取前五位就足够了)批量打包工具 @author bajian
include("lib/uglifyjs.php");
define('RESOURCE_DIR', 'resource/');//要打包文件目录
define('RESULT_DIR', 'result/');//打包后文件目录
define('OUTPUT',true);//输出打包后js

echo "begin! \n";
// packJs(true);
packJs();
echo "total complete! \n";

	/**
	 * @params isMerge 是否合并js，默认不合并
	 */
	function packJs($isMerge=false){
		$path=RESOURCE_DIR;
		$filesnames = scandir($path);
		$count=count($filesnames);
	if ($isMerge) {//合并js
		$compiler=getUglifyJS();
		for ($i=0; $i <$count ; $i++) {
			$filePath=$path.$filesnames[$i];
			$pathinfo = pathinfo($filePath);
			if (!$pathinfo['extension']) continue;
			$compiler->add($filePath);
		}
		$compiler->write(OUTPUT);
	}else{//分开压缩js
		for ($i=0; $i <$count ; $i++) {
			$compiler=getUglifyJS();
			$filePath=$path.$filesnames[$i];
			$pathinfo = pathinfo($filePath);
			if (!$pathinfo['extension']) continue;
			$rsa=substr(md5_file($filePath),0,5);
			$compiler->add($filePath);
			if ($rsa) {
				$newName=$pathinfo['filename'].'.min_'.$rsa.'.'.$pathinfo['extension'];
				$compiler->setCacheFileName(RESULT_DIR.$newName);
				$compiler->write(OUTPUT);
			}
		}
	}
}

function getUglifyJS(){
	$compiler= new UglifyJS();
	return $compiler->cacheDir(RESULT_DIR);
}
?>
