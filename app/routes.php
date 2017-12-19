<?php

use Symfony\Component\HttpFoundation\Request;

// Page d'accueil
$app->get('/', function () use ($app) {

    $contacts = $app['dao.contact']->chercheTout();
    return $app['twig']->render('index.html.twig', array('contacts' => $contacts));
})->bind('home');

// Formulaire de connexion
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');

// Contact détaillés avec les adresses
$app->get('/contact/{id}', function ($id) use ($app) {
    $contact = $app['dao.contact']->cherche($id);
    $adresses = $app['dao.adresse']->chercheToutParContact($id);
    return $app['twig']->render('contact.html.twig', array('contact' => $contact, 'adresses' => $adresses));
})->bind('contact');