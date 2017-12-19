<?php
/**
 * User: Naeva
 * Date: 16/12/2017
 */

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Enregistre les erreurs globales et les gestionnaires d'exceptions
ErrorHandler::register();
ExceptionHandler::register();

// Entregistre le fournisseur de service
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(),array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'asset.version' => 'v1'
));
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new MesContacts\DAO\UserDAO($app['db']);
            },
        )
    )
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());


// Enregiste les services
$app['dao.user'] = function ($app) {
    return new MesContacts\DAO\UserDAO($app['db']);
};
$app['dao.contact'] = function ($app) {
    $contactDAO = new MesContacts\DAO\ContactDAO($app['db']);
    $contactDAO->setUserDAO($app['dao.user']);
    return $contactDAO;
};
$app['dao.adresse'] = function ($app) {
    $adresseDAO = new MesContacts\DAO\AdresseDAO($app['db']);
    $adresseDAO->setContactDAO($app['dao.contact']);
    return $adresseDAO;
};
