Google Chart
============
A behavior to export Yii2 query to excel and auto download

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require scotthuangzl/yii2-export2excelt "dev-master"
```

or add

```
"scotthuangzl/yii2-export2excelt": "dev-master"
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
		//test export2excel behavior
        $excel_data = HzlUtil::excelDataFormat(EOPStatus::find()->asArray()->all()); //此处使用了上篇文章中说道的数据格式化类
        $excel_title = $excel_data['excel_title'];
        $excel_ceils = $excel_data['excel_ceils'];
        $excel_content = array(
            array(
                'sheet_name' => 'EOPStatus',
                'sheet_title' => $excel_title,
                'ceils' => $excel_ceils,
                'freezePane' => 'B2',
                'headerColor' => HzlUtil::getCssClass("header"),
                'headerColumnCssClass' => array(
                    'id' => HzlUtil::getCssClass('blue'),
                    'Status_Description' => HzlUtil::getCssClass('grey'),
                ), //define each column's cssClass for header line only.  You can set as blank.
                'oddCssClass' => HzlUtil::getCssClass("odd"),
                'evenCssClass' => HzlUtil::getCssClass("even"),
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
        echo "I am here1";
        $this->export2excel($excel_content, $excel_file);
        echo "I am here2";
	}
	
```

Sample picture
-----
You also can find the demo result from:

