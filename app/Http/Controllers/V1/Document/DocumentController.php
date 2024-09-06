<?php

namespace App\Http\Controllers\V1\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Models\Document\Document;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{


    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('access document'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $pages = $request->input('pages', 10);
        $order_by = $request->input('order_by', 'ASC');
        $sort_by = $request->input('sort_by', 'name');

        $documents = Document::with(['user:id,name'])
            ->where(function ($query) use ($request) {
                $query->when($request->has('query'), function ($query) use ($request) {
                    $queryString = trim($request['query']);
                    $query->where('name', 'LIKE', "%{$queryString}%")
                    ->orWhere('category', 'LIKE', "%{$queryString}%")
                    ->orWhere('description', 'LIKE', "%{$queryString}%")
                    ->orWhere('status', 'LIKE', "%{$queryString}%");
                });
            })
            ->where(function ($query){
                if(!in_array(auth()->user()->role,['Super Admin','Admin'])){
                    $query->where('user_id', auth()->user()->id);
                }
            })

            ->orderBy($sort_by, $order_by)
            ->paginate($pages)
            ->withQueryString();


        $this->removeTempFile();

        return inertia('Document/Index', [
            'documents' => $documents,
            'request' => $request->all(),
        ]);

    }

    public function create()
    {
        abort_if(!auth()->user()->can('create document'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        return inertia('Admin/Document/Form');
    }

    public function edit($id)
    {
        abort_if(!auth()->user()->can('edit document'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $document = Document::find($id);

        return inertia('Document/Form');
    }

    public function show($id)
    {
        abort_if(!auth()->user()->can('view document'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $document = Document::with([])->find($id);
        return inertia('Document/Show');
    }

    public function store(StoreDocumentRequest $request)
    {

        $document_arr = $request->validated();

        $document = Document::create($document_arr);

        $this->saveFile($document, $request);

        return redirect()->back();
    }


    public function update(UpdateDocumentRequest $request, $id): \Illuminate\Http\RedirectResponse
    {


        $document_arr = $request->validated();

        $document = Document::find($id);
        $document->update($document_arr);

        $this->saveFile($document, $request);

        return redirect()->back();
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        abort_if(!auth()->user()->can('delete document'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $document = Document::find($id);
        $document->delete();

        return redirect()->back();
    }

    public function saveFile($model,$request){

        if($request->input('remove_image')){
            $model->clearMediaCollection('files');
        }
        $temporary_file = TemporaryFile::whereFolder($request->file)->first();

        if($temporary_file){
            $model->clearMediaCollection('files');
            $model->addMedia(storage_path('app/files/tmp/'.auth()->user()->id.'/'.$request->file.'/'.$temporary_file->filename))
                ->toMediaCollection('files');
            $temporary_file->delete();
        }
        $this->removeTempFile();
    }

    public function removeTempFile()
    {
        TemporaryFile::whereUserId(auth()->user()->id)->delete();

        $directory = storage_path('app/files/tmp/'.auth()->user()->id.'/');

        if (File::isDirectory($directory)) {
            $files = File::files($directory);
            foreach ($files as $file) {
                File::delete($file);
            }
            File::deleteDirectory($directory);
        }
    }
}
