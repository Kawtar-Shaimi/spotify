<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ArtisteController;
use App\Controllers\PlaylistController;
use App\Controllers\ChansonController;

// Start session
session_start();

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the request URI and remove the /spotify prefix
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/spotify';
if (strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}
$_SERVER['REQUEST_URI'] = $request_uri ?: '/';

// Initialize router
$router = new Router();

// Define routes
$router->addRoute('GET', '/', 'HomeController@index');

// Auth routes
$router->addRoute('GET', '/login', 'AuthController@showLoginForm');
$router->addRoute('POST', '/login', 'AuthController@login');
$router->addRoute('GET', '/register', 'AuthController@showRegisterForm');
$router->addRoute('POST', '/register', 'AuthController@register');
$router->addRoute('GET', '/logout', 'AuthController@logout');

// Artist routes
$router->addRoute('GET', '/artiste/dashboard', 'ArtisteController@dashboard');
$router->addRoute('GET', '/artiste/profile', 'ArtisteController@profile');
$router->addRoute('POST', '/artiste/profile/update', 'ArtisteController@updateProfile');
$router->addRoute('GET', '/artiste/chansons', 'ArtisteController@chansons');
$router->addRoute('POST', '/artiste/chansons/upload', 'ArtisteController@uploadChanson');

// Playlist routes
$router->addRoute('GET', '/playlists', 'PlaylistController@index');
$router->addRoute('GET', '/playlist/new', 'PlaylistController@create');
$router->addRoute('POST', '/playlist', 'PlaylistController@store');
$router->addRoute('GET', '/playlist/{id}', 'PlaylistController@show');
$router->addRoute('PUT', '/playlist/{id}', 'PlaylistController@update');
$router->addRoute('DELETE', '/playlist/{id}', 'PlaylistController@delete');

// Chanson routes
$router->addRoute('GET', '/chansons', 'ChansonController@index');
$router->addRoute('GET', '/chanson/create', 'ChansonController@create');
$router->addRoute('POST', '/chanson', 'ChansonController@store');
$router->addRoute('GET', '/chanson/{id}', 'ChansonController@show');
$router->addRoute('POST', '/chanson/playlist/add', 'ChansonController@ajouterAPlaylist');
$router->addRoute('POST', '/chanson/{id}/playlist/remove', 'ChansonController@supprimerDePlaylist');
$router->addRoute('POST', '/chanson/{id}/like', 'ChansonController@gererLike');
$router->addRoute('POST', '/chanson/{id}/album', 'ChansonController@gererAlbum');

try {
    // Dispatch the request
    $router->dispatch();
} catch (Exception $e) {
    // Log the error
    error_log($e->getMessage());
    // Show a user-friendly error page
    http_response_code(500);
    include __DIR__ . '/Views/error/500.php';
}