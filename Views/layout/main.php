<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Clone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'spotify-green': '#1DB954',
                        'spotify-black': '#191414',
                        'spotify-dark': '#121212',
                        'spotify-light': '#282828',
                        'spotify-gray': '#b3b3b3'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-spotify-dark text-white">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-60 bg-black p-4">
            <div class="mb-8">
                <img src="/assets/images/spotify-logo.png" alt="Spotify" class="w-32">
            </div>
            
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="http://localhost/spotify/Views/layout/main.php" class="flex items-center text-spotify-gray hover:text-white p-2 rounded transition-colors">
                            <i class="fas fa-home w-6 text-center mr-4"></i>
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="/search" class="flex items-center text-spotify-gray hover:text-white p-2 rounded transition-colors">
                            <i class="fas fa-search w-6 text-center mr-4"></i>
                            Rechercher
                        </a>
                    </li>
                    <li>
                        <a href="/library" class="flex items-center text-spotify-gray hover:text-white p-2 rounded transition-colors">
                            <i class="fas fa-book w-6 text-center mr-4"></i>
                            Bibliothèque
                        </a>
                    </li>
                    <li>
                        <a href="/playlists" class="flex items-center text-spotify-gray hover:text-white p-2 rounded transition-colors">
                            <i class="fas fa-music w-6 text-center mr-4"></i>
                            Playlists
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <div class="sticky top-0 bg-black/70 backdrop-blur-md p-4 flex justify-between items-center z-50">
                <div class="flex gap-2">
                    <button class="text-spotify-gray hover:text-white p-2">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="text-spotify-gray hover:text-white p-2">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <div class="relative">
                    <button id="userMenuButton" class="flex items-center gap-2 bg-black/60 hover:bg-spotify-light p-2 rounded-full transition-colors">
                        <div class="w-7 h-7 bg-spotify-light rounded-full flex items-center justify-center">
                            <i class="fas fa-user"></i>
                        </div>
                        <span><?php echo htmlspecialchars($user->getUsername()); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-40 bg-spotify-light rounded-md shadow-lg">
                        <a href="/profile" class="block px-4 py-2 text-spotify-gray hover:text-white hover:bg-spotify-dark/50">Profil</a>
                        <a href="/settings" class="block px-4 py-2 text-spotify-gray hover:text-white hover:bg-spotify-dark/50">Paramètres</a>
                        <form action="/logout" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <button type="submit" class="w-full text-left px-4 py-2 text-spotify-gray hover:text-white hover:bg-spotify-dark/50">Se déconnecter</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4">
                <?php echo $content; ?>
            </div>
        </main>
    </div>

    <!-- Now Playing Bar -->
    <div class="fixed bottom-0 w-full h-24 bg-spotify-light border-t border-spotify-dark/50 px-4 flex items-center justify-between">
        <!-- Track Info -->
        <div class="flex items-center gap-4 flex-1 max-w-[30%]">
            <div class="w-14 h-14 bg-spotify-dark rounded"></div>
            <div class="overflow-hidden">
                <div class="text-sm truncate">Titre de la chanson</div>
                <div class="text-xs text-spotify-gray truncate">Nom de l'artiste</div>
            </div>
        </div>

        <!-- Player Controls -->
        <div class="flex-2 max-w-[40%] flex flex-col items-center gap-2">
            <div class="flex items-center gap-4">
                <button class="text-spotify-gray hover:text-white p-2">
                    <i class="fas fa-random"></i>
                </button>
                <button class="text-spotify-gray hover:text-white p-2">
                    <i class="fas fa-step-backward"></i>
                </button>
                <button class="text-white text-xl p-2">
                    <i class="fas fa-play"></i>
                </button>
                <button class="text-spotify-gray hover:text-white p-2">
                    <i class="fas fa-step-forward"></i>
                </button>
                <button class="text-spotify-gray hover:text-white p-2">
                    <i class="fas fa-redo"></i>
                </button>
            </div>

            <div class="flex items-center gap-2 w-full">
                <span class="text-xs text-spotify-gray min-w-[40px]">0:00</span>
                <div class="flex-1 h-1 bg-spotify-light rounded-full cursor-pointer">
                    <div class="h-full w-[30%] bg-spotify-gray rounded-full"></div>
                </div>
                <span class="text-xs text-spotify-gray min-w-[40px]">3:45</span>
            </div>
        </div>

        <!-- Volume Controls -->
        <div class="flex items-center justify-end gap-2 flex-1 max-w-[30%]">
            <button class="text-spotify-gray hover:text-white p-2">
                <i class="fas fa-volume-up"></i>
            </button>
            <div class="w-24 h-1 bg-spotify-light rounded-full cursor-pointer">
                <div class="h-full w-[70%] bg-spotify-gray rounded-full"></div>
            </div>
        </div>
    </div>

    <script>
        // Toggle user dropdown menu
        const userMenuButton = document.getElementById('userMenuButton');
        const userDropdown = document.getElementById('userDropdown');

        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', (event) => {
            if (!event.target.closest('.relative')) {
                userDropdown.classList.add('hidden');
            }
        });

        // Toggle play/pause button
        const playButton = document.querySelector('.text-xl');
        playButton.addEventListener('click', () => {
            const icon = playButton.querySelector('i');
            if (icon.classList.contains('fa-play')) {
                icon.classList.remove('fa-play');
                icon.classList.add('fa-pause');
            } else {
                icon.classList.remove('fa-pause');
                icon.classList.add('fa-play');
            }
        });
    </script>
</body>
</html>
