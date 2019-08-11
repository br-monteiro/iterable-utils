<?php

use PHPUnit\Framework\TestCase as PHPUnit;
use HTR\Utils\Iterables\IterableUtils;

class IterableUtilsTest extends PHPUnit
{

    protected $arrayNumbersMock = [];
    protected $arrayWordsMock = [];
    protected $arrayLettersMock = [];

    public function setUp()
    {
        $this->arrayNumbersMock = [1, 2, 3, 4, 5];
        $this->arrayWordsMock = ['lorem', 'ipsum', 'dolor', 'sit', 'amet'];
        $this->arrayLettersMock = ['a', 'b', 'c', 'd', 'e'];
    }

    public function testSmokeTestForIterableUtilsClass()
    {
        $this->assertEquals(true, class_exists(IterableUtils::class), 'It Should be returns true if class exists');
    }

    public function testSmokeTestForMapMethod()
    {
        $this->assertEquals(true, method_exists(IterableUtils::class, 'map'), 'It should be returns true if method exists');
    }

    public function testReturnDoubleOfNumbersAccordingCallback()
    {
        $arrExepected = [2, 4, 6, 8, 10];
        $callback = function($value) {
            return $value * 2;
        };

        $arrResult = IterableUtils::map($this->arrayNumbersMock, $callback);

        $this->assertEquals($arrExepected, $arrResult, 'It should be returns an array with double values');
    }

    public function testReturnUppercaseLettersAccordingCallback()
    {
        $arrExepected = ['A', 'B', 'C', 'D', 'E'];
        $callback = function($value) {
            return strtoupper($value);
        };

        $arrResult = IterableUtils::map($this->arrayLettersMock, $callback);

        $this->assertEquals($arrExepected, $arrResult, 'It should be returns an array with the letters in uppercase');
    }

    public function testReturnUppercaseLettersConcatenatedWithIndexAccordingCallback()
    {
        $arrExepected = ['0A', '1B', '2C', '3D', '4E'];
        $callback = function($value, $index) {
            return $index . strtoupper($value);
        };

        $arrResult = IterableUtils::map($this->arrayLettersMock, $callback);

        $this->assertEquals($arrExepected, $arrResult, 'It should be returns an array with the letters in uppercase concatenated with index');
    }

    public function testReturnArrayWithNullInContentsWhenTheresNoReturnOnCallback()
    {
        $arrExepected = [null, null, null, null, null];
        $callback = function($value) {
            // there's no 'return'
        };

        $arrResult = IterableUtils::map($this->arrayNumbersMock, $callback);

        $this->assertEquals($arrExepected, $arrResult, "It should be returns an array with null values when there's no on callback");
    }

    public function testReturnAnEmptyArrayWhenAnEmptyArrayIsPassed()
    {
        $arrExepected = [];
        $callback = function($value) {
            return $value;
        };

        $arrResult = IterableUtils::map([], $callback);

        $this->assertEquals($arrExepected, $arrResult, 'It should be returns an empty array');
    }

    public function testSmokeTestForFindMethod()
    {
        $this->assertEquals(true, method_exists(IterableUtils::class, 'find'), 'It should be returns true if the find method exists');
    }

    public function testReturnAnResultIfTheConditionOfCallbackIsTruly()
    {
        $exepected = 'dolor';
        $callback = function($value) {
            return $value === 'dolor';
        };

        $result = IterableUtils::find($this->arrayWordsMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns "dolor"');
    }

    public function testReturnNullWhenTheConditionIsNotSatisfactory()
    {
        $exepected = null;
        $callback = function($value) {
            return $value === 'XXX';
        };

        $result = IterableUtils::find($this->arrayWordsMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns null when the condition is not satisfactory');
    }

    public function testReturnNullWhenAnEmptyArrayIsPassed()
    {
        $exepected = null;
        $callback = function($value) {
            return $value === 'XXX';
        };

        $result = IterableUtils::find([], $callback);

        $this->assertEquals($exepected, $result, 'It should be returns null when an empty array is passed');
    }

    public function testSmokeTestForFilterMethod()
    {
        $this->assertEquals(true, method_exists(IterableUtils::class, 'filter'), 'It should be returns true if the filter method exists');
    }

    public function testReturnFilteredArrayAccordingCallback()
    {
        $exepected = [1, 3, 5];
        $callback = function($value) {
            return $value % 2 != 0;
        };

        $result = IterableUtils::filter($this->arrayNumbersMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns an array with odd numbers');

        $exepected = ['lorem', 'ipsum'];
        $callback = function($value) {
            return (bool) preg_match('/.*m$/', $value);
        };

        $result = IterableUtils::filter($this->arrayWordsMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns an array with lorem, ipsum values');
    }

    public function testReturnAnEmptyArrayWhenTheCallbackTheresNoReturn()
    {
        $exepected = [];
        $callback = function($value) {
            // there's no 'return'
        };

        $result = IterableUtils::filter($this->arrayNumbersMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns an empty array');
    }

    public function testSmokeTestForOnlyMethod()
    {
        $this->assertEquals(true, method_exists(IterableUtils::class, 'only'), 'It should be returns true if the only method exists');
    }

    public function testReturnTrueIfValueExistsOnceInArray()
    {
        $exepected = true;
        $callback = function($value) {
            return $value === 'c';
        };

        $result = IterableUtils::only($this->arrayLettersMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns true if the condition of callback is accepted');
    }

    public function testReturnFalseIfValueNotExistsOnceInArray()
    {
        $exepected = false;
        $callback = function($value) {
            return $value === 'Not Exists';
        };

        $result = IterableUtils::only($this->arrayLettersMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns false if the condition of callback is not accepted');
    }

    public function testReturnFalseIfInArrayContainsOneOrMoreValuesEqual()
    {
        $exepected = false;
        $arrWithTwoC = $this->arrayLettersMock;
        $arrWithTwoC[] = 'c';
        $callback = function($value) {
            return $value === 'c';
        };

        $result = IterableUtils::only($arrWithTwoC, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns false if exists one or more values equal in array');
    }

    public function testReturnFalseWhenTheCallbackTheresNoReturn()
    {
        $exepected = false;
        $callback = function($value) {
            // there's no 'return'
        };

        $result = IterableUtils::only($this->arrayLettersMock, $callback);

        $this->assertEquals($exepected, $result, "It should be returns false when in callback there's nos");
    }

    public function testSmokeTestForInAllMethod()
    {
        $this->assertEquals(true, method_exists(IterableUtils::class, 'even'), 'It should be returns true if the even method exists');
    }

    public function testReturnFalseWhenAnEmptyArrayIsPassedByParameter()
    {
        $exepected = false;
        $arrMock = [];

        $callback = function($value) {
            return $value === 'test';
        };

        $result = IterableUtils::even($arrMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns false when an empty array is passed by parameter');
    }

    public function testReturnFalseTheCallbackPassedByParameterInInAllTheresNoReturn()
    {
        $exepected = false;

        $callback = function($value) {
            // there's no 'return'
        };

        $result = IterableUtils::even($this->arrayNumbersMock, $callback);

        $this->assertEquals($exepected, $result, "It should be returns false when the callback there's no");
    }

    public function testReturnTrueIfTheValueExistsInAllElementsOfArrayAccordingCallbackConditions()
    {
        $exepected = true;
        $arrMock = [];
        for ($i = 0; $i < 5; $i++) {
            $object = new \stdClass();
            $object->attribA = time();
            $object->attribB = 'even value';
            $arrMock[] = $object;
        }

        $callback = function($value) {
            return $value->attribB === 'even value';
        };

        $result = IterableUtils::even($arrMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns true if the value exists in all elements of array');
    }

    public function testReturnFalseIfTheValueNotExistsInAllElementsOfArrayAccordingCallbackConditions()
    {
        $exepected = false;
        $arrMock = [];
        for ($i = 0; $i < 5; $i++) {
            $object = new \stdClass();
            $object->attribA = time();
            $object->attribB = 'even value';
            $arrMock[] = $object;
        }

        $callback = function($value) {
            return $value->attribA === "there's no attribute in A";
        };

        $result = IterableUtils::even($arrMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns false if the value not exists in all elements of array');
    }

    public function testSmokeTestForLastMethod()
    {
        $this->assertEquals(true, method_exists(IterableUtils::class, 'last'), 'It should be returns true if the last method exists');
    }

    public function testReturnTheLastValueFound()
    {
        $exepected = ['B', 4];
        $arrMock = [
            ['A', 1],
            ['B', 2],
            ['C', 3],
            ['B', 4]
        ];

        $callback = function($value) {
            return $value[0] === 'B';
        };

        $result = IterableUtils::last($arrMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns ["B", 4] if this is the last element found');
    }

    public function testReturnNullIfTheElementIsNotFound()
    {
        $exepected = null;

        $callback = function($value) {
            return $value === 'No Have';
        };

        $result = IterableUtils::last($this->arrayLettersMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns null if the element is not found');
    }

    public function testReturnNullWhenEmptyArrayIsPassedByParameter()
    {
        $exepected = null;
        $arrMock = [];

        $callback = function($value) {
            return $value === 'test';
        };

        $result = IterableUtils::last($arrMock, $callback);

        $this->assertEquals($exepected, $result, 'It should be returns null when an empty array is passed by parameter');
    }

    public function testReturnNullWhenTheCallbackTheresNoReturn()
    {
        $exepected = null;

        $callback = function($value) {
            // there's no 'return'
        };

        $result = IterableUtils::last($this->arrayNumbersMock, $callback);

        $this->assertEquals($exepected, $result, "It should be returns null when the callback there's no");
    }
}
