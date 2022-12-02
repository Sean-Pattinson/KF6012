<?php
/**
 * Create a webpage with a navbar menu
 */
class WebPageWithNav extends WebPage {
    private $nav;

    protected function set_header($pageHeading1) {
        $basepath = "/kf6012/week3/a/";
        $this->set_nav($basepath, ["main"=>"","documentation"=>"documentation/","about"=>"about/"]);
        $nav = $this->nav;
        $this->header = <<<HEADER
<header>
 <h1>$pageHeading1</h1>
 $nav
</header>
HEADER;
    }

    private function navHTML($listItems) {
        return <<<MYNAV
<nav>
 <ul>
 $listItems
 <ul>
</nav>
MYNAV;
    }

    /**
     * This generates the menu as an unordered list and
     * then sets the nav property
     *
     * @param $basepath - the url path
     * @param $navItems - an associative array with the keys
     * as menu items and values as links
     */
    private function set_nav($basepath, array $navItems) {
        $listItems = "";
        foreach ($navItems as $key => $value) {
            $listItems .= "<li><a href='$basepath$value'>$key</a></li>";
        }
        $this->nav = $this->navHTML($listItems);
    }
}
?>