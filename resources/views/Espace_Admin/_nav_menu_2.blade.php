<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">

    <li><a href="{{ Route('admin.home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>

    <li><a href="{{ Route('admin.add',['p_table'=>'users']) }}"><i class="fa fa-fw fa-plus"></i> Ajouter User</a></li>

    <li><a href="{{ Route('admin.lister',['p_table'=>'users']) }}"><i class="fa fa-fw fa-desktop"></i> Liste User <span class="badge">{{ App\Models\User::count() }} </span> </a></li>

  </ul>
</div>
<!-- /.navbar-collapse -->
