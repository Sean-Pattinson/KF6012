<?php
/**
 * This Router will return a main, documentation or about page
 *
 * @author Sean Pattinson
 * @param $pageType - can be "main", "documentation" or "about"
 *
 */
class Router {
    private $page;

    public function __construct($pageType) {
        switch ($pageType) {
            case 'main':
                $title = "KF6012 Main";
                $heading1 = "Main Page";
                $footer = "Northumbria, 2020";
                $text = "<p>This is the main page</p>";
                break;
            case 'documentation':
                $title = "KF6012 Main";
                $heading1 = "Documentation Page";
                $footer = "Northumbria, 2020";
                $text = "<p>This is the documentation page</p>";
                break;
            case 'about':
                $title = "KF6012 About";
                $heading1 = "About Page";
                $footer = "Northumbria, 2020";
                $text = "<p>This is the about page</p>";
                break;
            case 'help':
                $title = "KF6012 Help";
                $heading1 = "Help Page";
                $footer = "Northumbria, 2020";
                $text = "<p>This is the help page</p>";
                break;
            default:
                $title = "KF6012 Error";
                $heading1 = "Error Page";
                $footer = "Northumbria, 2020";
                $text = "<p>Page not found</p>";
                break;
        }
        $css = "styles/style.css";
        $this->page = new WebPageWithNav($title, $css, $heading1, $footer);
        $this->page->addToBody($text);
    }

    public function get_page() {
        return $this->page->get_page();
    }
}
?>