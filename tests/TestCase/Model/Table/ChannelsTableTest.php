<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChannelsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChannelsTable Test Case
 */
class ChannelsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ChannelsTable
     */
    public $Channels;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.channels',
        'app.logs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Channels') ? [] : ['className' => 'App\Model\Table\ChannelsTable'];
        $this->Channels = TableRegistry::get('Channels', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Channels);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
