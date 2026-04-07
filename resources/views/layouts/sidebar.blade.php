
<div class="dlabnav">
    <div class="dlabnav-scroll">    
        <ul class="metismenu" id="menu">
            <li><a class="" href="{{url('home')}}" aria-expanded="false">
                <i class="material-symbols-outlined">home</i>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                <i class="material-symbols-outlined">school</i>
                <span class="nav-text">Student</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{url('students/all')}}">All Student</a></li>
                <li><a href="{{url('students/add')}}">Add New Student</a></li>
            </ul>

        </li>
        @if(Auth::user()->role_id == 1)
        <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="material-symbols-outlined">person</i>
            <span class="nav-text">Users</span>
        </a>
        <ul aria-expanded="false">
            <li><a href="{{url('users/all')}}">All Users</a></li>
            <li><a href="{{url('users/add')}}">Add New User</a></li>
        </ul>
    </li>
    @endif

    <li>
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="material-symbols-outlined">school</i>
            <span class="nav-text">Standard</span>
        </a>
        <ul aria-expanded="false">
            <li><a href="{{url('standards/all')}}">All Standards</a></li>
            <li><a href="{{url('standards/add')}}">Add New Standard</a></li>
        </ul>
    </li>
    <li>
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="material-symbols-outlined">school</i>
            <span class="nav-text">Mediums</span>
        </a>
        <ul aria-expanded="false">
            <li><a href="{{url('mediums/all')}}">All Mediums</a></li>
            <li><a href="{{url('mediums/add')}}">Add New Medium</a></li>
        </ul>
    </li>


    <li>
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
         <i class="material-icons">folder</i>   
         <span class="nav-text">Subjects</span>
     </a>
     <ul aria-expanded="false">
        <li><a href="{{url('subjects/all')}}">All Subjects</a></li>
        <li><a href="{{url('subjects/add')}}">Add New Subject</a></li>

    </ul>
</li>

<li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
 <i class="material-icons">insert_drive_file</i>   
 <span class="nav-text">Chapters</span>
</a>
<ul aria-expanded="false">
    <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Chapters</a>
        <ul aria-expanded="false" class="mm-collapse">
            <li><a href="{{url('chapters/all')}}">All Chapters</a></li>
            <li><a href="{{url('chapters/add')}}">Add Chapter</a></li>
        </ul>
    </li>
    <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Videos</a>
        <ul aria-expanded="false" class="mm-collapse">
            <li><a href="{{url('chapters/format/all')}}?format=video">All Videos</a></li>
            <li><a href="{{url('chapters/format/add')}}?format=video">Add Video</a></li>
        </ul>
    </li>
    <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Audios</a>
        <ul aria-expanded="false" class="mm-collapse">
            <li><a href="{{url('chapters/format/all')}}?format=audio">All Audios</a></li>
            <li><a href="{{url('chapters/format/add')}}?format=audio">Add Audio</a></li>
        </ul>
    </li>
    <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">PDF</a>
        <ul aria-expanded="false" class="mm-collapse">
            <li><a href="{{url('chapters/format/all')}}?format=pdf">All PDFs</a></li>
            <li><a href="{{url('chapters/format/add')}}?format=pdf">Add PDF</a></li>
        </ul>
    </li>
</ul>
</li>


</ul>

</div>
</div>
