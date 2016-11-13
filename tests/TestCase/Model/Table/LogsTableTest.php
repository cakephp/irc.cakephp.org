<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LogsTable Test Case
 */
class LogsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LogsTable
     */
    public $Logs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('Logs') ? [] : ['className' => 'App\Model\Table\LogsTable'];
        $this->Logs = TableRegistry::get('Logs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Logs);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
