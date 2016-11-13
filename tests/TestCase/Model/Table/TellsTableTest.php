<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TellsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TellsTable Test Case
 */
class TellsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TellsTable
     */
    public $Tells;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tells'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Tells') ? [] : ['className' => 'App\Model\Table\TellsTable'];
        $this->Tells = TableRegistry::get('Tells', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tells);

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
