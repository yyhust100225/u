<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::namespace('Common')->group(function(){
    Route::middleware(['web.auth'])->group(function(){
        Route::post('upload', 'FileController@upload')->name('file.upload');
        Route::post('upload/editor/image', 'FileController@uploadEditorImage')->name('file.upload.editor.image');
        Route::get('download/{id}', 'FileController@download')->name('file.download');
    });
});

Route::namespace('Admin')->group(function(){
    Route::get('login/form', 'LoginController@showLoginForm')->name('login.form');
    Route::post('login', 'LoginController@login')->name('login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::middleware(['web.auth'])->group(function(){
        Route::get('/', 'HomeController@index');
        Route::get('home', 'HomeController@home')->name('home');
        Route::get('main', 'HomeController@main')->name('main');


        Route::get('users', 'UserController@list')->name('users.list');
        Route::get('users/data', 'UserController@data')->name('users.data');
        Route::get('users/create', 'UserController@create')->name('users.create');
        Route::post('users/store', 'UserController@store')->name('users.store');
        Route::get('users/edit/{id}', 'UserController@edit')->name('users.edit');
        Route::put('users/update', 'UserController@update')->name('users.update');
        Route::delete('users/delete', 'UserController@delete')->name('users.delete');
        Route::get('users/password', 'UserController@password')->name('users.password');
        Route::put('users/reset', 'UserController@reset')->name('users.reset');

        Route::get('roles', 'RoleController@list')->name('roles.list');
        Route::get('roles/data', 'RoleController@data')->name('roles.data');
        Route::get('roles/create', 'RoleController@create')->name('roles.create');
        Route::post('roles/store', 'RoleController@store')->name('roles.store');
        Route::get('roles/edit/{id}', 'RoleController@edit')->name('roles.edit');
        Route::put('roles/update', 'RoleController@update')->name('roles.update');
        Route::delete('roles/delete', 'RoleController@delete')->name('roles.delete');

        Route::get('permissions', 'PermissionController@list')->name('permissions.list');
        Route::get('permissions/data', 'PermissionController@data')->name('permissions.data');
        Route::get('permissions/create', 'PermissionController@create')->name('permissions.create');
        Route::post('permissions/store', 'PermissionController@store')->name('permissions.store');
        Route::get('permissions/edit/{id}', 'PermissionController@edit')->name('permissions.edit');
        Route::put('permissions/update', 'PermissionController@update')->name('permissions.update');
        Route::delete('permissions/delete', 'PermissionController@delete')->name('permissions.delete');

        Route::get('departments', 'DepartmentController@list')->name('departments.list');
        Route::get('departments/data', 'DepartmentController@data')->name('departments.data');
        Route::get('departments/create', 'DepartmentController@create')->name('departments.create');
        Route::post('departments/store', 'DepartmentController@store')->name('departments.store');
        Route::get('departments/edit/{id}', 'DepartmentController@edit')->name('departments.edit');
        Route::put('departments/update', 'DepartmentController@update')->name('departments.update');
        Route::delete('departments/delete', 'DepartmentController@delete')->name('departments.delete');

        Route::get('books', 'BookController@list')->name('books.list');
        Route::get('books/data', 'BookController@data')->name('books.data');
        Route::get('books/create', 'BookController@create')->name('books.create');
        Route::post('books/store', 'BookController@store')->name('books.store');
        Route::get('books/edit/{id}', 'BookController@edit')->name('books.edit');
        Route::put('books/update', 'BookController@update')->name('books.update');
        Route::delete('books/delete', 'BookController@delete')->name('books.delete');
        Route::get('books/increase/{id}', 'BookController@increase')->name('books.increase');
        Route::put('books/supplement', 'BookController@supplement')->name('books.supplement');
        Route::get('books/decrease/{id}', 'BookController@decrease')->name('books.decrease');
        Route::put('books/consume', 'BookController@consume')->name('books.consume');

        Route::get('materiels', 'MaterielController@list')->name('materiels.list');
        Route::get('materiels/data', 'MaterielController@data')->name('materiels.data');
        Route::get('materiels/create', 'MaterielController@create')->name('materiels.create');
        Route::post('materiels/store', 'MaterielController@store')->name('materiels.store');
        Route::get('materiels/edit/{id}', 'MaterielController@edit')->name('materiels.edit');
        Route::put('materiels/update', 'MaterielController@update')->name('materiels.update');
        Route::delete('materiels/delete', 'MaterielController@delete')->name('materiels.delete');
        Route::get('materiels/increase/{id}', 'MaterielController@increase')->name('materiels.increase');
        Route::put('materiels/supplement', 'MaterielController@supplement')->name('materiels.supplement');
        Route::get('materiels/decrease/{id}', 'MaterielController@decrease')->name('materiels.decrease');
        Route::put('materiels/consume', 'MaterielController@consume')->name('materiels.consume');

        Route::get('printers', 'PrinterController@list')->name('printers.list');
        Route::get('printers/data', 'PrinterController@data')->name('printers.data');
        Route::get('printers/create', 'PrinterController@create')->name('printers.create');
        Route::post('printers/store', 'PrinterController@store')->name('printers.store');
        Route::get('printers/edit/{id}', 'PrinterController@edit')->name('printers.edit');
        Route::put('printers/update', 'PrinterController@update')->name('printers.update');
        Route::delete('printers/delete', 'PrinterController@delete')->name('printers.delete');

        Route::get('printed_matters', 'PrintedMatterController@list')->name('printed_matters.list');
        Route::get('printed_matters/data', 'PrintedMatterController@data')->name('printed_matters.data');
        Route::get('printed_matters/create', 'PrintedMatterController@create')->name('printed_matters.create');
        Route::post('printed_matters/store', 'PrintedMatterController@store')->name('printed_matters.store');
        Route::get('printed_matters/edit/{id}', 'PrintedMatterController@edit')->name('printed_matters.edit');
        Route::put('printed_matters/update', 'PrintedMatterController@update')->name('printed_matters.update');
        Route::delete('printed_matters/delete', 'PrintedMatterController@delete')->name('printed_matters.delete');

        Route::get('exams', 'ExamController@list')->name('exams.list');
        Route::get('exams/data', 'ExamController@data')->name('exams.data');
        Route::get('exams/create', 'ExamController@create')->name('exams.create');
        Route::post('exams/store', 'ExamController@store')->name('exams.store');
        Route::get('exams/edit/{id}', 'ExamController@edit')->name('exams.edit');
        Route::put('exams/update', 'ExamController@update')->name('exams.update');
        Route::delete('exams/delete', 'ExamController@delete')->name('exams.delete');

        Route::get('exam_categories', 'ExamCategoryController@list')->name('exam_categories.list');
        Route::get('exam_categories/data', 'ExamCategoryController@data')->name('exam_categories.data');
        Route::get('exam_categories/create', 'ExamCategoryController@create')->name('exam_categories.create');
        Route::post('exam_categories/store', 'ExamCategoryController@store')->name('exam_categories.store');
        Route::get('exam_categories/edit/{id}', 'ExamCategoryController@edit')->name('exam_categories.edit');
        Route::put('exam_categories/update', 'ExamCategoryController@update')->name('exam_categories.update');
        Route::delete('exam_categories/delete', 'ExamCategoryController@delete')->name('exam_categories.delete');

        Route::get('statements', 'StatementController@list')->name('statements.list');
        Route::get('statements/data', 'StatementController@data')->name('statements.data');
        Route::get('statements/create', 'StatementController@create')->name('statements.create');
        Route::post('statements/store', 'StatementController@store')->name('statements.store');
        Route::get('statements/edit/{id}', 'StatementController@edit')->name('statements.edit');
        Route::put('statements/update', 'StatementController@update')->name('statements.update');
        Route::delete('statements/delete', 'StatementController@delete')->name('statements.delete');

        Route::get('book_sales', 'BookSaleController@list')->name('book_sales.list');
        Route::get('book_sales/data', 'BookSaleController@data')->name('book_sales.data');
        Route::get('book_sales/create', 'BookSaleController@create')->name('book_sales.create');
        Route::post('book_sales/store', 'BookSaleController@store')->name('book_sales.store');
        Route::get('book_sales/edit/{id}', 'BookSaleController@edit')->name('book_sales.edit');
        Route::put('book_sales/update', 'BookSaleController@update')->name('book_sales.update');
        Route::delete('book_sales/delete', 'BookSaleController@delete')->name('book_sales.delete');

        // 支付设置路由
        Route::get('payment_methods', 'PaymentMethodController@list')->name('payment_methods.list');
        Route::get('payment_methods/data', 'PaymentMethodController@data')->name('payment_methods.data');
        Route::get('payment_methods/create', 'PaymentMethodController@create')->name('payment_methods.create');
        Route::post('payment_methods/store', 'PaymentMethodController@store')->name('payment_methods.store');
        Route::get('payment_methods/edit/{id}', 'PaymentMethodController@edit')->name('payment_methods.edit');
        Route::put('payment_methods/update', 'PaymentMethodController@update')->name('payment_methods.update');
        Route::delete('payment_methods/delete', 'PaymentMethodController@delete')->name('payment_methods.delete');

        // 民族设置
        Route::get('nations', 'NationController@list')->name('nations.list');
        Route::get('nations/data', 'NationController@data')->name('nations.data');
        Route::get('nations/create', 'NationController@create')->name('nations.create');
        Route::post('nations/store', 'NationController@store')->name('nations.store');
        Route::get('nations/edit/{id}', 'NationController@edit')->name('nations.edit');
        Route::put('nations/update', 'NationController@update')->name('nations.update');
        Route::delete('nations/delete', 'NationController@delete')->name('nations.delete');

        // 保险地区设置路由
        Route::get('insurance_areas', 'InsuranceAreaController@list')->name('insurance_areas.list');
        Route::get('insurance_areas/data', 'InsuranceAreaController@data')->name('insurance_areas.data');
        Route::get('insurance_areas/create', 'InsuranceAreaController@create')->name('insurance_areas.create');
        Route::post('insurance_areas/store', 'InsuranceAreaController@store')->name('insurance_areas.store');
        Route::get('insurance_areas/edit/{id}', 'InsuranceAreaController@edit')->name('insurance_areas.edit');
        Route::put('insurance_areas/update', 'InsuranceAreaController@update')->name('insurance_areas.update');
        Route::delete('insurance_areas/delete', 'InsuranceAreaController@delete')->name('insurance_areas.delete');

        // 要讯类型设置路由
        Route::get('notice_types', 'NoticeTypeController@list')->name('notice_types.list');
        Route::get('notice_types/data', 'NoticeTypeController@data')->name('notice_types.data');
        Route::get('notice_types/create', 'NoticeTypeController@create')->name('notice_types.create');
        Route::post('notice_types/store', 'NoticeTypeController@store')->name('notice_types.store');
        Route::get('notice_types/edit/{id}', 'NoticeTypeController@edit')->name('notice_types.edit');
        Route::put('notice_types/update', 'NoticeTypeController@update')->name('notice_types.update');
        Route::delete('notice_types/delete', 'NoticeTypeController@delete')->name('notice_types.delete');

        // 员工职务设置
        Route::get('jobs', 'JobController@list')->name('jobs.list');
        Route::get('jobs/data', 'JobController@data')->name('jobs.data');
        Route::get('jobs/create', 'JobController@create')->name('jobs.create');
        Route::post('jobs/store', 'JobController@store')->name('jobs.store');
        Route::get('jobs/edit/{id}', 'JobController@edit')->name('jobs.edit');
        Route::put('jobs/update', 'JobController@update')->name('jobs.update');
        Route::delete('jobs/delete', 'JobController@delete')->name('jobs.delete');

        // 员工档案
        Route::get('employees', 'EmployeeController@list')->name('employees.list');
        Route::get('employees/data', 'EmployeeController@data')->name('employees.data');
        Route::get('employees/create', 'EmployeeController@create')->name('employees.create');
        Route::post('employees/store', 'EmployeeController@store')->name('employees.store');
        Route::get('employees/edit/{id}', 'EmployeeController@edit')->name('employees.edit');
        Route::put('employees/update', 'EmployeeController@update')->name('employees.update');
        Route::delete('employees/delete', 'EmployeeController@delete')->name('employees.delete');

        // 集团要讯
        Route::get('notices', 'NoticeController@list')->name('notices.list');
        Route::get('notices/data', 'NoticeController@data')->name('notices.data');
        Route::get('notices/browse/{id}', 'NoticeController@browse')->name('notices.browse');
        Route::get('notices/publish', 'NoticeController@publish')->name('notices.publish');
        Route::get('notices/publish/data', 'NoticeController@publishData')->name('notices.publish.data');
        Route::put('notices/commit', 'NoticeController@commit')->name('notices.commit');
        Route::put('notices/withdraw', 'NoticeController@withdraw')->name('notices.withdraw');
        Route::get('notices/create', 'NoticeController@create')->name('notices.create');
        Route::post('notices/store', 'NoticeController@store')->name('notices.store');
        Route::get('notices/edit/{id}', 'NoticeController@edit')->name('notices.edit');
        Route::put('notices/update', 'NoticeController@update')->name('notices.update');
        Route::delete('notices/delete', 'NoticeController@delete')->name('notices.delete');
        Route::get('notices/reviews', 'NoticeController@reviews')->name('notices.reviews');
        Route::get('notices/reviews/data', 'NoticeController@reviewsData')->name('notices.reviews.data');
        Route::get('notices/show/{id}', 'NoticeController@show')->name('notices.show');
        Route::put('notices/approve', 'NoticeController@approve')->name('notices.approve');
        Route::put('notices/reject', 'NoticeController@reject')->name('notices.reject');

        // 城市设置
        Route::get('cities', 'CityController@list')->name('cities.list');
        Route::get('cities/data', 'CityController@data')->name('cities.data');
        Route::get('cities/create', 'CityController@create')->name('cities.create');
        Route::post('cities/store', 'CityController@store')->name('cities.store');
        Route::get('cities/edit/{id}', 'CityController@edit')->name('cities.edit');
        Route::put('cities/update', 'CityController@update')->name('cities.update');
        Route::delete('cities/delete', 'CityController@delete')->name('cities.delete');

        // 开班公告
        Route::get('class_announcements', 'ClassAnnouncementController@list')->name('class_announcements.list');
        Route::get('class_announcements/data', 'ClassAnnouncementController@data')->name('class_announcements.data');
        Route::get('class_announcements/create', 'ClassAnnouncementController@create')->name('class_announcements.create');
        Route::post('class_announcements/store', 'ClassAnnouncementController@store')->name('class_announcements.store');
        Route::get('class_announcements/edit/{id}', 'ClassAnnouncementController@edit')->name('class_announcements.edit');
        Route::put('class_announcements/update', 'ClassAnnouncementController@update')->name('class_announcements.update');
        Route::delete('class_announcements/delete', 'ClassAnnouncementController@delete')->name('class_announcements.delete');

        // 考试管理
        Route::get('class_examinations', 'ClassExaminationController@list')->name('class_examinations.list');
        Route::get('class_examinations/data', 'ClassExaminationController@data')->name('class_examinations.data');
        Route::get('class_examinations/create', 'ClassExaminationController@create')->name('class_examinations.create');
        Route::post('class_examinations/store', 'ClassExaminationController@store')->name('class_examinations.store');
        Route::get('class_examinations/edit/{id}', 'ClassExaminationController@edit')->name('class_examinations.edit');
        Route::put('class_examinations/update', 'ClassExaminationController@update')->name('class_examinations.update');
        Route::delete('class_examinations/delete', 'ClassExaminationController@delete')->name('class_examinations.delete');
        Route::get('class_examination_discounts/data', 'ClassExaminationController@discountsData')->name('class_examination_discounts.data');
        Route::get('class_examination_discounts/create/{examination_id}', 'ClassExaminationController@discountCreate')->name('class_examination_discounts.create');
        Route::post('class_examination_discounts/store', 'ClassExaminationController@discountStore')->name('class_examination_discounts.store');
        Route::get('class_examination_discounts/edit/{id}', 'ClassExaminationController@discountEdit')->name('class_examination_discounts.edit');
        Route::put('class_examination_discounts/update', 'ClassExaminationController@discountUpdate')->name('class_examination_discounts.update');
        Route::delete('class_examination_discounts/delete', 'ClassExaminationController@discountDelete')->name('class_examination_discounts.delete');
        Route::get('class_examination_discounts/{id}', 'ClassExaminationController@discounts')->name('class_examination_discounts.list');

        // 班型管理
        Route::get('class_types', 'ClassTypeController@list')->name('class_types.list');
        Route::get('class_types/data', 'ClassTypeController@data')->name('class_types.data');
        Route::get('class_types/create', 'ClassTypeController@create')->name('class_types.create');
        Route::post('class_types/store', 'ClassTypeController@store')->name('class_types.store');
        Route::get('class_types/edit/{id}', 'ClassTypeController@edit')->name('class_types.edit');
        Route::put('class_types/update', 'ClassTypeController@update')->name('class_types.update');
        Route::delete('class_types/delete', 'ClassTypeController@delete')->name('class_types.delete');
        Route::get('class_type_discounts/data', 'ClassTypeController@discountsData')->name('class_type_discounts.data');
        Route::get('class_type_discounts/create/{type_id}', 'ClassTypeController@discountCreate')->name('class_type_discounts.create');
        Route::post('class_type_discounts/store', 'ClassTypeController@discountStore')->name('class_type_discounts.store');
        Route::get('class_type_discounts/edit/{id}', 'ClassTypeController@discountEdit')->name('class_type_discounts.edit');
        Route::put('class_type_discounts/update', 'ClassTypeController@discountUpdate')->name('class_type_discounts.update');
        Route::delete('class_type_discounts/delete', 'ClassTypeController@discountDelete')->name('class_type_discounts.delete');
        Route::get('class_type_discounts/{id}', 'ClassTypeController@discounts')->name('class_type_discounts.list');

        // 班级管理
        Route::get('class_courses', 'ClassCourseController@list')->name('class_courses.list');
        Route::get('class_courses/data', 'ClassCourseController@data')->name('class_courses.data');
        Route::get('class_courses/create', 'ClassCourseController@create')->name('class_courses.create');
        Route::post('class_courses/store', 'ClassCourseController@store')->name('class_courses.store');
        Route::get('class_courses/edit/{id}', 'ClassCourseController@edit')->name('class_courses.edit');
        Route::put('class_courses/update', 'ClassCourseController@update')->name('class_courses.update');
        Route::delete('class_courses/delete', 'ClassCourseController@delete')->name('class_courses.delete');

        /**
         * =====================================
         * 学员管理                            *
         * =====================================
         */

        // TQ同步学员
        Route::get('TQ_students', 'TQController@list')->name('TQ_students.list');
        Route::get('TQ_students/data', 'TQController@data')->name('TQ_students.data');
        Route::post('TQ_students/sync', 'TQController@sync')->name('TQ_students.sync');
        Route::get('TQ_students/edit', 'TQController@edit')->name('TQ_students.edit');
        Route::put('TQ_students/update', 'TQController@update')->name('TQ_students.update');

        // 学员管理
        Route::get('students', 'StudentController@list')->name('students.list');
        Route::get('students/data', 'StudentController@data')->name('students.data');
        Route::get('students/create/{id}', 'StudentController@create')->name('students.create');
        Route::get('students/class_courses', 'StudentController@classCourses')->name('students.class_courses');
        Route::get('students/class_courses/data', 'StudentController@classCoursesData')->name('students.class_courses.data');
        Route::get('students/search', 'StudentController@search')->name('students.search');
        Route::get('students/searched', 'StudentController@searched')->name('students.searched');
        Route::post('students/store', 'StudentController@store')->name('students.store');
        Route::get('students/edit/{id}', 'StudentController@edit')->name('students.edit');
        Route::put('students/update', 'StudentController@update')->name('students.update');
        Route::delete('students/delete', 'StudentController@delete')->name('students.delete');

        /**
         * =====================================
         * 教务管理                            *
         * =====================================
         */

        // 教师档案
        Route::get('teachers', 'TeacherController@list')->name('teachers.list');
        Route::get('teachers/data', 'TeacherController@data')->name('teachers.data');
        Route::get('teachers/create', 'TeacherController@create')->name('teachers.create');
        Route::post('teachers/store', 'TeacherController@store')->name('teachers.store');
        Route::get('teachers/edit/{id}', 'TeacherController@edit')->name('teachers.edit');
        Route::put('teachers/update', 'TeacherController@update')->name('teachers.update');
        Route::delete('teachers/delete', 'TeacherController@delete')->name('teachers.delete');

        // 科目管理
        Route::get('subjects', 'SubjectController@list')->name('subjects.list');
        Route::get('subjects/data', 'SubjectController@data')->name('subjects.data');
        Route::get('subjects/create', 'SubjectController@create')->name('subjects.create');
        Route::post('subjects/store', 'SubjectController@store')->name('subjects.store');
        Route::get('subjects/edit/{id}', 'SubjectController@edit')->name('subjects.edit');
        Route::put('subjects/update', 'SubjectController@update')->name('subjects.update');
        Route::delete('subjects/delete', 'SubjectController@delete')->name('subjects.delete');
    });
});
