<x-app-layout>
    <x-slot name="header">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Tasks List
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tasks.index') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" name="search" class="form-control" placeholder="Search by title or description" value="{{ request()->get('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                    <a href="{{ route('tasks.create') }}" class="btn btn-success ml-2">Create</a>
                                </div>
                            </div>
                        </form>
                        <table class="table mx-auto">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Assigned To</th>
                                    <th scope="col">Assigned By</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Created Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                <tr>
                                    <th scope="row">{{ $task->id }}</th>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->description }}</td>
                                    <td>{{ $task->assignedTo->name }}</td>
                                    <td>{{ $task->assignedBy->name }}</td>
                                    <td>{{ $task->createdBy->name }}</td>
                                    <td>{{ $task->created_at  }}</td>
                                    <td>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                         
                            {{ $tasks->links() }}
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
