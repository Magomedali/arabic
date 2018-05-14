<?php

namespace backend\modules\users;

use Yii;

class Users extends \yii\base\Module
{

	public $modelNamespace = '';

    public $customViews = [];

    public $customMailViews = [];

    public $mailViewPath = '';

    /**
     * Constructor.
     * @param string $id the ID of this module.
     * @param Module $parent the parent module (if any).
     * @param array $config name-value pairs that will be used to initialize the object properties.
     */
    public function __construct($id, $parent = null, $config = [])
    {
        $this->id = $id;
        $this->module = $parent;

        $config_local = require(__DIR__ . '/config/config.php');
        $config = array_merge($config_local,$config);
        
        parent::__construct($id,$parent,$config);
    }


    public function init()
    {	

        parent::init();
        self::registerTranslations();
    }



    public static function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['users']) && !isset(Yii::$app->i18n->translations['users/*'])) {
            Yii::$app->i18n->translations['users'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@backend/modules/users/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'users' => 'users.php'
                ]
            ];
        }
    }



    public function getCustomView($default)
    {
        if (isset($this->customViews[$default])) {
            return $this->customViews[$default];
        } else {
            return $default;
        }
    }

    public function getCustomMailView($default)
    {
        if (isset($this->customMailViews[$default])) {
            return $this->customMailViews[$default];
        } else {
            return $this->mailViewPath . $default;
        }
    }
}
