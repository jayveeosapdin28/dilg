<?php

namespace App\Http\Controllers\V1\Rank;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rank\StoreRankRequest;
use App\Http\Requests\Rank\UpdateRankRequest;
use App\Models\Rank\Rank;
use App\Models\TaskDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RankController extends Controller
{


    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('access rank'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

              $pages = $request->input('pages', 10);
              $order_by = $request->input('order_by', 'ASC');
              $sort_by = $request->input('sort_by', 'id');

              $ranks =  DB::table('task_documents')
                  ->join('users', 'task_documents.user_id', '=', 'users.id')
                  ->select('users.id', 'users.name', DB::raw('SUM(task_documents.score) as total_score'))
                  ->groupBy('users.id', 'users.name')
                  ->orderBy('total_score', 'desc')
                  ->paginate(10)
                  ->withQueryString();

              return inertia('Rank/Index', [
                  'data' => $ranks,
                  'request' => $request->all(),
              ]);

    }


    public function edit($id)
    {
        abort_if(!auth()->user()->can('edit rank'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $rank = Rank::find($id);

        return inertia('Rank/Form');
    }

    public function show($id)
    {
        abort_if(!auth()->user()->can('view rank'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $rank = Rank::with([])->find($id);
        return inertia('Rank/Show');
    }

    public function store(StoreRankRequest $request)
    {

         $rank_arr = $request->validated();

         $rank = Rank::create( $rank_arr);

         return redirect()->back();
    }


    public function update(UpdateRankRequest $request, $id): \Illuminate\Http\RedirectResponse
    {

        $rank_arr = $request->validated();

        $rank = Rank::find($id);
        $rank->update($rank_arr);

        return redirect()->back();
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        abort_if(!auth()->user()->can('delete rank'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $rank = Rank::find($id);
        $rank->delete();

        return redirect()->back();
    }
}
