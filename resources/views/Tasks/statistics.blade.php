
<x-app-layout>
    <x-slot name="header">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>
    <div class="container mt-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Top Users by Task Count</h3>
            </div>
            <div class="card-body">
            @if ($topUsers->isEmpty())
            <p>There are no tasks to display.</p>
            @else
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Task Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->task_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
             @endif
            </div>
        </div>
    </div>
    <script>
    setTimeout(function(){
   location.reload();
    }, 30000);
    </script>
</x-app-layout>
