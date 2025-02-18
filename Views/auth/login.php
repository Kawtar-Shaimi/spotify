<?php
// Check if there's a login error message
$error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme Musicale</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div class="min-h-screen flex flex-col items-center justify-center bg-black py-12 px-4 sm:px-6 lg:px-8">
    <!-- Logo -->
    <div class="mb-10">
        <svg class="w-40 text-[#1DB954]" viewBox="0 0 1134 340" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M8 171c0 92 76 168 168 168s168-76 168-168S268 4 176 4 8 79 8 171zm230 78c-39-24-89-30-147-17-14 2-16-18-4-20 64-15 118-8 162 19 11 7 0 24-11 18zm17-45c-45-28-114-36-167-20-17 5-23-21-7-25 61-18 136-9 188 23 14 9 0 31-14 22zM80 133c-17 6-28-23-9-30 59-18 159-15 221 22 17 9 1 37-17 27-54-32-144-35-195-19zm379 91c-17 0-33-6-47-20-1 0-1 1-1 1l-16 19c-1 1-1 2 0 3 18 16 40 24 64 24 34 0 55-19 55-47 0-24-15-37-50-46-29-7-34-12-34-22s10-16 23-16 25 5 39 15c0 0 1 1 2 1s1-1 1-1l14-20c1-1 1-1 0-2-16-13-35-20-56-20-31 0-53 19-53 46 0 29 20 38 52 46 28 6 32 12 32 22 0 11-10 17-25 17zm95-77v-13c0-1-1-2-2-2h-26c-1 0-2 1-2 2v147c0 1 1 2 2 2h26c1 0 2-1 2-2v-46c10 11 21 16 36 16 27 0 54-21 54-61s-27-60-54-60c-15 0-26 5-36 17zm30 78c-18 0-31-15-31-35s13-34 31-34 30 14 30 34-12 35-30 35zm68-34c0 34 27 60 62 60s62-27 62-61-26-60-61-60-63 27-63 61zm30-1c0-20 13-34 32-34s33 15 33 35-13 34-32 34-33-15-33-35zm140-58v-29c0-1 0-2-1-2h-26c-1 0-2 1-2 2v29h-13c-1 0-2 1-2 2v22c0 1 1 2 2 2h13v58c0 23 11 35 34 35 9 0 18-2 25-6 1 0 1-1 1-2v-21c0-1 0-2-1-2h-2c-5 3-11 4-16 4-8 0-12-4-12-12v-54h30c1 0 2-1 2-2v-22c0-1-1-2-2-2h-30zm129-3c0-11 4-15 13-15 5 0 10 0 15 2h1s1-1 1-2V93c0-1 0-2-1-2-5-2-12-3-22-3-24 0-36 14-36 39v5h-13c-1 0-2 1-2 2v22c0 1 1 2 2 2h13v89c0 1 1 2 2 2h26c1 0 1-1 1-2v-89h25l37 89c-4 9-8 11-14 11-5 0-10-1-15-4h-1l-1 1-9 19c0 1 0 3 1 3 9 5 17 7 27 7 19 0 30-9 39-33l45-116v-2c0-1-1-1-2-1h-27c-1 0-1 1-1 2l-28 78-30-78c0-1-1-2-2-2h-44v-3zm-83 3c-1 0-2 1-2 2v113c0 1 1 2 2 2h26c1 0 1-1 1-2V134c0-1 0-2-1-2h-26zm-6-33c0 10 9 19 19 19s18-9 18-19-8-18-18-18-19 8-19 18zm245 69c10 0 19-8 19-18s-9-18-19-18-18 8-18 18 8 18 18 18zm0-34c9 0 17 7 17 16s-8 16-17 16-16-7-16-16 7-16 16-16zm4 18c3-1 5-3 5-6 0-4-4-6-8-6h-8v19h4v-6h4l4 6h5zm-3-9c2 0 4 1 4 3s-2 3-4 3h-4v-6h4z"/>
        </svg>
    </div>

    <div class="w-full max-w-md">
        <div class="bg-[#121212] rounded-xl shadow-2xl p-8">
            <h2 class="text-3xl font-bold mb-8 text-center text-white">Se connecter à Spotify</h2>
            
            <?php if ($error): ?>
                <div class="bg-red-900/50 text-red-200 p-4 rounded-lg mb-6 border border-red-500/50">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form action="/login" method="POST" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-200 mb-2">Adresse e-mail</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           required 
                           class="w-full px-4 py-3 bg-[#1a1a1a] text-white border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1DB954] focus:border-transparent transition-all duration-200"
                           placeholder="nom@exemple.com">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-200 mb-2">Mot de passe</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required 
                           class="w-full px-4 py-3 bg-[#1a1a1a] text-white border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1DB954] focus:border-transparent transition-all duration-200"
                           placeholder="••••••••">
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" 
                               name="remember_me" 
                               type="checkbox"
                               class="h-4 w-4 bg-[#1a1a1a] border-gray-700 rounded focus:ring-[#1DB954] focus:ring-offset-gray-900">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-300">
                            Se souvenir de moi
                        </label>
                    </div>
                    
                    <a href="/forgot-password" class="text-sm text-[#1DB954] hover:text-[#1ed760] transition-colors duration-200">
                        Mot de passe oublié ?
                    </a>
                </div>

                <button type="submit" 
                        class="w-full bg-[#1DB954] text-black font-bold py-3 px-4 rounded-full hover:bg-[#1ed760] hover:scale-105 transform transition-all duration-200">
                    Se connecter
                </button>
            </form>
            
            <div class="mt-8 pt-6 text-center border-t border-gray-800">
                <p class="text-gray-400">
                    Vous n'avez pas de compte ?
                </p>
                <a href="/register" 
                   class="mt-3 block w-full text-center py-3 px-4 rounded-full border border-gray-500 text-white font-bold hover:border-white transition-colors duration-200">
                    S'inscrire à Spotify
                </a>
            </div>
        </div>
    </div>
</div>
