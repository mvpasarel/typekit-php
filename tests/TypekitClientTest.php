<?php

namespace Mvpasarel\Typekit\Test;

use Mvpasarel\Typekit\TypekitClient;

class TypekitClientTest extends \PHPUnit_Framework_TestCase
{

    private $typekit;

    protected function setUp()
    {
        $this->typekit = new TypekitClient('');
    }

    public function testListKits()
    {
        $kits = $this->typekit->getKits();
        $this->assertTrue(is_array($kits));
        $this->assertTrue(count($kits) > 0);
    }

    public function testKitCreation()
    {
        $name = 'kit_creation_test';
        $domains = array('localhost', '*.domain.com');
        $families = array(array('id' => 'ftnk', 'variations' => 'n3,n4'), array('id' => 'pcpv', 'variations' => 'n4'));

        $res = $this->typekit->createKit($name, $domains, $families);

        $this->assertFalse(isset($res['errors']));

        $kit = $res['kit'];

        $this->assertTrue(in_array('localhost', $kit['domains']));
        $this->assertTrue(in_array('*.domain.com', $kit['domains']));
        $this->assertEquals($kit['name'], $name);

        $family1 = $kit['families'][0];
        $this->assertEquals($family1['subset'], 'default');
        $this->assertEquals($family1['name'], 'Futura PT');
        $this->assertEquals($family1['id'], 'ftnk');
        $this->assertTrue(in_array('n3', $family1['variations']));
        $this->assertTrue(in_array('n4', $family1['variations']));
        $this->assertEquals(count($family1['variations']), 2);

        $family2 = $kit['families'][1];
        $this->assertEquals($family2['subset'], 'default');
        $this->assertEquals($family2['name'], 'Droid Serif');
        $this->assertEquals($family2['id'], 'pcpv');
        $this->assertTrue(in_array('n4', $family2['variations']));
        $this->assertEquals(count($family2['variations']), 1);

        $this->typekit->removeKit($kit['id']);
    }

    public function testGetKit()
    {

        $name = 'test_kit_creation';
        $domains = array('localhost', '*.domain.com');
        $families = array(array('id' => 'ftnk', 'variations' => 'n3,n4'), array('id' => 'pcpv', 'variations' => 'n4'));

        $res = $this->typekit->createKit($name, $domains, $families);
        $this->assertFalse(in_array('errors', $res));

        $kitId = $res['kit']['id'];

        $res = $this->typekit->getKit($kitId);

        $kit = $res['kit'];

        $this->assertTrue(in_array('localhost', $kit['domains']));
        $this->assertTrue(in_array('*.domain.com', $kit['domains']));
        $this->assertEquals($kit['name'], $name);

        $family1 = $kit['families'][0];
        $this->assertEquals($family1['subset'], 'default');
        $this->assertEquals($family1['name'], 'Futura PT');
        $this->assertEquals($family1['id'], 'ftnk');
        $this->assertTrue(in_array('n3', $family1['variations']));
        $this->assertTrue(in_array('n4', $family1['variations']));
        $this->assertEquals(count($family1['variations']), 2);

        $family2 = $kit['families'][1];
        $this->assertEquals($family2['subset'], 'default');
        $this->assertEquals($family2['name'], 'Droid Serif');
        $this->assertEquals($family2['id'], 'pcpv');
        $this->assertTrue(in_array('n4', $family2['variations']));
        $this->assertEquals(count($family2['variations']), 1);

        $this->typekit->removeKit($kitId);
    }

    public function testGetFontFamily()
    {

        $font = $this->typekit->getFontFamily('futura-pt');
        $this->assertEquals($font['family']['id'], 'ftnk');
        $this->assertEquals($font['family']['name'], 'Futura PT');
    }

    public function testKitContainsFont()
    {

        $name = 'test_kit_creation';
        $domains = array('localhost', '*.domain.com');
        $families = array(array('id' => 'ftnk', 'variations' => 'n3,n4'), array('id' => 'pcpv', 'variations' => 'n4'));

        $res = $this->typekit->createKit($name, $domains, $families);
        $this->assertFalse(in_array('errors', $res));

        $kitId = $res['kit']['id'];

        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'ftnk'));
        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'futura-pt'));
        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'pcpv'));
        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'droid-serif'));

        $this->typekit->removeKit($kitId);
    }


    public function testKit_addFont()
    {
        $name = 'test_kit_creation';
        $domains = array('localhost', '*.domain.com');
        $families = array(array('id' => 'ftnk', 'variations' => 'n3,n4'));

        $res = $this->typekit->createKit($name, $domains, $families);
        $this->assertFalse(in_array('errors', $res));

        $kitId = $res['kit']['id'];

        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'ftnk'));
        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'futura-pt'));
        $this->assertFalse($this->typekit->kitContainsFont($kitId, 'pcpv'));
        $this->assertFalse($this->typekit->kitContainsFont($kitId, 'droid-serif'));

        $this->typekit->kitAddFont($kitId, 'pcpv', array('n4'));
        $this->typekit->publishKit($kitId);

        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'pcpv'));
        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'droid-serif'));

        $this->typekit->removeKit($kitId);
    }


    public function testKitRemoveFont()
    {
        $name = 'test_kit_creation';
        $domains = array('localhost', '*.domain.com');
        $families = array(array('id' => 'ftnk', 'variations' => 'n3,n4'), array('id' => 'pcpv', 'variations' => 'n4'));

        $res = $this->typekit->createKit($name, $domains, $families);
        $this->assertFalse(in_array('errors', $res));

        $kitId = $res['kit']['id'];

        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'ftnk'));
        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'futura-pt'));
        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'pcpv'));
        $this->assertTrue($this->typekit->kitContainsFont($kitId, 'droid-serif'));

        $this->typekit->kitRemoveFont($kitId, 'pcpv');
        $this->typekit->publishKit($kitId);

        $this->assertFalse($this->typekit->kitContainsFont($kitId, 'pcpv'));
        $this->assertFalse($this->typekit->kitContainsFont($kitId, 'droid-serif'));

        $this->typekit->removeKit($kitId);

    }

    public function testGetKitFonts()
    {
        $name = 'test_kit_creation';
        $domains = array('localhost', '*.domain.com');
        $families = array(array('id' => 'ftnk', 'variations' => 'n3,n4'), array('id' => 'pcpv', 'variations' => 'n4'));

        $res = $this->typekit->createKit($name, $domains, $families);
        $kitId = $res['kit']['id'];

        $fonts = $this->typekit->getKitFonts($kitId);
        $this->assertTrue(in_array('ftnk', $fonts));
        $this->assertTrue(in_array('pcpv', $fonts));
        $this->assertEquals(count($fonts), 2);

        $this->typekit->removeKit($kitId);
    }

}
