<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\EmployeeRepository;

class EmployeePartialComposer
{
    protected $employees;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(EmployeeRepository $employeeRepo)
    {
        $this->employees = $employeeRepo->getEmployees();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['employees' => $this->employees]);
    }
}