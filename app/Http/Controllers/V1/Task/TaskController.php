<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task\Task;
use App\Models\TaskDocument;
use App\Models\TemporaryFile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class TaskController extends Controller
{


    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('access task'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $pages = $request->input('pages', 10);
        $order_by = $request->input('order_by', 'DESC');
        $sort_by = $request->input('sort_by', 'created_at');

        $tasks = Task::with([])
            ->where(function ($query) use ($request) {
                $query->when($request->has('query'), function ($query) use ($request) {
                    $queryString = trim($request['query']);
                    $query->where('name', 'LIKE', "%{$queryString}%");
                });
            })
            ->whereJsonContains('users', auth()->user()->id)
            ->orderBy($sort_by, $order_by)
            ->paginate($pages)
            ->withQueryString();


        return inertia('Task/Index', [
            'tasks' => $tasks,
            'users' => User::option(),
            'request' => $request->all(),
        ]);

    }

    public function submitDocument(Request $request){
        $task = Task::find($request->task_id);

        $docs = TaskDocument::updateOrCreate([
            'task_id' => $request->task_id,
            'user_id' => auth()->user()->id,
        ],[
            'task_id' => $request->task_id,
            'score' => $this->calculatePoints($task->due_date)
        ]);
        $this->saveFile($docs, $request);

        return redirect()->route('admin.tasks.index');
    }

    public function edit($id)
    {
        abort_if(!auth()->user()->can('edit task'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $task = Task::find($id);

        return inertia('Task/Form');
    }

    public function show(Request $request,$id)
    {
        abort_if(!auth()->user()->can('view task'), Response::HTTP_FORBIDDEN, '401 Unauthorized');
        $pages = $request->input('pages', 10);
        $order_by = $request->input('order_by', 'ASC');
        $sort_by = $request->input('sort_by', 'id');

        $task = Task::find($id);
        $documents = $task->documents()
            ->with(['user'])
            ->orderBy($sort_by, $order_by)
            ->paginate($pages)
            ->withQueryString();
        $submitted = $task->submitted()->first();

        return inertia('Task/Show',[
            'data' => $task,
            'documents' => $documents,
            'submitted' => $submitted,
        ]);
    }

    public function store(StoreTaskRequest $request)
    {

        $task_arr = $request->validated();

        $task = Task::create($task_arr);

        return redirect()->back();
    }


    public function update(UpdateTaskRequest $request, $id): \Illuminate\Http\RedirectResponse
    {

        $task_arr = $request->validated();

        $task = Task::find($id);
        $task->update($task_arr);


        return redirect()->back();
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        abort_if(!auth()->user()->can('delete task'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $task = Task::find($id);
        $task->delete();

        return redirect()->back();
    }

    public function saveFile($model,$request){

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

    public function calculatePoints($due_date)
    {
        $days = Carbon::now()->diffInDays(Carbon::parse($due_date), false);

        return match(true) {
            $days >= 10  => 3,
            $days >= 0 && $days < 10 => 2,
            $days >= -10 && $days < 0 => 1,
            $days >= -20 && $days < -10 => -1,
            default => 0,
        };
    }


}
