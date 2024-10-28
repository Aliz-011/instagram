<?php

use App\Livewire\Explore;
use App\Livewire\Home;
use App\Livewire\Profile\Home as ProfileHome;
use App\Livewire\Profile\Reels as ProfileReels;
use App\Livewire\Profile\Saved as ProfileSaved;
use App\Livewire\Reels;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
    Route::get('/profile/{user}', ProfileHome::class)->name('profile.home');
    Route::get('/profile/{user}/reels',  ProfileReels::class)->name('profile.reels');
    Route::get('/profile/{user}/saved', ProfileSaved::class)->name('profile.saved');
    Route::get('/explore', Explore::class)->name('explore');
    Route::get('/reels', Reels::class)->name('reels');
});

Route::get('/', Home::class)
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
