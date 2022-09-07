<x-layout>
    @include('_header')
    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <x-card :project="$project"></x-card>
            </div>
        @empty

            <div class="bg-white mr-4 p-5 w-1/3 rounded shadow" style="height:200px;">No projects yet.</div>
        @endforelse

    </main>
</x-layout>