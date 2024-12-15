<?php
use App\Http\Controllers\blogs\BlogCategoryController;
use App\Http\Controllers\blogs\BlogController;
use App\Http\Controllers\blogs\CommentsController;
use Illuminate\Support\Facades\Route;


Route::prefix('/blog')->group(function () {
    Route::controller(BlogCategoryController::class)->group(function () {
        Route::get('category', 'view')->name("admin.blogCategoryView")->middleware(['permission:read']);
        Route::post('category', 'action')->name("admin.blogCategoryAction");
    });
    Route::controller(BlogController::class)->group(function () {
        Route::get('', 'view')->name("admin.blog")->middleware(['permission:read']);
        Route::get('draft', 'draft')->name("admin.blog.draft")->middleware(['permission:read']);
        Route::get('published', 'published')->name("admin.blog.published")->middleware(['permission:read']);
        Route::get('create-update/{slug?}', 'form')->name("admin.blogForm")->middleware(['rtpermission:admin.blog,admin.blog.draft,admin.blog.published']);
        Route::post('', 'action')->name("admin.blogAction");
    });
    Route::controller(CommentsController::class)->group(function () {
        Route::get('/comments', 'view')->name("admin.blog.comments");
    });
});


