<?php


namespace Firesphere\SolrSearch\Tests;

use CircleCITestIndex;
use Firesphere\SolrSearch\Helpers\SearchIntrospection;
use Page;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\CMS\Model\RedirectorPage;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\CMS\Model\VirtualPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\ErrorPage\ErrorPage;

class SearchIntrospectionTest extends SapphireTest
{
    /**
     * @var SearchIntrospection
     */
    protected $introspection;

    public function testIsSubclassOf()
    {
        $this->assertTrue(SearchIntrospection::isSubclassOf(Page::class, [SiteTree::class, Page::class]));
        $this->assertFalse(SearchIntrospection::isSubclassOf(ModelAdmin::class, [SiteTree::class, Page::class]));
    }

    public function testHierarchy()
    {
        // Expected Hierarchy is all pagetypes, including the test ones
        $expected = [
            SiteTree::class,
            Page::class,
            TestPage::class,
            ErrorPage::class,
            RedirectorPage::class,
            VirtualPage::class,
        ];

        $test = SearchIntrospection::hierarchy(Page::class, true, false);
        $this->assertEquals($expected, $test);
        $test2 = SearchIntrospection::hierarchy(Page::class, false, true);
        $this->assertEquals([SiteTree::class], $test2);
        $test3 = SearchIntrospection::hierarchy(Page::class, false, false);
        $this->assertEquals([SiteTree::class, Page::class], $test3);
    }

    protected function setUp()
    {
        $this->introspection = new SearchIntrospection();
        $this->introspection->setIndex(new CircleCITestIndex());

        return parent::setUp(); // TODO: Change the autogenerated stub
    }
}
