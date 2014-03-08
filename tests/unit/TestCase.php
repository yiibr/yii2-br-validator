<?php

namespace leandrogehlen\brvalidator\tests\unit;

use yiiext\brvalidation\CpfValidator;
use yii\helpers\ArrayHelper;
use Yii;


/**
 * This is the base class for all brvalidator unit tests.
 */
class TestCase extends \PHPUnit_Framework_TestCase
{			
			
	/**
	 * This method is called before the first test of this test class is run.
	 * Attempts to load vendor autoloader.
	 * @throws \yii\base\NotSupportedException
	 */
	public static function setUpBeforeClass()
	{
				
		$vendorDir = __DIR__ . '/../../vendor';		
		$vendorAutoload = $vendorDir . '/autoload.php';
		
		if (file_exists($vendorAutoload)) {
			require_once($vendorAutoload);
		} else {
			throw new NotSupportedException("Vendor autoload file '{$vendorAutoload}' is missing.");
		}
		
		require_once($vendorDir . '/yiisoft/yii2/Yii.php');		
		Yii::setAlias('@vendor', $vendorDir);		
		
	}
	
	/**
	 * Populates Yii::$app with a new application
	 * The application will be destroyed on tearDown() automatically.
	 * @param array $config The application configuration, if needed
	 * @param string $appClass name of the application class to create
	 */
	protected function mockApplication($config = [], $appClass = '\yii\console\Application')
	{
		static $defaultConfig = [
			'id' => 'testapp',
			'basePath' => __DIR__,
		];
		$defaultConfig['vendorPath'] = dirname(dirname(__DIR__)) . '/vendor';		
	
		new $appClass(ArrayHelper::merge($defaultConfig, $config));
	}
	
	protected function setUp()
	{
		parent::setUp();
		$this->mockApplication();
	}
	
}

?>