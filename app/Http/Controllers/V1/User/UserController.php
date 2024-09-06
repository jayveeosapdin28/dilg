<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{


    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('access user'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $superAdminIds = User::role('Super Admin')->pluck('id');

        $pages = $request->input('pages', 10);
        $order_by = $request->input('order_by', 'ASC');
        $sort_by = $request->input('sort_by', 'name');

        $users = User::with([])
            ->where(function ($query) use ($request) {
                $query->when($request->has('query'), function ($query) use ($request) {
                    $queryString = trim($request['query']);
                    $query->where('name', 'LIKE', "%{$queryString}%");
                });
            })
            ->where('id', '!=', auth()->user()->id)
            ->orderBy($sort_by, $order_by)
            ->paginate($pages)
            ->withQueryString();

        return inertia('User/Index', [
            'users' => $users,
            'roles' => Role::select(['name'])
                ->where(function ($query) {
                    $role = auth()->user()->role;
                    if (in_array($role, ['Admin', 'User'])) {
                        $query->where('name', '!=', 'Super Admin');
                    }
                })
                ->get()->pluck('name'),
            'request' => $request->all(),
        ]);

    }


    public function edit($id)
    {
        abort_if(!auth()->user()->can('edit user'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $user = User::find($id);

        return inertia('User/Form');
    }

    public function show($id)
    {
        abort_if(!auth()->user()->can('view user'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $user = User::with([])->find($id);
        return inertia('User/Show');
    }

    public function store(StoreUserRequest $request)
    {

        $user_arr = $request->validated();

        $user = User::create($user_arr);
        $user->syncRoles($user_arr['role']);

        return redirect()->back();
    }


    public function update(UpdateUserRequest $request, $id): \Illuminate\Http\RedirectResponse
    {

        $user_arr = $request->validated();
        $user = User::find($id);
        $user->update($user_arr);
        $user->syncRoles($user_arr['role']);

        return redirect()->back();
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        abort_if(!auth()->user()->can('delete user'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $user = User::find($id);
        $user->delete();

        return redirect()->back();
    }
}
