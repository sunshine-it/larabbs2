<?php

// 首页
Route::get('/', 'PagesController@root')->name('root');
// 用户认证功能 | 用户认证路由
Auth::routes();
//用户资源
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
// 话题列表
Route::resource('topics', 'TopicsController', ['only' => ['index','create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');
// 分类下的话题列表
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);
// 上传图片
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);
// 消息通知显示路由
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);