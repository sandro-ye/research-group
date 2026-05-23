<?php

use App\Livewire\HomePage;
use App\Livewire\PublicationsPage;
use App\Livewire\MembersPage;
use App\Livewire\MemberDetailPage;
use App\Livewire\ProjectsPage;
use App\Livewire\ProjectDetailPage;
use App\Livewire\AdminDashboard;
use App\Livewire\Admin\MembersManager;
use App\Livewire\Admin\PublicationsManager;
use App\Livewire\Admin\ProjectsManager;
use App\Livewire\Admin\AnnouncementsManager;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
 //   return view('home');
//});

Route::get('/', HomePage::class)->name('homepage');

Route::get('/projects', ProjectsPage::class)->name('projects');
Route::get('/projects/{project}', ProjectDetailPage::class)->name('projects.show');

Route::get('/publications', PublicationsPage::class)->name('publications');

Route::get('/members', MembersPage::class)->name('members');

Route::get('/members/{user}', MemberDetailPage::class)->name('members.show');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin'
])->group(function () {
    Route::get('/admin', AdminDashboard::class)->name('admin.dashboard');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/members', MembersManager::class)->name('admin.members');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/publications', PublicationsManager::class)
        ->name('admin.publications');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/announcements', AnnouncementsManager::class)
        ->name('admin.announcements');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/projects', ProjectsManager::class)->name('admin.projects');
});