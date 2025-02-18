<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme Musicale</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex flex-col min-h-screen">
    <header class="p-4 bg-gray-800 shadow-lg flex justify-between items-center">
        <h1 class="text-2xl font-bold text-green-400">MusicHub</h1>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="index.html" class="hover:text-green-400">Accueil</a></li>
                <li><a href="playlists.html" class="hover:text-green-400">Playlists</a></li>
                <li><a href="connexion.html" class="hover:text-green-400">Connexion</a></li>
            </ul>
        </nav>
    </header>
    
    <main class="container mx-auto p-6 flex-grow">
        <section class="text-center my-10">
            <h2 class="text-4xl font-extrabold mb-4">Découvrez et partagez votre musique préférée</h2>
            <p class="text-gray-300 text-lg">Créez des playlists, suivez vos artistes favoris et profitez d'une expérience musicale unique.</p>
            <button class="mt-6 px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition">Commencer</button>
        </section>
        
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold">Playlists populaires</h3>
                <p class="text-gray-400">Découvrez les meilleures sélections musicales du moment.</p>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold">Nouveautés</h3>
                <p class="text-gray-400">Écoutez les derniers morceaux ajoutés par nos artistes.</p>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold">Créez vos propres playlists</h3>
                <p class="text-gray-400">Personnalisez vos listes de lecture et partagez-les avec vos amis.</p>
            </div>
        </section>
    </main>
    
    <footer class="p-6 text-center bg-gray-800 mt-10">
        <p class="text-gray-400">&copy; 2025 MusicHub. Tous droits réservés.</p>
    </footer>
</body>
</html>

<!-- Page Playlists -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlists - MusicHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex flex-col min-h-screen">
    <header class="p-4 bg-gray-800 shadow-lg flex justify-between items-center">
        <h1 class="text-2xl font-bold text-green-400">MusicHub</h1>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="index.html" class="hover:text-green-400">Accueil</a></li>
                <li><a href="playlists.html" class="hover:text-green-400">Playlists</a></li>
                <li><a href="connexion.html" class="hover:text-green-400">Connexion</a></li>
            </ul>
        </nav>
    </header>

    <main class="container mx-auto p-6 flex-grow">
        <h2 class="text-4xl font-extrabold mb-6">Playlists</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold">Playlist 1</h3>
                <p class="text-gray-400">Description de la playlist 1.</p>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold">Playlist 2</h3>
                <p class="text-gray-400">Description de la playlist 2.</p>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold">Playlist 3</h3>
                <p class="text-gray-400">Description de la playlist 3.</p>
            </div>
        </div>
    </main>

    <footer class="p-6 text-center bg-gray-800 mt-10">
        <p class="text-gray-400">&copy; 2025 MusicHub. Tous droits réservés.</p>
    </footer>
</body>
</html>

<!-- Page Connexion -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - MusicHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex flex-col min-h-screen">
    <header class="p-4 bg-gray-800 shadow-lg flex justify-between items-center">
        <h1 class="text-2xl font-bold text-green-400">MusicHub</h1>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="index.html" class="hover:text-green-400">Accueil</a></li>
                <li><a href="playlists.html" class="hover:text-green-400">Playlists</a></li>
                <li><a href="connexion.html" class="hover:text-green-400">Connexion</a></li>
            </ul>
        </nav>
    </header>

    <main class="container mx-auto p-6 flex-grow">
        <h2 class="text-4xl font-extrabold mb-6">Connexion</h2>
        <form class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-md mx-auto">
            <div class="mb-4">  
                <label for="email" class="block text-gray-400 mb-2">Adresse e-mail</label>
                <input type="email" id="email" class="w-full p-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-400 mb-2">Mot de passe</label>
                <input type="password" id="password" class="w-full p-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition">Se connecter</button>
        </form>
    </main>

    <footer class="p-6 text-center bg-gray-800 mt-10">
        <p class="text-gray-400">&copy; 2025 MusicHub. Tous droits réservés.</p>
    </footer>
</body>
</html>
