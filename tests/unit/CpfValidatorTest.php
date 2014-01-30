<?php
namespace yiiext\brvalidation\tests\unit;

use yiiext\brvalidation\CpfValidator;
use yii\helpers\ArrayHelper;
use Yii;


/**
 * BooleanValidatorTest
 */
class CpfValidatorTest extends \PHPUnit_Framework_TestCase
{			
		
	
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

	public function testValidateValue()
	{
		$val = new CpfValidator();		
		$this->assertFalse($val->validate('11111111111'));
		$this->assertFalse($val->validate('22245181108'));
		
		$this->assertTrue($val->validate('222.451.811-07'));
		$this->assertTrue($val->validate('22245181107'));		
	}	
}

?>