<?php

namespace App\Http\Controllers\V1\Case;

use App\Http\Controllers\Controller;
use App\Http\Requests\Case\StoreCaseRequest;
use App\Http\Requests\Case\UpdateCaseRequest;
use App\Models\Case\CaseFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class CaseController extends Controller
{


    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('access case'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

              $pages = $request->input('pages', 10);
              $order_by = $request->input('order_by', 'ASC');
              $sort_by = $request->input('sort_by', 'name');

              $cases = CaseFile::with([])
                  ->where(function ($query) use ($request) {
                      $query->when($request->has('query'), function ($query) use ($request) {
                          $queryString = trim($request['query']);
                          $query->where('name', 'LIKE', "%{$queryString}%");
                      });
                  })
                  ->when(auth()->user()->role === 'User',function ($query){
                      $query->where('user_id', auth()->user()->id);
                  })
                  ->orderBy($sort_by, $order_by)
                  ->paginate($pages)
                  ->withQueryString();



              return inertia('Case/Index', [
                  'cases' => $cases,
                  'request' => $request->all(),
              ]);

    }


    public function edit($id)
    {
        abort_if(!auth()->user()->can('edit case'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $case = CaseFile::find($id);

        return inertia('CaseFile/Form');
    }

    public function show($id)
    {
        abort_if(!auth()->user()->can('view case'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $case = CaseFile::with([])->find($id);
        return inertia('CaseFile/Show');
    }

    public function store(StoreCaseRequest $request)
    {

         $case_arr = $request->validated();

         $case = CaseFile::create( $case_arr);

         return redirect()->back();
    }


    public function update(UpdateCaseRequest $request, $id): \Illuminate\Http\RedirectResponse
    {

        $case_arr = $request->validated();

        $case = CaseFile::find($id);
        $case->update($case_arr);

        return redirect()->back();
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        abort_if(!auth()->user()->can('delete case'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $case = CaseFile::find($id);
        $case->delete();

        return redirect()->back();
    }
}
