<?php
use PHPUnit\Framework\TestCase;

class Test_Mavi_Notion_Importer extends TestCase {

    /**
     * Helper pour appeler les méthodes privées de Mavi_Notion_Importer.
     */
    protected function invokeMethod( $methodName, array $parameters = array() ) {
        $reflection = new \ReflectionClass( 'Mavi_Notion_Importer' );
        $method = $reflection->getMethod( $methodName );
        $method->setAccessible( true );

        return $method->invokeArgs( null, $parameters );
    }

    /**
     * Test de conversion d'un paragraphe Notion avec couleur et surlignage.
     */
    public function test_make_paragraph_with_color() {
        $content = 'Texte avec couleur';
        $class   = 'color-red block-color-yellow_background';

        $result = $this->invokeMethod( 'make_paragraph', array( $content, $class ) );

        // Assert: Vérifie que les classes natives WP sont ajoutées
        $this->assertStringContainsString( 'class="has-notion-red-color has-text-color has-notion-yellow-bg-background-color has-background"', $result );

        // Assert: Vérifie le commentaire de bloc généré
        $this->assertStringContainsString( '{"textColor":"notion-red","backgroundColor":"notion-yellow-bg"}', $result );
        $this->assertStringContainsString( '<p class="', $result );
        $this->assertStringContainsString( 'Texte avec couleur', $result );
    }

    /**
     * Test de conversion d'une To-Do list Notion interactive.
     */
    public function test_make_todo_list() {
        // Création d'un mock DOMNode (ul > li > input)
        $html = '<ul><li><input type="checkbox" checked /> Tâche finie</li><li><input type="checkbox" /> Tâche à faire</li></ul>';
        $doc = new \DOMDocument();
        $doc->loadHTML( '<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
        $node = $doc->getElementsByTagName( 'ul' )->item( 0 );

        $result = $this->invokeMethod( 'make_todo_list', array( $node ) );

        // Assert: La classe du thème est bien appliquée à l'élément ul
        $this->assertStringContainsString( '<!-- wp:list {"className":"is-style-mavi-coche"} -->', $result );
        $this->assertStringContainsString( '<ul class="is-style-mavi-coche">', $result );

        // Assert: Les éléments de la liste n'ont plus les symboles textuels, et la liste elle-même est intacte
        $this->assertStringContainsString( 'Tâche finie', $result );
        $this->assertStringContainsString( 'Tâche à faire', $result );

        // Assert: Vérifie les préfixes cochés et non cochés injectés par make_todo_list
        $this->assertStringContainsString( '☑️', $result );
        $this->assertStringContainsString( '☐', $result );
    }

    /**
     * Test de la conversion des vrais tableaux Gutenberg (Structure stricte).
     */
    public function test_make_table_strict_structure() {
        // Notion exporte parfois un simple <table> avec tbody et tr td.
        $html = '<table><thead><tr><th>Titre 1</th><th>Titre 2</th></tr></thead><tbody><tr><td>Donnée 1</td><td>Donnée 2</td></tr></tbody></table>';
        $doc = new \DOMDocument();
        $doc->loadHTML( '<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
        $node = $doc->getElementsByTagName( 'table' )->item( 0 );

        $result = $this->invokeMethod( 'make_table', array( $node ) );

        // Assert: Vérifier que le commentaire contient le flag pour thead
        $this->assertStringContainsString( '{"hasWindowTable":true}', $result );
        $this->assertStringContainsString( '<figure class="wp-block-table">', $result );
        $this->assertStringContainsString( '<thead>', $result );
        $this->assertStringContainsString( '<th>Titre 1</th>', $result );
        $this->assertStringContainsString( '<tbody>', $result );
        $this->assertStringContainsString( '<td>Donnée 1</td>', $result );
    }
}
