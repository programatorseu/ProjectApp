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
                    <div class="card">lorem ipsum</div>
                </div>
                <div class="mb-8"> 
                    <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                    <div class="card">lorem ipsum.</div>
                </div>
            </div>
            <div class="lg:w-1/4">
                <x-card :project="$project"></x-card>
            </div>
        </div>
    </main>



</x-layout>