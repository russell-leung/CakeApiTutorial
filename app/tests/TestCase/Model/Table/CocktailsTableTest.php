<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CocktailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CocktailsTable Test Case
 */
class CocktailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CocktailsTable
     */
    protected $Cocktails;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Cocktails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Cocktails') ? [] : ['className' => CocktailsTable::class];
        $this->Cocktails = $this->getTableLocator()->get('Cocktails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Cocktails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CocktailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
