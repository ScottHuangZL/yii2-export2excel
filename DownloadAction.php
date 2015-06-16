<?php
/**
 * User: Scott_Huang
 * Date: 6/16/2015
 * Time: 5:48 PM
 */

namespace scotthuangzl\export2excel;

use Yii;
use yii\base\Action;
class DownloadAction extends Action
{
    public function run($file_name, $file_type = 'excel', $deleteAfterDownload = false) {
        if (empty($file_name)) {
//            return $this->goBack();
            return 0;
        }
        $baseRoot = Yii::getAlias('@webroot') . "/uploads/";
        $file_name = $baseRoot . $file_name;
        //echo $file_name,"<BR/>";
        if (!file_exists($file_name)) {
            //HzlUtil::setMsg("Error", "File not exist");
            return 0;
        }
        $fp = fopen($file_name, "r");
        $file_size = filesize($file_name);
//下载文件需要用到的头
        if ($file_type == 'excel') {
            header('Pragma: public');
            header('Expires: 0');
            header('Content-Encoding: none');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: public');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Description: File Transfer');
            Header("Content-Disposition: attachment; filename=" . basename($file_name));
            header('Content-Transfer-Encoding: binary');
            Header("Content-Length:" . $file_size);
        } else if ($file_type == 'picture') { //pictures
            Header("Content-Type:image/jpeg");
            Header("Accept-Ranges: bytes");
            Header("Content-Disposition: attachment; filename=" . basename($file_name));
            Header("Content-Length:" . $file_size);
        } else { //other files
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Content-Disposition: attachment; filename=" . basename($file_name));
            Header("Content-Length:" . $file_size);
        }

        $buffer = 1024;
        $file_count = 0;
//向浏览器返回数据
        while (!feof($fp) && $file_count < $file_size) {
            $file_con = fread($fp, $buffer);
            $file_count+=$buffer;
            echo $file_con;
        }
        //echo fread($fp, $file_size);
        fclose($fp);
        if ($deleteAfterDownload) {
            unlink($file_name);
        }
        return 1;
    }

}
