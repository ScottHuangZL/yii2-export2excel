Yii2 Export2Excel
============
A behavior to export Yii2 query to excel and auto download

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require scotthuangzl/yii2-export2excel "dev-master"
```

or add

```
"scotthuangzl/yii2-export2excel": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

In any of your controller:


```php
	use scotthuangzl\export2excel\Export2ExcelBehavior;
	public function behaviors()
		{
		//above is your existing behaviors
		//new add export2excel behaviors
				'export2excel' => [
					'class' => Export2ExcelBehavior::className(),
	                //            'prefixStr' => yii::$app->user->identity->username,
                    //            'suffixStr' => date('Ymd-His'),
				],
		}
	
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
			//new add download action
            'download' => [
                'class' => 'scotthuangzl\export2excel\DownloadAction',
            ],
        ];
    }
	
	//In any of your actions:
	public function actionYoursAnyAction(){
//... your other code
        //test export2excel behavior
        $excel_data = Export2ExcelBehavior::excelDataFormat(EOPStatus::find()->asArray()->all());
        $excel_title = $excel_data['excel_title'];
        $excel_ceils = $excel_data['excel_ceils'];
        $excel_content = array(
            array(
                'sheet_name' => 'EOPStatus',
                'sheet_title' => $excel_title,
                'ceils' => $excel_ceils,
                'freezePane' => 'B2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => array(
                    'id' => Export2ExcelBehavior::getCssClass('blue'),
                    'Status_Description' => Export2ExcelBehavior::getCssClass('grey'),
                ), //define each column's cssClass for header line only.  You can set as blank.
                'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
                'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
            ),
            array(
                'sheet_name' => 'Important Note',
                'sheet_title' => array("Important Note For Region Template"),
                'ceils' => array(
                    array("1.Column Platform,Part,Region must need update.")
                , array("2.Column Regional_Status only as Regional_Green,Regional_Yellow,Regional_Red,Regional_Ready.")
                , array("3.Column RTS_Date, Master_Desc, Functional_Desc, Commodity, Part_Status are only for your reference, will not be uploaded into NPI tracking system."))
            ),
        );
        $excel_file = "testYii2Save2Excel";
        $this->export2excel($excel_content, $excel_file);
//... your other code
	}
	
```

Sample picture
-----
Please find from:
[Yii2 Export2Excel Extension](http://www.yiiframework.com/extension/yii2-export2excel/).
