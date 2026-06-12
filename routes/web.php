<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');
Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');

Route::view('/buttons', 'admin.buttons')->name('admin.buttons');
Route::view('/gridsystem', 'admin.gridsystem')->name('admin.gridsystem');
Route::view('/panels', 'admin.panels')->name('admin.panels');
Route::view('/notifications', 'admin.notifications')->name('admin.notifications');
Route::view('/typography', 'admin.typography')->name('admin.typography');
Route::view('/sweetalert', 'admin.sweetalert')->name('admin.sweetalert');

Route::view('/font-awesome', 'admin.font-awesome-icons')->name('admin.font-awesome-icons');
Route::view('/simple-line', 'admin.simple-line-icons')->name('admin.simple-line-icons');

Route::view('/avatars', 'admin.avatars')->name('admin.avatars');
Route::view('/welcome', 'admin.welcome')->name('admin.welcome');

Route::view('/login', 'auth.role-select')->name('login');
Route::view('/login/student', 'auth.login-student')->name('login.student');
Route::view('/login/coordinator', 'auth.login-coordinator')->name('login.coordinator');
Route::view('/login/supervisor', 'auth.login-supervisor')->name('login.supervisor');

Route::view('/register', 'auth.register-select')->name('register');
Route::view('/register/student', 'auth.register-student')->name('register.student');
Route::view('/register/coordinator', 'auth.register-coordinator')->name('register.coordinator');
Route::view('/register/supervisor', 'auth.register-supervisor')->name('register.supervisor');

Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');

Route::view('/forms', 'admin.forms')->name('admin.forms');

Route::view('/tables', 'admin.tables')->name('admin.tables');
Route::view('/datatables', 'admin.datatables')->name('admin.datatables');

Route::view('/googlemaps', 'admin.googlemaps')->name('admin.googlemaps');
Route::view('/jsvectormap', 'admin.jsvectormap')->name('admin.jsvectormap');

Route::view('/charts', 'admin.charts')->name('admin.charts');
Route::view('/widgets', 'admin.widgets')->name('admin.widgets');
Route::view('/sparkline', 'admin.sparkline')->name('admin.sparkline');
