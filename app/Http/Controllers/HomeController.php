<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests;
use App\User;
use Chumper\Datatable\Facades\DatatableFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllTransfers()
    {
        return view('home');
        /*

        */
    }

    public function showAllTransfers()
    {
        return DatatableFacade::query(DB::table('transfer_logs')
            ->select('date', DB::raw('SUM(transferred) as transferred'), 'companies.name', 'companies.id')
            ->join('user', 'transfer_logs.user_id', '=', 'user.id')
            ->join('companies', 'user.company_id', '=', 'companies.id')
            ->groupBy('date'))
            ->searchColumns('name')
            ->orderColumns('transferred', 'name', 'date')
            ->addColumn('transferred', function ($model) {
                return $model->transferred;
            })
            ->addColumn('name', function ($model) {
                return '<div class="name-value show ">' . $model->name . '</div><form class="name-form"><input  type="input" required  name="nameinput" class="name-input hidden" value="' . $model->name . ' "></form>';
            })
            ->addColumn('date', function ($model) {
                return '<div class="date-value show ">' . $model->date . '</div><form class="date-form"><input  type="text" class="date-input hidden" value="' . $model->date . '"></form>';
            })
            ->addColumn('View', function ($model) {
                return "<a class='edit-link' href='edit/" . $model->id . "/date/" . $model->date . "'>Edit</a> / <a class='delete-link' href='delete/" . $model->id . "/date/" . $model->date . "'>Delete</a>";
            })
            ->make();
    }

    public function delete($id, $date)
    {
        $users = Company::find($id)->users;

        foreach ($users as $user) {
            $user->transferLogs->where('date', $date)->each(function ($log) {
                $log->delete();
            });
        }
    }

    public function edit($id, $date, Request $request)
    {
        $name = $request->input('name');
        $newDate = $request->input('date');
        
        $company = Company::find($id);
        $company->name = $name;
        $company->save();
        
        $users = $company->users;
        foreach ($users as $user) {
            $user->transferLogs->where('date', $date)->each(function ($log) use ($newDate) {
                $log->date = $newDate;
                $log->save();
            });
        }
    }
}
