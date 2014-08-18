Yii2 Brazilian Validators
=========================

Yii2 Extension that provide validators and features for brazilian localization

* CPF: Cadastro de pessoa física (like a Security Social Numeber in USA) 
* CNPJ: Cadastro nacional de pessoa jurídica 
* CEI: Cadastro específico no INSS (número de matrícula)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiibr/yii2-br-validator "*"
```

or add

```
"yiibr/yii2-br-validator": "*"
```

to the require section of your `composer.json` file.

Usage
-----
Add the rules as the following example


```php

use Yii;
use yii\base\Model;
use yiibr\brvalidator\CpfValidator;
use yiibr\brvalidator\CnpjValidator;
use yiibr\brvalidator\CeiValidator;

class PersonForm extends Model
{
	public $name;
	public $cpf;
	public $cnpj;
	public $cei;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			// name is required
			['name', 'required'],
			// cpf validator
			['cpf', CpfValidator::className()],
			// cnpj validator
			['cnpj', CnpjValidator::className()],
			// cei validator
			['cei', CeiValidator::className()]
		];
	}
}
```
