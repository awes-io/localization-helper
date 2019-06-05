<?php

namespace AwesIO\LocalizationHelper\Tests;

use org\bovigo\vfs\vfsStream;

class StringUsageTest extends TestCase
{
    private $root;

    private $localizationFilePath;

    private $basePath = 'root/resources/lang';

    private $extension = '.php';

    /**
     * set up test environmemt
     */
    public function setUp() :void
    {
        parent::setUp();

        app('config')->set('app.debug', true);

        app('translator')->setFallback('en');

        app('config')->set('localizationhelper.base_path', vfsStream::url($this->basePath));

        $this->root = vfsStream::setup('root', null, 
            [
                'resources' => [
                    'lang' => [
                        'en' => []
                    ]
                ]
            ]
        );

        $this->localizationFilePath = $this->basePath . '/' 
            . app('translator')->getFallback() . '/' ;
    }

    public function testLocalizationFileNamedFromFirstKeyElementIsCreated()
    {
        $key = ($filename = uniqid()) . '.' . uniqid();

        $value = uniqid();

        $filePath = $this->localizationFilePath . $filename . $this->extension;

        $this->assertFalse($this->root->hasChild($filePath));

        _p($key, $value);

        $this->assertTrue($this->root->hasChild($filePath));
    }

    public function testFirstLevelLocalizationStringIsCreated()
    {
        $key = ($filename = uniqid()) . '.' . ($path = uniqid());

        $value = uniqid();

        _p($key, $value);

        $strings = eval('?>' . $this->getContents($filename));

        $this->assertEquals($strings[$path], $value);
    }

    public function testSecondLevelLocalizationStringIsCreated()
    {
        $key = ($filename = uniqid()) . '.' . ($path1 = uniqid()) . '.' . ($path2 = uniqid());

        $value = uniqid();

        _p($key, $value);

        $strings = eval('?>' . $this->getContents($filename));

        $this->assertEquals($strings[$path1][$path2], $value);
    }

    public function testDeepLocalizationStringIsCreated()
    {
        $array = array_map(function($e) {
            return uniqid();
        }, array_fill(0, rand(5, 20), 1));

        $path = implode('.', $array);

        $key = ($filename = uniqid()) . '.' . $path;

        $value = uniqid();

        _p($key, $value);

        $strings = eval('?>' . $this->getContents($filename));

        function iter($array, $keys)
        {
            if (empty($keys)) return $array;

            return iter($array[array_shift($keys)], $keys);
        }

        $this->assertEquals(iter($strings, $array), $value);
    }

    public function testExistingStringDoesntChangeToDefaultValue()
    {
        $key = ($filename = uniqid()) . '.' . ($path = uniqid());

        $value = uniqid();

        _p($key, $value);

        _p($key, 'newDefaultValue');

        $strings = eval('?>' . $this->getContents($filename));

        $this->assertEquals($strings[$path], $value);
    }

    public function testExistingStringValueReturned()
    {
        $key = ($filename = uniqid()) . '.' . ($path = uniqid());

        $value = uniqid();

        _p($key, $value);

        $this->assertEquals(_p($key, $value), $value);
    }

    public function testSupportsPlaceholders()
    {
        $path = 'mail.invitation';

        $default = ':company company workspace';

        _p($path, $default);

        $this->assertEquals(
            _p($path, $default, ['company' => 'AwesCRM']), 'AwesCRM company workspace');
    }

    public function testReturnsKeyIfDoesntExist()
    {
        $key = uniqid() . '.' . uniqid();

        $this->assertEquals(_p($key), $key);
    }

    public function testReturnsKeyIfNotAbleToAddNewString()
    {
        $key = ($filename = uniqid()) . '.' . ($path = uniqid());

        _p($key, uniqid());

        $this->assertEquals(_p($key . '.' . $a = uniqid(), uniqid()), $key . '.' . $a);
    }

    public function testReturnsKeyIfNotAbleToAddNewStringDeep()
    {
        $array = array_map(function($e) {
            return uniqid();
        }, array_fill(0, rand(5, 20), 1));

        $key = implode('.', $array);

        _p($key, uniqid());
        
        $this->assertEquals(_p($key . '.' . $addKey = uniqid(), uniqid()), $key . '.' . $addKey);
    }

    public function testStoresNewStringIfPreviousKeyIsArray()
    {
        $array = array_map(function($e) {
            return uniqid();
        }, array_fill(0, rand(5, 20), 1));

        $key = implode('.', $array);

        array_pop($array);

        $prevKey = implode('.', $array);

        _p($key, uniqid());
        
        _p($prevKey . '.' . ($newPath = uniqid()), $value = uniqid());
        
        $this->assertEquals(_p($prevKey . '.' . $newPath), $value);
    }

    public function testReturnsKeyIfNotAbleToAddNewStringBecauseIsArray()
    {
        $key = ($filename = 'a') . '.' . ($path = 'b');

        _p($key . '.c', 'd');
        _p($key . '.c', 'e');

        $this->assertEquals(_p($key, uniqid()), $key);
    }
    
    public function testThrowsErrorIfLocalizationFileCantBeOpened()
    {
        $key = ($filename = uniqid()) . '.' . uniqid();

        vfsStream::newFile($filename . '.php', 0000)
                 ->withContent($content = 'notoverwritten')
                 ->at($this->root->getChild('root/resources/lang/en'));

        $value = uniqid();

        _p($key, $value);

        $this->assertEquals($content, $this->root->getChild('root/resources/lang/en/'. $filename . '.php')->getContent());
    }
    
    public function testExportsFileIfContentsBoolean()
    {
        $key = ($filename = uniqid()) . '.' . uniqid();

        $value = true;

        _p($key, $value);

        $this->assertStringStartsWith('<?php', $this->root->getChild('root/resources/lang/en/'. $filename . '.php')->getContent());
    }

    public function testExportsFileIfContentsObject()
    {
        $key = ($filename = uniqid()) . '.' . uniqid();

        $value = new \stdClass;

        _p($key, $value);

        $this->assertStringStartsWith('<?php', $this->root->getChild('root/resources/lang/en/'. $filename . '.php')->getContent());
    }

    public function testHandlesCallsWithRootNameOnly()
    {
        $this->assertEquals('name', _p('name', 'test'));
    }

    protected function getContents($filename)
    {
        return $this->root->getChild($this->localizationFilePath . $filename . $this->extension)->getContent();
    }
}
