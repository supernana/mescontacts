<?php

use Symfony\Component\HttpFoundation\Request;
use MesContacts\Domain\Adresse;
use MesContacts\Form\Type\AdresseType;
use MesContacts\Domain\Contact;
use MesContacts\Form\Type\ContactType;

// Page d'accueil
$app->get('/', function () use ($app) {
    $contacts = null;
    if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
        // L'utilisateur est pleinement autentifié, il peut accèder aux contacts
        $user = $app['user'];
        $contacts = $app['dao.contact']->chercherToutParUser($user->getId());
    }
    return $app['twig']->render('index.html.twig', array('contacts' => $contacts));
})->bind('home');

// Formulaire de connexion
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');


// Ajout d'un nouveau contact
$app->match('/contact/add', function(Request $request) use ($app) {
    $contact = new Contact();
    $contactForm = $app['form.factory']->create(ContactType::class, $contact);
    $contactForm->handleRequest($request);
    if ($contactForm->isSubmitted() && $contactForm->isValid()) {
        $user = $app['user'];
        $contact->setUser($user);
        $app['dao.contact']->enregistrer($contact);
        $app['session']->getFlashBag()->add('success', 'Le contact a été créé.');
    }
    return $app['twig']->render('contact_form.html.twig', array(
        'title' => 'Nouveau contact',
        'contactForm' => $contactForm->createView()));
})->bind('contact_add');

// Edition d'un contact existant
$app->match('/contact/{id}/edit', function($id, Request $request) use ($app) {
    $contact = $app['dao.contact']->chercher($id);
    $contactForm = $app['form.factory']->create(ContactType::class, $contact);
    $contactForm->handleRequest($request);
    if ($contactForm->isSubmitted() && $contactForm->isValid()) {
        $app['dao.contact']->enregistrer($contact);
        $app['session']->getFlashBag()->add('success', 'Le contact a été mise à jour.');
    }
    return $app['twig']->render('contact_form.html.twig', array(
        'title' => 'Edition de '. $contact->getNom(),
        'contactForm' => $contactForm->createView()));
})->bind('contact_edit');

// Suppression d'un contact
$app->get('/contact/{id}/delete', function($id, Request $request) use ($app) {
    // Supprime toutes les adresses associés
    $app['dao.adresse']->supprimerToutParContact($id);
    // Delete the contact
    $app['dao.contact']->supprimer($id);
    $app['session']->getFlashBag()->add('success', 'Le contact a été supprimé.');
    // Redirect to admin home page
    return $app->redirect('/');
})->bind('contact_delete');

// Contact détaillés avec les adresses
$app->get('/contact/{id}', function ($id) use ($app) {
    $contact = $app['dao.contact']->chercher($id);
    $adresses = $app['dao.adresse']->chercherToutParContact($id);
    return $app['twig']->render('contact.html.twig', array('contact' => $contact, 'adresses' => $adresses));
})->bind('contact');

// Ajout d'une nouvelle adresse
$app->match('/adresse/{id}/add', function($id, Request $request) use ($app) {
    $adresse = new Adresse();
    $adresseForm = $app['form.factory']->create(AdresseType::class, $adresse);
    $adresseForm->handleRequest($request);
    $contact = $app['dao.contact']->chercher($id);
    if ($adresseForm->isSubmitted() && $adresseForm->isValid()) {
        $adresse->setContact($contact);
        $app['dao.adresse']->enregistrer($adresse);
        $app['session']->getFlashBag()->add('success', 'L\'adresse a été créé.');
        return $app->redirect('/contact/'. $id);
    }
    return $app['twig']->render('adresse_form.html.twig', array(
        'title' => 'Nouvelle adresse pour '. $contact->getNom(),
        'adresseForm' => $adresseForm->createView()));
})->bind('adresse_add');

// Edition d'un adresse existant
$app->match('/adresse/{id}/edit', function($id, Request $request) use ($app) {
    $adresse = $app['dao.adresse']->chercher($id);
    $adresseForm = $app['form.factory']->create(AdresseType::class, $adresse);
    $adresseForm->handleRequest($request);
    if ($adresseForm->isSubmitted() && $adresseForm->isValid()) {
        $app['dao.adresse']->enregistrer($adresse);
        $app['session']->getFlashBag()->add('success', 'L\'adresse a été mise à jour.');
        return $app->redirect('/contact/'. $adresse->getContact()->getId());
    }
    return $app['twig']->render('adresse_form.html.twig', array(
        'title' => 'Edition de l\'adresse de '. $adresse->getContact()->getNom(),
        'adresseForm' => $adresseForm->createView()));
})->bind('adresse_edit');

// Suppression d'un adresse
$app->get('/adresse/{id}/delete', function($id, Request $request) use ($app) {
    // Delete the adresse
    $adresse = $app['dao.adresse']->chercher($id);
    $app['dao.adresse']->supprimer($id);
    $app['session']->getFlashBag()->add('success', 'L\'adresse a été supprimé.');
    // Redirect to admin home page
    return $app->redirect('/contact/'. $adresse->getContact()->getId());
})->bind('adresse_delete');