<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ArticleViewsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ArticleViewsTable Test Case
 */
class ArticleViewsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ArticleViewsTable
     */
    public $ArticleViews;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.article_views',
        'app.users',
        'app.articles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ArticleViews') ? [] : ['className' => ArticleViewsTable::class];
        $this->ArticleViews = TableRegistry::get('ArticleViews', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ArticleViews);

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
