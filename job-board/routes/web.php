<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MyJobApplicationController;
use App\Http\Controllers\MyJobController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('', fn () => to_route('jobs.index'));

Route::resource('jobs', JobController::class)->only(['index','show']);

Route::get('login', fn () => to_route('auth.create'))->name('login');


Route::resource('auth',AuthController::class)->only(['create', 'store']);

Route::delete('logout', fn () => to_route('auth.destroy'))->name('logout');
//created seprate delete route from that above resource because if we use resource destroy method then url is auth/{id} but we did not need of id thats why create seprate delete route
Route::delete('auth',[AuthController::class , 'destroy'])
  ->name('auth.destroy');

  //it will check the user is authenticate and provide access this middleware to this group
Route::middleware('auth')->group(function(){
  Route::resource('job.application', JobApplicationController::class)
    ->only(['create','store']);

  Route::middleware('applicant')->resource('my-job-applications', MyJobApplicationController::class)
    ->only(['index','destroy']);

  Route::resource('employer', EmployerController::class)
    ->only(['create','store']);

  Route::middleware('employer')->resource('my-jobs', MyJobController::class); //this middleware verify that the user is employer
  
  
  
  Route::get('my-jobs/{my_job}/cv/{filename}', [MyJobController::class, 'getcv'])->middleware('employer')->name('cv.download'); // Download CV route for employers
});


Route::get('file', function () {
  $filename = '1GdSy4IGdj2IYTVaCfSuFFBd4JDQfp3IERj8pCTR.pdf';
  $path = storage_path('app/private/cvs/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('file');

Route::get('/forgot-password', function () {
  return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
  $request->validate(['email' => 'required|email']);

  $status = Password::sendResetLink(
      $request->only('email')
  );

  return $status === Password::RESET_LINK_SENT
              ? back()->with('success' , __($status))
              : back()->with('error' , __($status));
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
  return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');


Route::post('/reset-password', function (Request $request) {
  $request->validate([
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|min:8',
  ]);
  $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function (User $user, string $password) {
          $user->forceFill([
              'password' => Hash::make($password)
          ])->setRememberToken(str::random(60));

          $user->save();

          event(new PasswordReset($user));
      }
  );

  return $status === Password::PASSWORD_RESET
              ? redirect()->route('auth.create')->with('success' , __($status))
              : back()->with('error', __($status));
})->middleware('guest')->name('password.update');
