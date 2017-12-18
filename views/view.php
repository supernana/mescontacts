<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="mescontacts.css" rel="stylesheet" />
    <title>MesContacts - Home</title>
</head>
<body>
    <header>
        <h1>MesContacts</h1>
    </header>
    <?php
    foreach ($contacts as $contact): ?>
    <contact>
        <h2><?php echo $contact->getNom() ?>
            <?php echo $contact->getPrenom() ?></h2>
        <p><?php echo $contact->getEmail() ?></p>
    </contact>
    <?php endforeach ?>
    <footer class="footer">
        <a href="https://github.com/supernana/MesContacts">MesContacts</a> is a minimalistic CMS built as a showcase for modern PHP development.
    </footer>
</body>
</html>
