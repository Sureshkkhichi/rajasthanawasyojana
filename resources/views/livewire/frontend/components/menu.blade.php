<ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
    @foreach ($project_list as $project)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('project.show', $project->slug) }}">{{ $project->name }}</a>
        </li>
    @endforeach

</ul>