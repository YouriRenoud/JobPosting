<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Footer Fixe</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/global.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            flex: 1;
        }

        main {
            flex: 1;
            background-color: #e9ecef;
            padding: 20px;
            text-align: center;
        }

        footer {
            background-color: #212529;
            color: white;
            text-align: center;
            padding: 5px;
            font-size: 0.75rem;
            margin-top: auto;
        }
    </style>
</head>
<body>

<main>
    <h1>Contenu de la page</h1>
    <p>Voici un test minimaliste pour voir si le footer est bien fixé en bas.</p>
</main>

<footer>
    <p>&copy; 2025 JobFinder - Tous droits réservés</p>
</footer>

</body>
</html>
