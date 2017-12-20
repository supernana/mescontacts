<?php
/**
 * User: Naeva
 * Date: 19/12/2017
 */

namespace MesContacts\Tests;

require_once __DIR__.'/../../vendor/autoload.php';

use Silex\WebTestCase;

/**
 * Class AppTest
 * @package MesContacts\Tests
 */
class AppTest extends WebTestCase
{

    /**
     * Vérifie que toutes les URL d'application se chargent avec succès.
     * Pendant l'exécution du test, cette méthode est appelée pour chaque URL renvoyée par la méthode provideUrls.
     *
     * @dataProvider provideUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = $this->createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testEmailValide()
    {
        $client = $this->createClient();

        $client->request('GET', '/validate/prefixe@suffixe.extension');
        $this->assertTrue($client->getResponse()->isOk());

        $client->request('GET', '/validate/prefixe@suffixe');
        $this->assertFalse($client->getResponse()->isOk());

        $client->request('GET', '/validate/prefixe.suffixe');
        $this->assertFalse($client->getResponse()->isOk());

        $client->request('GET', '/validate/prefixe');
        $this->assertFalse($client->getResponse()->isOk());
    }
    /**
     * {@inheritDoc}
     */
    public function createApplication()
    {
        $app = new \Silex\Application();

        require __DIR__.'/../../app/config/dev.php';
        require __DIR__.'/../../app/app.php';
        require __DIR__.'/../../app/routes.php';

        // Génère des exceptions brutes plutôt que des pages html si des erreurs se produisent
        unset($app['exception_handler']);
        // Simule une session pour les tests
        $app['session.test'] = true;
        // Active la connexion annonyme
        $app['security.access_rules'] = array();

        return $app;
    }

    /**
     * Fournit toutes les URL valide de l'application.
     *
     * @return array
     */
    public function provideUrls()
    {
        return array(
            array('/'),
            array('/login'),
            array('/contact/1'),
            array('/contact/add'),
            array('/contact/1/edit'),
            array('/adresse/1/add'),
            array('/adresse/1/edit'),
            array('/validate/prefixe@suffixe.extension')
        );
    }


}