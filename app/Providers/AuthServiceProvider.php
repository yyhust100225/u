<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Department;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\Permission;
use App\Models\Printer;
use App\Models\Role;
use App\Models\Statement;
use App\Models\User;
use App\Policies\BookPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\ExamCategoryPolicy;
use App\Policies\ExamPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PrinterPolicy;
use App\Policies\RolePolicy;
use App\Policies\StatementPolicy;
use App\Policies\UserPolicy;
use App\Models\Materiel;
use App\Policies\MaterielPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Department::class => DepartmentPolicy::class,
        Book::class => BookPolicy::class,
        Materiel::class => MaterielPolicy::class,
        Printer::class => PrinterPolicy::class,
        Exam::class => ExamPolicy::class,
        ExamCategory::class => ExamCategoryPolicy::class,
        Statement::class => StatementPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
