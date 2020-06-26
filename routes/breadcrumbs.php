<?php


//
//Breadcrumbs::for('home' , function ($trail) {
//    $trail->push(__('breadcrumbs.home') , url('/'));
//});


// Home > dashboard
Breadcrumbs::for('dashboard', function ($trail) {
//    $trail->parent('home');
    $trail->push(__('breadcrumbs.dashboard') , route('index.index'));
});


// Home > dashboard > create_new
Breadcrumbs::for('bill_create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('layout.create_new_bill') , route('bill.create'));
});

Breadcrumbs::for('upload_files', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('layout.upload') , route('file.create'));
});

Breadcrumbs::for('my_files', function ($trail) {
    $trail->parent('upload_files');
    $trail->push(__('layout.my_file') , route('my-files.index'));
});

Breadcrumbs::for('public_file', function ($trail) {
    $trail->parent('my_files');
    $trail->push(__('layout.public_file') , route('my-files.index'));
});

Breadcrumbs::for('admin_file', function ($trail) {
    $trail->parent('public_file');
    $trail->push(__('layout.all_files') , route('my-files.index'));
});

Breadcrumbs::for('file_cat', function ($trail) {
    $trail->parent('upload_files');
    $trail->push(__('breadcrumbs.cat') , route('file_cat.create'));
});


Breadcrumbs::for('create_demand' , function ($trail) {
   $trail->parent('dashboard');
    $trail->push(__('layout.create_demand') , route('demand.create'));

});
