<?php

use Symfony\Component\HttpFoundation\Request;
use MesContacts\Domain\Adresse;
use MesContacts\Form\Type\AdresseType;

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
$app->match('/contact/{id}', function ($id, Request $request) use ($app) {
    $contact = $app['dao.contact']->cherche($id);
    $adresseFormView = null;
    if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
        // L'utilisateur est pleinement autentifié, il peut accèder aux modifications
        $adresse = new Adresse();
        $adresse->setContact($contact);
        $user = $app['user'];
        /*$adresse->set($user);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'Your comment was successfully added.');
        }
        $commentFormView = $commentForm->createView();
    }
    $comments = $app['dao.comment']->findAllByArticle($id);*/


    $adresses = $app['dao.adresse']->chercheToutParContact($id);
    return $app['twig']->render('contact.html.twig', array('contact' => $contact, 'adresses' => $adresses));
})->bind('contact');