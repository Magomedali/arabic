<?php 
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;

use common\models\Element as cElement;


class Element extends cElement
{


	public function uploadFile()
    {
        if ($this->type != self::TYPE_TEXT && $this->validate()) {

            $filePath = Yii::getAlias('@files').self::$FOLDERS[$this->type];


            if(!file_exists($filePath)){
                //если директория не существует, создаем директорию
                if(!mkdir($filePath)){
                    throw new Exception("Не удалось создать директорию для хранения файлов", 1);
                }
            }

            

            //Старый файл
            $old_file = $this->file_name;
            
           
            $file = $this->files;
            $basename = uniqid();
            $fName = $basename . '_'.time().'.' . $file->extension;
            $file->saveAs($filePath . $fName);
            $this->file_name = $fName;
            
            if($this->file_name && $old_file){
                $this->unlinkFile($old_file);
            }
            
            return $this->file_name;
        } else {
            return false;
        }

    }


    public function unlinkFile($file=null){
       
        

        if($this->type == self::TYPE_TEXT || !$file) return null;

        $filePath = Yii::getAlias('@files').self::$FOLDERS[$this->type];
        
        if(file_exists($filePath.$file)){
            unlink($filePath.$file);
            return true;
        }
        
        return false;
        
        
    }

	public function deleteElement(){
		
		if($this->type != self::TYPE_TEXT){
			$this->unlinkFile($this->file_name);
		}

		return $this->delete();
	}

}

?>