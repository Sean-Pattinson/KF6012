<?php
/**
 * This router will return a main, documentation or about page
 *
 * @author Sean Pattinson
 *
 */
class Router {
    private $page;

    /**
     * @param $pageType - can be "main", "documentation" or "about"
     */
    public function __construct($pageInfo) {
        $css = BASEPATH.CSSPATH;
        $this->page = new WebPageWithNav($pageInfo['title'], $css, $pageInfo['heading1'], $pageInfo['footer']);
        $this->page->addToBody($pageInfo['text']);
    }

    public function get_page() {
        return $this->page->get_page();
    }
}
?>