<x-layout>
    <header class="flex items-center mb-3 py-4">

        <div class="flex justify-between items-end w-full">

            <p class="text-grey text-sm font-normal">
               <a href="">My Projects / {{$project->title }}</a> </p>

            <a href="/projects/create" class="button bg-blue">Create project</a>

        </div>

    </header>
    <main>
        <div class="flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6"> 
                <div class="mb-8">
                    <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>
                    @foreach($project->tasks as $task)
                    <div class="card mb-3">
                        <form method="POST" action="{{$task->path()}}">
                            @method('PATCH')
                            @csrf
                            <div class="flex">
                                <input name="body" value="{{$task->body}}" class="w-full" >
                                <input type="checkbox" name="completed" onChange="this.form.submit()" {{$task->completed ? 'checked' : '' }}/>
                            </div>
                        </form>
                    </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{$project->path() . '/tasks'}}" method="POST">
                            @csrf
                            <input name="body" placeholder="Begin adding tasks" class="w-full">

                        </form>
                    </div>
                </div>
                <div class="mb-8"> 
                    <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                                        {{-- general notes --}}
                   <form action="{{$project->path()}}" method="post">
                    @csrf
                    @method('PATCH')
                     <textarea
                     name="notes"
                     class="card w-full"
                     style="min-height: 200px"
                     placeholder="Anything special that you want to make a note of?">{{$project->notes}}</textarea>
                     <button type="submit" class="button">Save</button>
                </form>
                </div>
            </div>
            <div class="lg:w-1/4">
                <x-card :project="$project"></x-card>
            </div>
        </div>
    </main>



</x-layout>