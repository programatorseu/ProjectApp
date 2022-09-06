<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        @forelse($projects as $project)
        <li><a href="{{$project->path() }}"></a>{{$project->title}}</li>
        @empty
            <li>No projects yet. ! </li>
        @endforelse
    </ul>
</body>
</html>

