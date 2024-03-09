<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Prices;
use app\models\Months;
use app\models\CalculatorForm;
use yii\console\widgets\Table;


class CalculateController extends Controller
{
    public $month;
    public $type;
    public $tonnage;

    public function options($actionId)
    {
        return ['type', 'month', 'tonnage'];
    }


    public function actionIndex()
    {
        $modelConsole = new CalculatorForm;
        //пусто
        if ($this->type == null) {
            echo "не введен тип!";
            die;
        } elseif ($this->month == null) {
            echo "не введен месяц!";
            die;
        } elseif ($this->tonnage == null) {
            echo "не введен тоннаж!";
            die;
        }
        //валидация c ошибкой
        if ($this->type !== 'шрот' && $this->type !== 'соя' && $this->type !== 'жмых') {
            echo "Неправильный ввод --type проверьте корректность";
            die;
        } elseif ($this->tonnage !== '25' && $this->tonnage !== '50' && $this->tonnage !== '75' && $this->tonnage !== '100') {
            echo "Неправильный ввод --tonnage проверьте корректность";
            die;
        } elseif ($this->month !== 'январь' && $this->month !== 'февраль' && $this->month !== 'август' && $this->month !== 'сентябрь' && $this->month !== 'октябрь' && $this->month !== 'ноябрь') {
            echo "Неправильный ввод --month проверьте корректность";
            die;
        }

        $modelConsole->type = $this->type;
        $modelConsole->tonnage = $this->tonnage;
        $modelConsole->month = $this->month;

        //вывод
        echo "Месяц - " . $this->month . PHP_EOL;
        echo "Тип - " . $this->type . PHP_EOL;
        echo "Тоннаж - " . $this->tonnage . PHP_EOL;
        //вывод результата
        $result = Prices::find()
            ->joinWith(['months', 'tonnages', 'raw_types'])
            ->select('price')
            ->where(
                [
                    'raw_types.name' => $modelConsole->type,
                    'months.name' => $modelConsole->month,
                    'tonnages.value' => $modelConsole->tonnage
                ]
            )
            ->scalar();
        echo "Результат - " . $result . PHP_EOL;
        // вывод таблицы 
        $list = Prices::find()
            ->JoinWith(['months', 'tonnages', 'raw_types'])
            ->select(['month' => 'months.name', 'tonnage' => 'tonnages.value', 'price'])
            ->where(['raw_types.name' => $modelConsole->type])
            ->asArray()
            ->all();

        foreach ($list as $key => $value) {
            $pr[$value["tonnage"]] = $value["price"];
            $listResult[$value["month"]] = $pr;
        }
        echo PHP_EOL . '+----------+----+----+----+-----+' . PHP_EOL;
        echo '| М\Т      | 25 | 50 | 75 | 100 |';
        foreach ($listResult as $key => $value) {
            echo PHP_EOL . "+----------+----+----+----+-----+" . PHP_EOL;
            echo "| $key |";
            foreach ($value as $price) {
                echo " $price |";
            }
        }
        echo PHP_EOL . "+----------+----+----+----+-----+" . PHP_EOL;
    }
}

// yii calculate --month=январь --tonnage=25 --type=жмых